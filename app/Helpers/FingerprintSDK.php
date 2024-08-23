<?php

namespace App\Helpers;

use App\Jobs\AttendanceSyncJob;

class FingerprintSDK
{
    protected $ip = '192.168.20.221';
    protected $key = 0;

    public function Parse_Data($data, $p1, $p2)
    {
        $data = " " . $data;
        $hasil = "";
        $awal = strpos($data, $p1);

        if ($awal != "") {
            $akhir = strpos(strstr($data, $p1), $p2);
            if ($akhir != "") {
                $hasil = substr($data, $awal + strlen($p1), $akhir - strlen($p1));
            }
        }

        return $hasil;
    }

    public function getAttendance()
    {
        $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);
        if ($Connect) {
            $soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $this->key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";

            $newLine = "\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
            fputs($Connect, "Content-Type: text/xml" . $newLine);
            fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
            fputs($Connect, $soap_request . $newLine);
            $buffer = "";
            while ($Response = fgets($Connect, 1024)) {
                $buffer = $buffer . $Response;
            }
        } else return false;


        $buffer = $this->Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
        $buffer = trim($buffer); // Menghapus spasi di awal dan akhir string
        $buffer = explode("\r\n", $buffer);
        // dd($buffer);
        $send = [];
        for ($a = 0; $a < count($buffer); $a++) {
            $data = $this->Parse_Data($buffer[$a], "<Row>", "</Row>");
            $send[$a]['UID'] = $a + 1;
            $send[$a]['PIN'] = $this->Parse_Data($data, "<PIN>", "</PIN>");
            $send[$a]['DateTime'] = $this->Parse_Data($data, "<DateTime>", "</DateTime>");
            $send[$a]['Verified'] = $this->Parse_Data($data, "<Verified>", "</Verified>");
            $send[$a]['Status'] = $this->Parse_Data($data, "<Status>", "</Status>");

            // AttendanceSyncJob::dispatch($send);
        }

        return $send;
    }
}

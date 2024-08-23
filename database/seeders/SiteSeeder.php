<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/sites.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Site table seeded!');

        // Site::insert([
        //     [
        //         'id' => '1',
        //         'uid' => 'jphyCdbGedxVsjN',
        //         'name' => 'Yayasan Pendidikan Tinggi Tarakanita (Jakarta )',
        //         'qr_code' => 'jphyCdbGedxVsjN.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '2',
        //         'uid' => 'l1T1q5E0txqjcAs',
        //         'name' => 'PT. Panen Lestari Internusa (Tunjungan Plaza- Surabaya)',
        //         'qr_code' => 'l1T1q5E0txqjcAs.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '3',
        //         'uid' => 'EJNxy0BocLRpb5t',
        //         'name' => 'Yayasan Pendidikan Tinggi Tarakanita (Jakarta )',
        //         'qr_code' => 'EJNxy0BocLRpb5t.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '4',
        //         'uid' => 'f1VioxLrNvLNmpL',
        //         'name' => 'Max Fashion - Pondok Indah Mall (Jakarta)',
        //         'qr_code' => 'f1VioxLrNvLNmpL.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '5',
        //         'uid' => 'iB7E7OB1ycmTWFD',
        //         'name' => 'Max Fashion - Central Park Mall (Jakarta)',
        //         'qr_code' => 'iB7E7OB1ycmTWFD.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '6',
        //         'uid' => 'ZPQmcXaWDtTn1ID',
        //         'name' => 'Max Fashion - Lippo Mall Puri (Jakarta)',
        //         'qr_code' => 'ZPQmcXaWDtTn1ID.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '7',
        //         'uid' => 'U8ov2EE4gBsqqBS',
        //         'name' => 'Max Fashion - Lotte Shopping Avenue (Jakarta)',
        //         'qr_code' => 'U8ov2EE4gBsqqBS.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '8',
        //         'uid' => 'uZEhwpmM2SFlBCi',
        //         'name' => 'Baby Shop - Pondok Indah Mall (Jakarta)',
        //         'qr_code' => 'uZEhwpmM2SFlBCi.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '9',
        //         'uid' => '3pGQ2KfmZ4WuAvA',
        //         'name' => 'Baby Shop - Lippo Mall Puri (Jakarta)',
        //         'qr_code' => '3pGQ2KfmZ4WuAvA.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '10',
        //         'uid' => 'WQDMuEZ735w4VJb',
        //         'name' => 'Baby Shop - Mall Kelapa Gading  (Jakarta)',
        //         'qr_code' => 'WQDMuEZ735w4VJb.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '11',
        //         'uid' => 'm73eYT0JpcyDevC',
        //         'name' => 'Max Fashion - Aeon Mall Sentul (Bogor)',
        //         'qr_code' => 'm73eYT0JpcyDevC.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '12',
        //         'uid' => '0cLbfMk8i43qboV',
        //         'name' => 'Max Fashion - Bintaro Jaya Xchange (Bintaro)',
        //         'qr_code' => '0cLbfMk8i43qboV.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '13',
        //         'uid' => 'rfQ6FlqOAmslimC',
        //         'name' => 'Max Fashion - Aeon Mall BSD (BSD)',
        //         'qr_code' => 'rfQ6FlqOAmslimC.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '14',
        //         'uid' => '9QR7N9GrwIyAscw',
        //         'name' => 'Max Fashion - Margocity Mall (Depok)',
        //         'qr_code' => '9QR7N9GrwIyAscw.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '15',
        //         'uid' => 'os1YMRSd0ksYITz',
        //         'name' => 'Baby Shop - Margocity Mall (Depok)',
        //         'qr_code' => 'os1YMRSd0ksYITz.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '16',
        //         'uid' => 'aa4NdmDFCxB8ji9',
        //         'name' => 'Max Fashion - Grand Metropolitan Mall (Bekasi)',
        //         'qr_code' => 'aa4NdmDFCxB8ji9.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '17',
        //         'uid' => 'uW1ipxqGlGEZcqn',
        //         'name' => 'PT. Pembangunan Jaya Ancol, Tbk',
        //         'qr_code' => 'uW1ipxqGlGEZcqn.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '18',
        //         'uid' => 'itxEjJNT5yqaDNL',
        //         'name' => 'PT. Bringin Karya Sejahtera',
        //         'qr_code' => 'itxEjJNT5yqaDNL.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '19',
        //         'uid' => 'oYMLnbG1OelCn4T',
        //         'name' => 'PT. Digital Analisis Tehnologi Andalan',
        //         'qr_code' => 'oYMLnbG1OelCn4T.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '20',
        //         'uid' => '7Mlht24lXUYfWLa',
        //         'name' => 'PT. Mahkota Sentosa Utama',
        //         'qr_code' => '7Mlht24lXUYfWLa.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '21',
        //         'uid' => '0rOEQNTKcVJ9GNv',
        //         'name' => 'PT. Panen Lestari Internusa (Sogo Pakuwon Mall)',
        //         'qr_code' => '0rOEQNTKcVJ9GNv.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '22',
        //         'uid' => 'PGcy1zybu8U0cUa',
        //         'name' => 'PT. Panen Lestari Internusa (Sogo Tunjungan Plaza)',
        //         'qr_code' => 'PGcy1zybu8U0cUa.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '23',
        //         'uid' => 'zJYfj717Hphy6cM',
        //         'name' => 'PT. Panen Lestari Internusa (Sogo Kota Kasablanka)',
        //         'qr_code' => 'zJYfj717Hphy6cM.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '24',
        //         'uid' => '8xUSWTLtvYSmHIZ',
        //         'name' => 'PT. Panen Lestari Internusa (Sogo Galaxy Mall)',
        //         'qr_code' => '8xUSWTLtvYSmHIZ.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '25',
        //         'uid' => 'VRAFemR9NzRlikx',
        //         'name' => 'PT. Panen Lestari Internusa (Sogo Pondok Indah Mall)',
        //         'qr_code' => 'VRAFemR9NzRlikx.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '26',
        //         'uid' => 't4iiR7TIdVzjyUP',
        //         'name' => 'PT. Panen Lestari Internusa (Sogo Central Park)',
        //         'qr_code' => 't4iiR7TIdVzjyUP.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '27',
        //         'uid' => 'WxnQ5mnB0dknmdQ',
        //         'name' => 'PT. Panen Lestari Internusa (Sogo Plaza Senayan)',
        //         'qr_code' => 'WxnQ5mnB0dknmdQ.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '28',
        //         'uid' => 'RhQ7Ge40xPaXFEt',
        //         'name' => 'PT. Panen Lestari Internusa (Sogo Mall Kelapa Gading)',
        //         'qr_code' => 'RhQ7Ge40xPaXFEt.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '29',
        //         'uid' => 's6xujkfQEFeoKwT',
        //         'name' => 'PT. Panen GL Indonesia (Galeries Lafayette)',
        //         'qr_code' => 's6xujkfQEFeoKwT.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '30',
        //         'uid' => 'GD6scnfMQhZUoZI',
        //         'name' => 'PT. Panen Selaras Intibuana (Seibu Grand Indonesia)',
        //         'qr_code' => 'GD6scnfMQhZUoZI.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '31',
        //         'uid' => 'xKJfusgPYYY7pzx',
        //         'name' => 'PT. Panen Selaras Intibuana (Seibu Pondok Indah Mall)',
        //         'qr_code' => 'xKJfusgPYYY7pzx.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '32',
        //         'uid' => 'BPXlhcili2j51Mn',
        //         'name' => 'PT. Swalayan Sukses Abadi (Foodhall FX Sudirman)',
        //         'qr_code' => 'BPXlhcili2j51Mn.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '33',
        //         'uid' => 'Fxrh6yWQcZ5nMpK',
        //         'name' => 'PT. Swalayan Sukses Abadi (Foodhall Neo Soho)',
        //         'qr_code' => 'Fxrh6yWQcZ5nMpK.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '34',
        //         'uid' => 'hOTxXkq93hHHyqN',
        //         'name' => 'PT. Swalayan Sukses Abadi (Foodhall Mall Kelapa Gading)',
        //         'qr_code' => 'hOTxXkq93hHHyqN.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '35',
        //         'uid' => 'Dq6wbQi9xxRc2NI',
        //         'name' => 'PT. Swalayan Sukses Abadi (Foodhall Sunter Mall)',
        //         'qr_code' => 'Dq6wbQi9xxRc2NI.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '36',
        //         'uid' => 'C9rtIZkVvxF65hr',
        //         'name' => 'PT. Swalayan Sukses Abadi (Foodhall Grand Indonesia)',
        //         'qr_code' => 'C9rtIZkVvxF65hr.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '37',
        //         'uid' => 'UMR8Cz7J12DZIH6',
        //         'name' => 'PT. Swalayan Sukses Abadi (Foodhall Senayan City)',
        //         'qr_code' => 'UMR8Cz7J12DZIH6.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '38',
        //         'uid' => 'mgGTcJSQj1ylHo6',
        //         'name' => 'PT. Swalayan Sukses Abadi (Foodhall Pondok Indah Mall)',
        //         'qr_code' => 'mgGTcJSQj1ylHo6.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '39',
        //         'uid' => 'n3iwOXHR4vTKSNp',
        //         'name' => 'PT. Swalayan Sukses Abadi (Daily Foodhall Kemayoran)',
        //         'qr_code' => 'n3iwOXHR4vTKSNp.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '40',
        //         'uid' => '6BKw0LvlQzGxxxP',
        //         'name' => 'PT. Swalayan Sukses Abadi (Daily Foodhall Pamulang)',
        //         'qr_code' => '6BKw0LvlQzGxxxP.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '41',
        //         'uid' => '0mVGoAMBqRqhUCf',
        //         'name' => 'PT. Jakarta Inti Land (JIL Karawang)',
        //         'qr_code' => '0mVGoAMBqRqhUCf.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '42',
        //         'uid' => 'tx7Bwgbu3LGOq3f',
        //         'name' => 'PT. Jakarta Inti Land ( JIL Lampung)',
        //         'qr_code' => 'tx7Bwgbu3LGOq3f.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '43',
        //         'uid' => 'AEok603jBAVWMDj',
        //         'name' => 'PT. Jakarta Inti Land ( Jil Kediri)',
        //         'qr_code' => 'AEok603jBAVWMDj.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '44',
        //         'uid' => 'H2VX6BAnum0qrOw',
        //         'name' => 'PT. Jakarta Inti Land (JIL Cirebon)',
        //         'qr_code' => 'H2VX6BAnum0qrOw.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '45',
        //         'uid' => '9ExAWwTwGfhKKxc',
        //         'name' => 'PT. Logamindo Sarimulia (Sidoarjo)',
        //         'qr_code' => '9ExAWwTwGfhKKxc.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '46',
        //         'uid' => 'yqkKYzRMLFP5UMK',
        //         'name' => 'PT. Sarana Maju Lestari (Jakarta)',
        //         'qr_code' => 'yqkKYzRMLFP5UMK.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '47',
        //         'uid' => 'CblLz8l3JXS5H0m',
        //         'name' => 'Yayasan Tarakanita (SD, SMP dan SMA)',
        //         'qr_code' => 'CblLz8l3JXS5H0m.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '48',
        //         'uid' => 'oBkf452YspTQKnC',
        //         'name' => 'PT. Eka Mas Republik (My Republik)',
        //         'qr_code' => 'oBkf452YspTQKnC.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '49',
        //         'uid' => 'Fw0gQyawS8RSGtJ',
        //         'name' => 'PT. Pakarti Yoga (Jakarta)',
        //         'qr_code' => 'Fw0gQyawS8RSGtJ.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '50',
        //         'uid' => 'n6ManpRWE1QiBpn',
        //         'name' => 'PT. Pakarti Yoga - Rawamaja (Jakarta)',
        //         'qr_code' => 'n6ManpRWE1QiBpn.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '51',
        //         'uid' => '20PKWc8zsMnxxW1',
        //         'name' => 'PT. Pakarti Jaya (Jakarta)',
        //         'qr_code' => '20PKWc8zsMnxxW1.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '52',
        //         'uid' => 'Kxh80MSJivEkd8n',
        //         'name' => 'PT. Pakarti Jaya - Cikarang',
        //         'qr_code' => 'Kxh80MSJivEkd8n.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '53',
        //         'uid' => 'pAFOvbk5Mao62q0',
        //         'name' => 'PT. Asean Motor International',
        //         'qr_code' => 'pAFOvbk5Mao62q0.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '54',
        //         'uid' => 'vCMFNzF37wUzkB2',
        //         'name' => 'PT. Panen Wangi Abadi (Sephora Pondok Indah Mall)',
        //         'qr_code' => 'vCMFNzF37wUzkB2.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '55',
        //         'uid' => 'orJNM8S9eOwJZyy',
        //         'name' => 'PT. Panen Wangi Abadi (Sephora Senayan City)',
        //         'qr_code' => 'orJNM8S9eOwJZyy.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '56',
        //         'uid' => 'yWg5xHH1DvMmfgY',
        //         'name' => 'PT. Panen Wangi Abadi (Sephora Central Park)',
        //         'qr_code' => 'yWg5xHH1DvMmfgY.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '57',
        //         'uid' => 'ByfTIwsgY03kXX2',
        //         'name' => 'PT. Panen Wangi Abadi (Sephora Grand Indonesia)',
        //         'qr_code' => 'ByfTIwsgY03kXX2.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '58',
        //         'uid' => 'PvpyfZtC6Z2IBOl',
        //         'name' => 'PT. Panen Wangi Abadi (Sephora Gandaria City)',
        //         'qr_code' => 'PvpyfZtC6Z2IBOl.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '59',
        //         'uid' => 'CE2vJiGXZmMETpi',
        //         'name' => 'PT. Panen Wangi Abadi (Sephora Kota Kasablanka)',
        //         'qr_code' => 'CE2vJiGXZmMETpi.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '60',
        //         'uid' => '4Fsc2Bhdlm2AvOY',
        //         'name' => 'PT. Panen Wangi Abadi (Sephora Plaza Senayan)',
        //         'qr_code' => '4Fsc2Bhdlm2AvOY.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '61',
        //         'uid' => 'xKRCyOwS3qJP7rt',
        //         'name' => 'PT. Panen Wangi Abadi (Sephora Mall Kelapa Gading)',
        //         'qr_code' => 'xKRCyOwS3qJP7rt.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '62',
        //         'uid' => 'M2mqn3FW5o740MW',
        //         'name' => 'PT. Panen Wangi Abadi (Sephora Delipark Medan)',
        //         'qr_code' => 'M2mqn3FW5o740MW.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '63',
        //         'uid' => 'RXvmVHcRu1JJYvK',
        //         'name' => 'PT. Bersama Karunia Mandiri (Berskha Grand Indonesia)',
        //         'qr_code' => 'RXvmVHcRu1JJYvK.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '64',
        //         'uid' => 'oZzxrkqY0QY8kzw',
        //         'name' => 'PT. Mitra Selaras Sempurna Ritel (Marks & Spencer Grand Indonesia)',
        //         'qr_code' => 'oZzxrkqY0QY8kzw.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '65',
        //         'uid' => 'l7by69eO9OJITgp',
        //         'name' => 'PT. Mitra Selaras Sempurna Ritel (Marks & Spencer Plaza Senayan)',
        //         'qr_code' => 'l7by69eO9OJITgp.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '66',
        //         'uid' => 'gQBf5g5mgaQj1Ox',
        //         'name' => 'PT. Sarimode Fashindo Adiperkasa Ritel (Zara Plaza Senayan)',
        //         'qr_code' => 'gQBf5g5mgaQj1Ox.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '67',
        //         'uid' => 'Hto2qRdnxODm46f',
        //         'name' => 'PT. Kinokunia Pustaka Indonesia (Kinokuniya Grand Indonesia)',
        //         'qr_code' => 'Hto2qRdnxODm46f.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '68',
        //         'uid' => 'AlbowmXfXJpa51c',
        //         'name' => 'PT. Mitsubishi Electric Automotive Indonesia (Cikarang)',
        //         'qr_code' => 'AlbowmXfXJpa51c.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '69',
        //         'uid' => '8WiaUOGlXx0y2PT',
        //         'name' => 'Unaids Office Jakarta',
        //         'qr_code' => '8WiaUOGlXx0y2PT.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '70',
        //         'uid' => 'vghgeVimB77KzUc',
        //         'name' => 'PT. Hema Medhajaya (Tangerang)',
        //         'qr_code' => 'vghgeVimB77KzUc.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '71',
        //         'uid' => 'wk7yImfzekUkXXd',
        //         'name' => 'PT. Alter Abadi (Belitung)',
        //         'qr_code' => 'wk7yImfzekUkXXd.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '72',
        //         'uid' => '4XmED4mmFxLHfEF',
        //         'name' => 'PT. Asia Putra Perkasa (Jakarta)',
        //         'qr_code' => '4XmED4mmFxLHfEF.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '73',
        //         'uid' => 'u5lSigqkSC494O5',
        //         'name' => 'Green Montesorri School (Jakarta)',
        //         'qr_code' => 'u5lSigqkSC494O5.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '74',
        //         'uid' => 'h9xjCHifR0wVp94',
        //         'name' => 'PT. Abhimata Citra Abadi',
        //         'qr_code' => 'h9xjCHifR0wVp94.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '75',
        //         'uid' => 'sOmydd0TLTFe6CK',
        //         'name' => 'PT. Bollore Logistics Indonesia',
        //         'qr_code' => 'sOmydd0TLTFe6CK.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '76',
        //         'uid' => 'LP0fJi4lUgjStNy',
        //         'name' => 'PT. Smartfren',
        //         'qr_code' => 'LP0fJi4lUgjStNy.png',
        //         'created_at'    => date('Y-m-d H:i:s')
        //     ], [
        //         'id' => '77',
        //         'uid' => 'r3ZSaA5pWgWupwK',
        //         'name' => 'Gudang Batam',
        //         'qr_code' => 'r3ZSaA5pWgWupwK.png',
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ], [
        //         'id' => '78',
        //         'uid' => 'dq4FhmC9qwam5pt',
        //         'name' => 'Gudang Medan',
        //         'qr_code' => 'dq4FhmC9qwam5pt.png',
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ], [
        //         'id' => '79',
        //         'uid' => 'aC4x5hA3wnAKRKf',
        //         'name' => 'Gudang Pekanbaru',
        //         'qr_code' => 'aC4x5hA3wnAKRKf.png',
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ], [
        //         'id' => '80',
        //         'uid' => '51x15VjegOFu6wA',
        //         'name' => 'Gudang Palembang',
        //         'qr_code' => '51x15VjegOFu6wA.png',
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ], [
        //         'id' => '81',
        //         'uid' => 'sOMbSKiBDPhBWen',
        //         'name' => 'Gudang Surabaya',
        //         'qr_code' => 'sOMbSKiBDPhBWen.png',
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ], [
        //         'id' => '82',
        //         'uid' => 'JFtPXaMSNjw5wJw',
        //         'name' => 'Gudang Manis',
        //         'qr_code' => 'JFtPXaMSNjw5wJw.png',
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ], [
        //         'id' => '83',
        //         'uid' => 'JIQ4tuUEQQxm5ec',
        //         'name' => 'Gudang Gunung Sahari',
        //         'qr_code' => 'JIQ4tuUEQQxm5ec.png',
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ], [
        //         'id' => '84',
        //         'uid' => 'DNevn0QTWnkLiFW',
        //         'name' => 'Head Office TPM Group',
        //         'qr_code' => 'DNevn0QTWnkLiFW.png',
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'id' => 85,
        //         'uid' => 'ZoGn6Xr7Eqy5Mdi',
        //         'name' => 'Branch Office Surabaya',
        //         'qr_code' => 'ZoGn6Xr7Eqy5Mdi.png',
        //         'created_at' => date('Y-m-d H:i:s')
        //     ]
        // ]);
    }
}

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="generator" content="PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet">
    <meta name="author" content="DESIGN-PC" />
    <title>Slip Gaji {{ $sallary_slip->employee->user->name }} Periode
        {{ date('d M Y', strtotime($sallary_slip->periode->periode_start)) }} -
        {{ date('d M Y', strtotime($sallary_slip->periode->periode_end)) }}</title>
    <style type="text/css">
        html {
            font-family: Calibri, Arial, Helvetica, sans-serif;
            font-size: 11pt;
            background-color: white
        }

        a.comment-indicator:hover+div.comment {
            background: #ffd;
            position: absolute;
            display: block;
            border: 1px solid black;
            padding: 0.5em
        }

        a.comment-indicator {
            background: red;
            display: inline-block;
            border: 1px solid black;
            width: 0.5em;
            height: 0.5em
        }

        div.comment {
            display: none
        }

        table {
            border-collapse: collapse;
            page-break-after: always
        }

        .gridlines td {
            border: 1px dotted black
        }

        .gridlines th {
            border: 1px dotted black
        }

        .b {
            text-align: center
        }

        .e {
            text-align: center
        }

        .f {
            text-align: right
        }

        .inlineStr {
            text-align: left
        }

        .n {
            text-align: right
        }

        .s {
            text-align: left
        }

        td.style0 {
            vertical-align: bottom;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style0 {
            vertical-align: bottom;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style1 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        th.style1 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        td.style2 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #FFFFFF;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #737373
        }

        th.style2 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #FFFFFF;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #737373
        }

        td.style3 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        th.style3 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        td.style4 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        th.style4 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        td.style5 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #E7E6E6
        }

        th.style5 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #E7E6E6
        }

        td.style6 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #E7E6E6
        }

        th.style6 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #E7E6E6
        }

        td.style7 {
            vertical-align: middle;
            text-align: right;
            padding-right: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        th.style7 {
            vertical-align: middle;
            text-align: right;
            padding-right: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        td.style8 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        th.style8 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        td.style9 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #E7E6E6
        }

        th.style9 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #E7E6E6
        }

        td.style10 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #E7E6E6
        }

        th.style10 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #E7E6E6
        }

        td.style11 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        th.style11 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        td.style12 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        th.style12 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        td.style13 {
            vertical-align: middle;
            text-align: right;
            padding-right: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        th.style13 {
            vertical-align: middle;
            text-align: right;
            padding-right: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        td.style14 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 16pt;
            background-color: white
        }

        th.style14 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 16pt;
            background-color: white
        }

        td.style15 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        th.style15 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        td.style16 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #FFFFFF;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #737373
        }

        th.style16 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #FFFFFF;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #737373
        }

        td.style17 {
            vertical-align: middle;
            text-align: right;
            padding-right: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        th.style17 {
            vertical-align: middle;
            text-align: right;
            padding-right: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: white
        }

        td.style18 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #E7E6E6
        }

        th.style18 {
            vertical-align: middle;
            text-align: left;
            padding-left: 9px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Times New Roman';
            font-size: 11pt;
            background-color: #E7E6E6
        }

        table.sheet0 col.col0 {
            width: 69.81111031pt
        }

        table.sheet0 col.col1 {
            width: 69.81111031pt
        }

        table.sheet0 col.col2 {
            width: 69.81111031pt
        }

        table.sheet0 col.col3 {
            width: 8.81111101pt
        }

        table.sheet0 col.col4 {
            width: 69.81111031pt
        }

        table.sheet0 col.col5 {
            width: 7.45555547pt
        }

        table.sheet0 col.col6 {
            width: 93.53333226pt
        }

        table.sheet0 col.col7 {
            width: 70.48888808pt
        }

        table.sheet0 col.col8 {
            width: 70.48888808pt
        }

        table.sheet0 col.col9 {
            width: 10.16666655pt
        }

        table.sheet0 col.col10 {
            width: 70.48888808pt
        }

        table.sheet0 col.col11 {
            width: 43.37777728pt
        }

        table.sheet0 tr {
            height: 15pt
        }

        table.sheet0 tr.row0 {
            height: 33.75pt
        }

        table.sheet0 tr.row1 {
            height: 11.25pt
        }

        table.sheet0 tr.row2 {
            height: 21pt
        }

        table.sheet0 tr.row3 {
            height: 21pt
        }

        table.sheet0 tr.row4 {
            height: 21pt
        }

        table.sheet0 tr.row5 {
            height: 21pt
        }

        table.sheet0 tr.row6 {
            height: 12pt
        }

        table.sheet0 tr.row7 {
            height: 24.75pt
        }

        table.sheet0 tr.row8 {
            height: 18.75pt
        }

        table.sheet0 tr.row9 {
            height: 18.75pt
        }

        table.sheet0 tr.row10 {
            height: 18.75pt
        }

        table.sheet0 tr.row11 {
            height: 18.75pt
        }

        table.sheet0 tr.row12 {
            height: 18.75pt
        }

        table.sheet0 tr.row13 {
            height: 18.75pt
        }

        table.sheet0 tr.row14 {
            height: 18.75pt
        }

        table.sheet0 tr.row15 {
            height: 24.75pt
        }

        table.sheet0 tr.row16 {
            height: 9pt
        }

        table.sheet0 tr.row17 {
            height: 27pt
        }

        table.sheet0 tr.row24 {
            height: 15pt
        }

        table.sheet0 tr.row25 {
            height: 17.25pt
        }
    </style>
</head>

<body>
    <style>
        @page {
            margin-left: 0.1in;
            margin-right: 0.1in;
            margin-top: 0.1in;
            margin-bottom: 0.1in;
        }

        body {
            margin-left: 0.1in;
            margin-right: 0.1in;
            margin-top: 0.1in;
            margin-bottom: 0.1in;
        }
    </style>
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <col class="col11">
        <tbody>
            <tr class="row0">
                <td class="column0 style14 s style14" colspan="11">SLIP GAJI</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row1">
                <td class="column0">&nbsp;</td>
                <td class="column1">&nbsp;</td>
                <td class="column2">&nbsp;</td>
                <td class="column3">&nbsp;</td>
                <td class="column4">&nbsp;</td>
                <td class="column5">&nbsp;</td>
                <td class="column6">&nbsp;</td>
                <td class="column7">&nbsp;</td>
                <td class="column8">&nbsp;</td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row2">
                <td class="column0 style15 s style15" colspan="2">ID/Nama</td>
                <td class="column2 style8 s" colspan="5">
                    {{ $sallary_slip->employee->id }}/{{ $sallary_slip->employee->user->name }}</td>
                <td class="column3">&nbsp;</td>
                <td class="column4">&nbsp;</td>
                <td class="column5 style8 null"></td>
                <td class="column6 style15 null style15" colspan="2"></td>
                <td class="column8 style8 null"></td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row3">
                <td class="column0 style15 s style15" colspan="2">Jabatan</td>
                <td class="column2 style8 s" colspan="5">{{ $sallary_slip->employee->position->name ?? '-' }}</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style15 null style15" colspan="2"></td>
                <td class="column8 style8 null"></td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row4">
                <td class="column0 style15 s style15" colspan="2">Lokasi</td>
                <td class="column2 style8 s" colspan="5">Head Office</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style8 null"></td>
                <td class="column7 style8 null"></td>
                <td class="column8 style8 null"></td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row5">
                <td class="column0 style15 s style15" colspan="2">Periode</td>
                <td class="column2 style8 s" colspan="5">
                    {{ date('d M Y', strtotime($sallary_slip->periode->periode_start)) }} -
                    {{ date('d M Y', strtotime($sallary_slip->periode->periode_end)) }}
                </td>
                <td class="column3 style8 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style15 null style15" colspan="2"></td>
                <td class="column8 style8 null"></td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row6">
                <td class="column0">&nbsp;</td>
                <td class="column1">&nbsp;</td>
                <td class="column2">&nbsp;</td>
                <td class="column3">&nbsp;</td>
                <td class="column4">&nbsp;</td>
                <td class="column5">&nbsp;</td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style8 null"></td>
                <td class="column8">&nbsp;</td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row7">
                <td class="column0 style16 s style16" colspan="5">PENERIMAAN</td>
                <td class="column5">&nbsp;</td>
                <td class="column6 style16 s style16" colspan="5">PENERIMAAN</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row8">
                <td class="column0 style15 s style15" colspan="3">Gaji Pokok</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style13 n">&nbsp;&nbsp;{{ number_format($sallary_slip->gaji_pokok) }} </td>
                <td class="column5">&nbsp;</td>
                <td class="column6 style15 s style15" colspan="3">Potongan PPh21</td>
                <td class="column9">&nbsp;</td>
                <td class="column10 style7 n">{{ number_format($sallary_slip->pot_pph21) }} &nbsp;&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row9">
                <td class="column0 style15 s style15" colspan="3">Tunj. Pulsa</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style13 s">{{ number_format($sallary_slip->tunj_pulsa) }}</td>
                <td class="column5">&nbsp;</td>
                <td class="column6 style15 s style15" colspan="3">Potongan BPJS TK</td>
                <td class="column9">&nbsp;</td>
                <td class="column10 style7 n">{{ number_format($sallary_slip->pot_bpjs_tk) }} &nbsp;&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row10">
                <td class="column0 style15 s style15" colspan="3">Tunj. Jabatan</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style13 s">{{ number_format($sallary_slip->tunj_jabatan) }}</td>
                <td class="column5">&nbsp;</td>
                <td class="column6 style15 s style15" colspan="3">Potongan Jaminan Pensiun</td>
                <td class="column9">&nbsp;</td>
                <td class="column10 style7 n">{{ number_format($sallary_slip->pot_jaminan_pensiun) }} &nbsp;&nbsp;
                </td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row11">
                <td class="column0 style15 s style15" colspan="3">Tunj. Transport</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style13 s">{{ number_format($sallary_slip->tunj_transport) }}</td>
                <td class="column5">&nbsp;</td>
                <td class="column6 style15 s style15" colspan="3">Potongan BPJS Kesehatan</td>
                <td class="column9">&nbsp;</td>
                <td class="column10 style7 s">{{ number_format($sallary_slip->pot_bpjs_kesehatan) }} &nbsp;&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row12">
                <td class="column0 style15 s style15" colspan="3">Tunj. Makan</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style13 s">{{ number_format($sallary_slip->tunj_makan) }}</td>
                <td class="column5">&nbsp;</td>
                <td class="column6 style15 s style15" colspan="3">Potongan Pinjaman</td>
                <td class="column9">&nbsp;</td>
                <td class="column10 style7 s">{{ number_format($sallary_slip->pot_pinjaman) }} &nbsp;&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row13">
                <td class="column0 style15 s style15" colspan="3">Tunj. Lain-lain</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style13 s">{{ number_format($sallary_slip->tunj_lain_lain) }}</td>
                <td class="column5">&nbsp;</td>
                <td class="column6 style15 s style15" colspan="3">Potongan Keterlambatan</td>
                <td class="column9">&nbsp;</td>
                <td class="column10 style7 s">{{ number_format($sallary_slip->pot_keterlambatan) }} &nbsp;&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row14">
                <td class="column0 style15 s style15" colspan="3">Revisi (+)</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style13 s">{{ number_format($sallary_slip->revisi) }}</td>
                <td class="column5">&nbsp;</td>
                <td class="column6 style15 s style15" colspan="3">Potongan Daily Report</td>
                <td class="column9">&nbsp;</td>
                <td class="column10 style7 s">{{ number_format($sallary_slip->pot_daily_report) }} &nbsp;&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row15">
                <td class="column0 style18 s style18" colspan="3">TOTAL PENERIMAAN</td>
                <td class="column3 style9 null"></td>
                <td class="column4 style10 n">&nbsp;&nbsp;5,000,000 </td>
                <td class="column5">&nbsp;</td>
                <td class="column6 style18 s style18" colspan="3">TOTAL PENERIMAAN</td>
                <td class="column9 style5 null"></td>
                <td class="column10 style6 n">5,000,000 &nbsp;&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row16">
                <td class="column0 style1 null"></td>
                <td class="column1 style1 null"></td>
                <td class="column2">&nbsp;</td>
                <td class="column3">&nbsp;</td>
                <td class="column4">&nbsp;</td>
                <td class="column5">&nbsp;</td>
                <td class="column6">&nbsp;</td>
                <td class="column7">&nbsp;</td>
                <td class="column8">&nbsp;</td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row17">
                <td class="column0 style16 s style16" colspan="3">TAKE HOME PAY (THP)</td>
                <td class="column3">&nbsp;</td>
                <td class="column4 style2 n">&nbsp;&nbsp;{{ number_format($sallary_slip->thp) }} </td>
                <td class="column5">&nbsp;</td>
                <td class="column6">&nbsp;</td>
                <td class="column7">&nbsp;</td>
                <td class="column8">&nbsp;</td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row18">
                <td class="column0">&nbsp;</td>
                <td class="column1">&nbsp;</td>
                <td class="column2">&nbsp;</td>
                <td class="column3">&nbsp;</td>
                <td class="column4">&nbsp;</td>
                <td class="column5">&nbsp;</td>
                <td class="column6">&nbsp;</td>
                <td class="column7">&nbsp;</td>
                <td class="column8">&nbsp;</td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row19">
                <td class="column0 style8 s">DI TRANSFER KE</td>
                <td class="column1 style8 null"></td>
                <td class="column2 style8 null"></td>
                <td class="column3 style8 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style8 null"></td>
                <td class="column7 style17 s style17" colspan="4">JAKARTA, {{ date('d M Y') }}</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row20">
                <td class="column0 style15 s style15" colspan="2">BCA 5515784481 a/n Sifa</td>
                <td class="column2 style8 null"></td>
                <td class="column3 style8 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7">&nbsp;</td>
                <td class="column8">&nbsp;</td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row21">
                <td class="column0 style8 null"></td>
                <td class="column1 style8 null"></td>
                <td class="column2 style8 null"></td>
                <td class="column3 style8 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style3 s">DISETUJUI OLEH</td>
                <td class="column7 style8 null"></td>
                <td class="column8 style3 s">DITERIMA OLEH</td>
                <td class="column9 style8 null"></td>
                <td class="column10 style8 null"></td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row22">
                <td class="column0 style11 s">Catatan:</td>
                <td class="column1 style8 null"></td>
                <td class="column2 style8 null"></td>
                <td class="column3 style8 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style8 null"></td>
                <td class="column7 style8 null"></td>
                <td class="column8 style8 null"></td>
                <td class="column9 style8 null"></td>
                <td class="column10 style8 null"></td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row23">
                <td class="column0 style12 s">Hari Kerja</td>
                <td class="column1 style8 n" style="text-align: right">22</td>
                <td class="column2 style8 s">Hari</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style8 null"></td>
                <td class="column7 style8 null"></td>
                <td class="column8 style8 null"></td>
                <td class="column9 style8 null"></td>
                <td class="column10 style8 null"></td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row24">
                <td class="column0 style8 s">Sakit</td>
                <td class="column1 style12 s" style="text-align: right">-</td>
                <td class="column2 style12 s">Hari</td>
                <td class="column3 style12 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style8 null"></td>
                <td class="column7 style8 null"></td>
                <td class="column8 style8 null"></td>
                <td class="column9 style8 null"></td>
                <td class="column10 style8 null"></td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row25">
                <td class="column0 style8 s">Izin</td>
                <td class="column1 style12 s" style="text-align: right">-</td>
                <td class="column2 style12 s">Hari</td>
                <td class="column3 style12 null"></td>
                <td class="column4 style12 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style8 null"></td>
                <td class="column7 style8 null"></td>
                <td class="column8 style8 null"></td>
                <td class="column9 style8 null"></td>
                <td class="column10 style8 null"></td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row26">
                <td class="column0 style12 s">Alpha</td>
                <td class="column1 style12 s" style="text-align: right">-</td>
                <td class="column2 style12 s">Hari</td>
                <td class="column3 style12 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style3 s">MELISSA GRAY</td>
                <td class="column7 style8 null"></td>
                <td class="column8 style3 s">JOHN DOE</td>
                <td class="column9 style8 null"></td>
                <td class="column10 style8 null"></td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row27">
                <td class="column0 style8 s">Cuti</td>
                <td class="column1 style8 s" style="text-align: right">-</td>
                <td class="column2 style8 s">Hari</td>
                <td class="column3 style8 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style3 s">HR/GA DIRECTOR</td>
                <td class="column7 style8 null"></td>
                <td class="column8 style8 null"></td>
                <td class="column9 style8 null"></td>
                <td class="column10 style8 null"></td>
                <td class="column11">&nbsp;</td>
            </tr>
            <tr class="row28">
                <td class="column0 style8 null"></td>
                <td class="column1 style8 null"></td>
                <td class="column2 style8 null"></td>
                <td class="column3 style8 null"></td>
                <td class="column4 style8 null"></td>
                <td class="column5 style8 null"></td>
                <td class="column6 style8 null"></td>
                <td class="column7 style8 null"></td>
                <td class="column8 style8 null"></td>
                <td class="column9 style8 null"></td>
                <td class="column10 style8 null"></td>
                <td class="column11">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>

<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>EMPLOYEE ID</th>
            <th>NAME</th>
            <th>GAJI POKOK</th>
            <th>TUNJ PULSA</th>
            <th>TUNJ JABATAN</th>
            <th>TUNJ TRANSPORT</th>
            <th>TUNJ MAKAN</th>
            <th>TUNJ LAIN LAIN</th>
            <th>REVISI</th>
            <th>POT PPH21</th>
            <th>POT BPJS TK</th>
            <th>POT JAMINAN PENSIUN</th>
            <th>POT BPJS KESEHATAN</th>
            <th>POT PINJAMAN</th>
            <th>POT KETERLAMBATAN</th>
            <th>POT DAILY REPORT</th>
            <th>THP</th>
            <th>JUMLAH HARI KERJA</th>
            <th>JUMLAH SAKIT</th>
            <th>JUMLAH IZIN</th>
            <th>JUMLAH ALPHA</th>
            <th>JUMLAH CUTI</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $index => $employee)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->user->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

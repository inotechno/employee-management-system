<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>EMPLOYEE ID</th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>TANGGAL JOIN</th>
            <th>TANGGAL LAHIR</th>
            <th>TEMPAT LAHIR</th>
            <th>BPJS KESEHATAN</th>
            <th>BPJS KETENAGAKERJAAN</th>
            <th>NAMA REKENING</th>
            <th>NO REKENING</th>
            <th>PEMILIK REKENING</th>
            <th>JUMLAH CUTI </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $index => $employee)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->user->name }}</td>
                <td>{{ $employee->user->email }}</td>
                <td>{{ $employee->join_date != null ? date('d/m/Y', strtotime($employee->join_date)) : null }} </td>
                <td>{{ $employee->tanggal_lahir != null ? date('d/m/Y', strtotime($employee->tanggal_lahir)) : null }}
                </td>
                <td>{{ $employee->tempat_lahir }}</td>
                <td>{{ $employee->bpjs_kesehatan }}</td>
                <td>{{ $employee->bpjs_ketenagakerjaan }}</td>
                <td>{{ $employee->nama_rekening }}</td>
                <td>{{ $employee->no_rekening }}</td>
                <td>{{ $employee->pemilik_rekening }}</td>
                <td>{{ $employee->jumlah_cuti }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

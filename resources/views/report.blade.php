<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kupon</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 6px 10px; font-size: 14px; text-align: left; }
        th { background: #f2f2f2; }
        tr:nth-child(even) { background: #fafafa; }
        .prize-win { color: #16a34a; font-weight: bold; }
        .prize-none { color: #999; }
    </style>
</head>
<body>

    <h2>Laporan Kupon</h2>
    <table>
        <tbody>
            @foreach($details as $batchNumber => $batch)
    @php
        $header = $batch->first();
    @endphp
    <h2>Batch {{ $batchNumber }}</h2>

    <table>
        <tr>
            <td>Operator</td>
            <td>{{ $header->operator_name }}</td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td>{{ $header->location_name }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>{{ \Carbon\Carbon::parse($header->tanggal)->format('d-m-Y H:i') }}</td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>Box</th>
                <th>No Kupon</th>
                <th>Hadiah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        @foreach($batch as $row)
            <tr>
                <td>{{ $row->box_number }}</td>
                <td>{{ $row->coupon_number }}</td>
                <td>
                    {{ $row->prize == 0
                        ? '-'
                        : number_format($row->prize,0,',','.')
                    }}
                </td>
                <td>{{ $row->remarks }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br><br>
@endforeach
        </tbody>
    </table>

</body>
</html>
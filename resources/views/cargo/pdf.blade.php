<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Cargo - Export PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 20px;
            color: #4F46E5;
            margin: 0 0 5px 0;
        }

        .header p {
            color: #666;
            margin: 0;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #4F46E5;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-size: 11px;
        }

        td {
            padding: 7px 6px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .badge {
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-proses {
            background: #FEF3C7;
            color: #D97706;
        }

        .badge-complete {
            background: #D1FAE5;
            color: #059669;
        }

        .foto {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN DATA CARGO</h1>
        <p>Tanggal Export: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Perusahaan</th>
                <th>No BL</th>
                <th>Party</th>
                <th>Marking</th>
                <th>Cargo</th>
                <th>Lokasi</th>
                <th>Foto</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($cargos as $i => $cargo)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $cargo->nama_perusahaan }}</td>
                <td>{{ $cargo->no_bl }}</td>
                <td>{{ $cargo->party }}</td>
                <td>{{ $cargo->marking }}</td>
                <td>{{ $cargo->cargo }}</td>
                <td>{{ $cargo->lokasi }}</td>

                <td>
                    @if($cargo->foto_public_path)
                        <img 
                            src="{{ public_path($cargo->foto_public_path) }}" 
                            class="foto">
                    @else
                        -
                    @endif
                </td>

                <td>
                    <span class="badge {{ $cargo->status === 'proses' ? 'badge-proses' : 'badge-complete' }}">
                        {{ ucfirst($cargo->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ $cargos->count() }} | Data Management Cargo System</p>
    </div>

</body>
</html>

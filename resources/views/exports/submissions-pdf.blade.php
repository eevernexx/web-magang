<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengumpulan Tugas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .footer {
            text-align: right;
            font-style: italic;
            font-size: 10px;
        }
        .status-submitted {
            color: #28a745;
        }
        .status-not-submitted {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pengumpulan Tugas</h2>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Universitas</th>
                <th>Status Pengumpulan</th>
                <th>Judul Tugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $submission)
                <tr>
                    <td>{{ $submission['Tanggal'] }}</td>
                    <td>{{ $submission['Nama'] }}</td>
                    <td>{{ $submission['Email'] }}</td>
                    <td>{{ $submission['Universitas'] }}</td>
                    <td class="{{ $submission['Status Pengumpulan'] === 'Sudah Mengumpulkan' ? 'status-submitted' : 'status-not-submitted' }}">
                        {{ $submission['Status Pengumpulan'] }}
                    </td>
                    <td>{{ $submission['Judul Tugas'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh sistem KominfoMuda</p>
    </div>
</body>
</html> 
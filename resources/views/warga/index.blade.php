<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .action-links a, .action-links button { text-decoration: none; padding: 2px 5px; border: none; background: none; cursor: pointer; }
        .action-links a.edit { color: #007bff; }
        .action-links button.delete { color: #dc3545; }
        .add-button { 
            display: inline-block; 
            margin-bottom: 15px; 
            padding: 8px 12px; 
            background-color: #007bff; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px;
        }
        .alert-success {
            padding: 10px;
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .pagination { list-style: none; padding: 0; }
        .pagination li { display: inline; margin: 0 2px; }
        .pagination li a, .pagination li span { padding: 5px 10px; text-decoration: none; border: 1px solid #ddd; }
        .pagination li.active span { background-color: #007bff; color: white; border-color: #007bff; }
    </style>
</head>
<body>

    <h2>Manajemen Data Warga</h2>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('warga.create') }}" class="add-button">Tambah Warga Baru</a>

    <table>
        <thead>
            <tr>
                <th>No KTP</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Pekerjaan</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($warga as $item)
            <tr>
                <td>{{ $item->no_ktp }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $item->agama }}</td>
                <td>{{ $item->pekerjaan }}</td>
                <td>{{ $item->telp }}</td>
                <td>{{ $item->email }}</td>
                <td class="action-links">
                    <a class="edit" href="{{ route('warga.edit', $item->warga_id) }}">Edit</a> |
                    
                    <form action="{{ route('warga.destroy', $item->warga_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 15px;">
        {{ $warga->links('pagination::simple-bootstrap-4') }}
    </div>

</body>
</html>
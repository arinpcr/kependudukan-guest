<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kartu Keluarga</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
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
        .pagination { list-style: none; padding: 0; margin-top: 15px; }
        .pagination li { display: inline; margin: 0 2px; }
        .pagination li a, .pagination li span { padding: 5px 10px; text-decoration: none; border: 1px solid #ddd; }
        .pagination li.active span { background-color: #007bff; color: white; border-color: #007bff; }
    </style>
</head>
<body>

    <h2>Manajemen Kartu Keluarga</h2>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('keluarga.create') }}" class="add-button">Tambah Data KK Baru</a>

    <table>
        <thead>
            <tr>
                <th>Nomor KK</th>
                <th>Kepala Keluarga</th>
                <th>Alamat</th>
                <th>RT</th>
                <th>RW</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($keluarga as $item)
            <tr>
                <td>{{ $item->kk_nomor }}</td>
                <td>{{ $item->kepalaKeluarga ? $item->kepalaKeluarga->nama : 'Warga tidak ditemukan' }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->rt }}</td>
                <td>{{ $item->rw }}</td>
                <td class="action-links">
                    <a class="edit" href="{{ route('keluarga.edit', $item->kk_id) }}">Edit</a> |
                    <form action="{{ route('keluarga.destroy', $item->kk_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data KK ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data Kartu Keluarga.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $keluarga->links('pagination::simple-bootstrap-4') }}
    </div>

</body>
</html>
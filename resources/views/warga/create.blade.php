<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Warga</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        form div { margin-bottom: 10px; }
        label { display: inline-block; width: 120px; }
        input[type="text"], input[type="email"], select { width: 250px; padding: 5px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 8px 12px; background-color: #007bff; color: white; border: none; cursor: pointer; border-radius: 4px; }
        .back-link { 
            display: inline-block; 
            margin-bottom: 15px; 
            color: #007bff; 
            text-decoration: none; 
        }
        .error-message {
            color: #dc3545;
            font-size: 0.9em;
            margin-left: 125px;
        }
    </style>
</head>
<body>

    <h2>Formulir Tambah Warga</h2>
    <a href="{{ route('warga.index') }}" class="back-link">&laquo; Kembali ke Daftar Warga</a>
    <br><br>

    @if ($errors->any())
        <div style="color: #dc3545; margin-bottom: 15px;">
            <strong>Whoops! Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('warga.store') }}" method="POST">
        @csrf
        <div>
            <label>No KTP</label>
            <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" required>
            @error('no_ktp')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama') }}" required>
            @error('nama')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin">
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Agama</label>
            <input type="text" name="agama" value="{{ old('agama') }}">
            @error('agama')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}">
            @error('pekerjaan')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Telepon</label>
            <input type="text" name="telp" value="{{ old('telp') }}">
            @error('telp')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label></label>
            <button type="submit">Simpan Data</button>
        </div>
    </form>

</body>
</html>
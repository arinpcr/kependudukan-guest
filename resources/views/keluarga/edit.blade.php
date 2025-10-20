<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data KK</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        form div { margin-bottom: 10px; }
        label { display: inline-block; width: 150px; }
        input[type="text"], textarea, select { width: 300px; padding: 5px; border: 1px solid #ccc; border-radius: 4px; }
        textarea { height: 60px; }
        button { padding: 8px 12px; background-color: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px; }
        .back-link { display: inline-block; margin-bottom: 15px; text-decoration: none; }
        .error-message { color: #dc3545; font-size: 0.9em; margin-left: 155px; }
    </style>
</head>
<body>

    <h2>Formulir Edit Kartu Keluarga</h2>
    <a href="{{ route('keluarga.index') }}" class="back-link">&laquo; Kembali ke Daftar KK</a>

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

    <form action="{{ route('keluarga.update', $keluarga->kk_id) }}" method="POST">
        @csrf
        @method('PUT') <div>
            <label>Nomor KK</label>
            <input type="text" name="kk_nomor" value="{{ old('kk_nomor', $keluarga->kk_nomor) }}" required>
            @error('kk_nomor')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        
        <div>
            <label>Kepala Keluarga</label>
            <select name="kepala_keluarga_warga_id" required>
                <option value="">-- Pilih Kepala Keluarga --</option>
                @foreach ($warga as $w)
                    <option value="{{ $w->warga_id }}" 
                        {{ old('kepala_keluarga_warga_id', $keluarga->kepala_keluarga_warga_id) == $w->warga_id ? 'selected' : '' }}>
                        {{ $w->nama }} (KTP: {{ $w->no_ktp }})
                    </option>
                @endforeach
            </select>
            @error('kepala_keluarga_warga_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Alamat</label>
            <textarea name="alamat" required>{{ old('alamat', $keluarga->alamat) }}</textarea>
            @error('alamat')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        
        <div>
            <label>RT</label>
            <input type="text" name="rt" value="{{ old('rt', $keluarga->rt) }}" required>
            @error('rt')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>RW</label>
            <input type="text" name="rw" value="{{ old('rw', $keluarga->rw) }}" required>
            @error('rw')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label></label>
            <button type="submit">Update Data</button>
        </div>
    </form>

</body>
</html>
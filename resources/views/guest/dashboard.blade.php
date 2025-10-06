<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guest</title>
    <style>
        body {font-family: Arial, sans-serif; background:#ffe6f0; text-align:center; color:#d63384;}
        h2 {margin:20px 0;}
        .card {background:#fff; display:inline-block; padding:15px 25px; margin:10px;
               border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1);}
        .number {font-size:20px; font-weight:bold; margin-top:5px;}
    </style>
</head>
<body>
    <h2>Dashboard Kependudukan</h2>

    <div class="card">Keluarga<div class="number">{{ $keluarga }}</div></div>
    <div class="card">Warga<div class="number">{{ $warga }}</div></div>
    <div class="card">Kelahiran<div class="number">{{ $kelahiran }}</div></div>
    <div class="card">Kematian<div class="number">{{ $kematian }}</div></div>
    <div class="card">Pindah<div class="number">{{ $pindah }}</div></div>
</body>
</html>

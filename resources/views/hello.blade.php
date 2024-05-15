<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello ini file pertama saya di dalam view laravel</h1>
    @php
    $nama = "Budi";
    $nilai = 59.99;   
    @endphp
    {{--Struktur Kendali if--}}
    @if ($nilai  >= 60)
        @php
            $ket = "Lulus";
        @endphp
    @else
        @php
            $ket = "Gagal";
        @endphp
    @endif

    {{ $nama }} dengan nilai {{ $nilai }}
    dinyatakan {{ $ket }}

</body>
</html>
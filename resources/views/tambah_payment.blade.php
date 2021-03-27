<!DOCTYPE html>
<html>

<head>
    <title>KLEDO PAYMENT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <h2>KLEDO PAYMENT</h2>
    <h3>Tambah Payment</h3>

    <a href="/payments"> Kembali</a>

    <br />
    <br />

    <form action="/payments/add" method="post">
        {{ csrf_field() }}
        Nama <input type="text" name="name" required="required"> <br />
        <input type="submit" value="Simpan">
    </form>
</body>

</html>

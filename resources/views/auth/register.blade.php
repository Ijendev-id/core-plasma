<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="container">

    <!-- LEFT -->
    <div class="left">
        <img src="image/logo.png" class="logo">
        <img src="image/login.png" class="hero">
    </div>

    <!-- RIGHT -->
    <div class="right">
        <div class="login-box">

            <!-- LOGO MOBILE -->
            <img src="image/logo.png" class="logo-top">

            <h1>Daftar Akun</h1>
            <p>Isi data untuk mulai tryoutmu</p>

            <form>

                <label>Nama</label>
                <input type="text" placeholder="Masukkan nama lengkap">

                <label>Email</label>
                <input type="email" placeholder="Masukkan email">

                <label>Telepon</label>
                <input type="text" placeholder="Masukkan nomor telepon">

                <label>Jenis Kelamin</label>
                <select>
                    <option>Pilih jenis kelamin</option>
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                </select>

                {{-- <label>Pilih Paket</label>
                <div class="paket">
                    <button type="button">CPNS</button>
                    <button type="button">P3K</button>
                    <button type="button">BUMN</button>
                    <button type="button">SNBT</button>
                </div> --}}

                <label>Password</label>
                <input type="password" placeholder="Masukkan password">

                <label>Konfirmasi Password</label>
                <input type="password" placeholder="Ulangi password">

                <button class="btn-login">Daftar</button>

                <button class="btn-register">
                    Sudah Punya Akun? Login
                </button>

            </form>

            <div class="footer">
                <a href="#">Tentang Kami</a>
                <a href="#">Syarat dan Ketentuan</a>
                <a href="#">Kebijakan Privasi</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>

<script>
document.querySelectorAll('.paket button').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.paket button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});
</script>

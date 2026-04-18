<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

            <!-- OPTIONAL LOGO MOBILE -->
            <img src="image/logo.png" class="logo-top">

            <h1>Selamat Datang Kembali!</h1>
            <p>Mulailah mengerjakan tryoutmu!</p>

            <form>
                <label>Email</label>
                <input type="email" placeholder="Masukkan email">

                <label>Password</label>
                <div class="password-box">
                    <input type="password" placeholder="Masukkan password">
                    <span class="eye">👁</span>
                </div>

                <div class="forgot">
                    <a href="#">Lupa Password?</a>
                </div>

                <button class="btn-login">Masuk</button>

                <div class="divider">ATAU</div>

                {{-- <button class="btn-google">
                    <img src="google.png"> Sign in with Google
                </button> --}}

                <button class="btn-register">
                    Belum Punya Akun? Daftar Sekarang!
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

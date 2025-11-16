<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Background */
        body {
            background: url("/images/bg-register.jpg") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            position: relative;
        }

        /* Overlay Gelap */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 1;
        }

        /* Container utama agar tidak kepotong */
        .wrapper {
            position: relative;
            z-index: 2;
            padding-top: 60px;      /* Tambah ruang atas */
            padding-bottom: 60px;   /* Tambah ruang bawah */
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0,0,0,0.3);
        }

        h3, h5, label, p, a {
            color: #000 !important;
        }
    </style>
</head>

<body>

    <div class="container wrapper d-flex justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="card p-4">
                <h3 class="text-center mb-4">Register Akun</h3>

                <form method="POST" action="{{ route('registerpenjual.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <hr>
                    <h5>Data Toko</h5>

                    <div class="mb-3">
                        <label class="form-label">Nama Toko</label>
                        <input type="text" name="nama_toko" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kontak</label>
                        <input type="text" name="kontak" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
                </form>

                <p class="text-center mt-3 text-dark">
                    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Parkir</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">

    <style>
        :root {
            --accent: #4169E1;
            --muted: #9ca3af;
        }
        body {
            background: white !important;
        }
        .left {
            background: white !important;
        }
        .left::before {
            display: none !important;
        }
        .card {
            background: white !important;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="left">
            <!-- Illustration loaded from assets/images/illustration.svg -->
            <img class="illustration" src="<?= base_url('assets/img/foto1.png') ?>" alt="Illustration">
        </div>

        <div class="right">
            <h1>Sign in</h1>
            <p class="muted">Masuk dengan akun Anda untuk melanjutkan.</p>

            <!-- FORM LOGIN -->
            <form action="<?= base_url('index.php/auth/proses') ?>" 
                  method="post"
                  autocomplete="on">

                <div class="form-group">
                    <!-- PERUBAHAN HANYA DI SINI -->
                    <input type="email"
                           name="email"
                           placeholder="Email"
                           autocomplete="email"
                           required>

                    <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5z"
                              stroke="#6b7280" stroke-width="1.2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 21v-1c0-2.5-5-3.5-8-3.5s-8 .9-8 3.5v1"
                              stroke="#6b7280" stroke-width="1.2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <div class="form-group">
                    <input type="password"
                           name="password"
                           placeholder="Password"
                           autocomplete="current-password"
                           required>

                    <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="11" width="18" height="11" rx="2"
                              stroke="#6b7280" stroke-width="1.2"/>
                        <path d="M7 11V8a5 5 0 0110 0v3"
                              stroke="#6b7280" stroke-width="1.2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <button class="btn btn--center" type="submit" style="background:#1976d2;color:#fff;border:none;border-radius:6px;font-weight:600;font-size:1rem;cursor:pointer;transition:background 0.2s;">Log in</button>
            </form>

            <div class="divider"></div>
            <a class="forgot" href="#">Forgot Password?</a>
        </div>
    </div>
</body>
</html>

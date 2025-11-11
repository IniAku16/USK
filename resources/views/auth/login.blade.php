<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran BilSky</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body {
            background: url('https://images.unsplash.com/photo-1597200381847-30ec200eeb9a?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') 
                        no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.3);
        }

        .login-card h3 {
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-custom {
            background: linear-gradient(90deg, #2a97ef, #9fcbf8);
            border: none;
            color: #ffffffde;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(42, 151, 239, 0.6);
        }

        .form-check-label {
            font-size: 0.9rem;
        }

        select.form-select {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease;
        }

        select.form-select:focus {
            border-color: #2a97ef;
            box-shadow: 0 0 0 0.25rem rgba(42, 151, 239, 0.25);
        }
    </style>
</head>
<body>

    <div class="login-card animate__animated animate__backInDown">
        <h3>BilSky</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <!-- ✅ Tambahan Role -->
            <div class="mb-3">
                <label for="role" class="form-label">Login Sebagai</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Role --</option>
                    <option value="administrator">Administrator</option>
                    <option value="waiter">Waiter</option>
                    <option value="kasir">Kasir</option>
                    <option value="owner">Owner</option>
                </select>
            </div>
            <!-- ✅ Akhir tambahan -->

            <div class="d-flex justify-content-between mb-3">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                <a href="{{ route('password.reset') }}" class="text-decoration-none">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-custom w-100">SIGN IN</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

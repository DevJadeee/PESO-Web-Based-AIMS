<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PESO Agoo</title>
    
    <!-- PESO Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/peso-theme.css') }}">
    <!-- Lucide Icons (pinned stable version) -->
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.344.0/dist/umd/lucide.min.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: #F8FAFC;
        }
        
        .split-layout {
            display: flex;
            height: 100vh;
        }

        /* Left panel — blank canvas for custom design */
        .left-panel {
            flex: 1;
            background-color: #FFFFFF;
            position: relative;
            overflow: hidden;
            border-right: 1px solid #E2E8F0;
        }

        .right-panel {
            flex: 1;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-box {
            background: #FFFFFF;
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 440px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            padding: 45px 40px;
            position: relative;
            border: 1px solid #E2E8F0;
        }

        /* Top colored border (red, yellow, blue) */
        .login-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(to right, var(--peso-red) 33.3%, var(--peso-yellow) 33.3%, var(--peso-yellow) 66.6%, var(--peso-blue) 66.6%);
        }

        .login-title {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-title h1 {
            font-size: 24px;
            font-weight: 800;
            color: #000000;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }

        .login-title p {
            font-size: 13px;
            color: #475569;
        }

        .form-heading {
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            margin-bottom: 20px;
            font-style: italic;
        }

        .form-label {
            font-size: 16px;
            font-weight: 800;
            color: #000000;
            margin-bottom: 8px;
            display: block;
        }

        .input-group {
            position: relative;
            margin-bottom: 24px;
        }

        .input-group input {
            width: 100%;
            padding: 14px 48px 14px 50px;
            border: 1.5px solid #CBD5E1;
            border-radius: var(--radius-full);
            font-size: 14px;
            color: var(--text-primary);
            outline: none;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .input-group input::placeholder {
            color: #94A3B8;
        }

        .input-group input:focus {
            border-color: var(--peso-blue);
            box-shadow: 0 0 0 3px rgba(13, 59, 102, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--peso-blue);
            width: 20px;
            height: 20px;
        }
        
        .input-icon-asterisks {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--peso-blue);
            font-weight: 800;
            font-size: 20px;
            letter-spacing: 2px;
            line-height: 1;
        }

        .input-icon-right {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--peso-blue);
            width: 20px;
            height: 20px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-login {
            background: #E13D4B; /* Matched to the image red */
            color: #FFFFFF;
            border: none;
            border-radius: var(--radius-full);
            padding: 12px 45px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            width: auto;
            display: block;
            margin: 10px auto 30px;
            transition: all 0.2s;
            box-shadow: 0 6px 12px rgba(225, 61, 75, 0.3);
        }

        .btn-login:hover {
            background: var(--peso-red-dark);
            transform: translateY(-1px);
        }

        .divider {
            text-align: center;
            margin: 24px 0;
            position: relative;
        }

        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #E2E8F0;
        }

        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .divider span {
            color: #CBD5E1;
            font-size: 13px;
            background: #FFFFFF;
            padding: 0 10px;
            font-weight: 500;
        }

        .signup-link {
            text-align: center;
            font-size: 13px;
            color: #475569;
        }

        .signup-link a {
            color: var(--peso-blue);
            font-weight: 700;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .split-layout {
                flex-direction: column;
            }
            .left-panel {
                display: none;
            }
            .right-panel {
                padding: 15px;
                background: #F8FAFC;
            }
        }
    </style>
</head>
<body>
    <div class="split-layout">
        <!-- Left Panel — blank canvas, design here -->
        <div class="left-panel">
            {{-- Add your custom design content here --}}
        </div>

        <!-- Right Panel with Login Form -->
        <div class="right-panel">
            <div class="login-box">
                <div class="login-title">
                    <h1>WELCOME !</h1>
                    <p>Sign up your account to continue</p>
                </div>

                <div class="form-heading">Log in</div>

                @if($errors->any())
                    <div style="background: var(--peso-red-light); color: var(--peso-red-dark); padding: 12px; border-radius: var(--radius-md); font-size: 13px; margin-bottom: 20px; font-weight: 500; text-align: center;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="email" class="form-label">Email adress:</label>
                        <div class="input-group">
                            <i data-lucide="mail" class="input-icon"></i>
                            <input type="email" id="email" name="email" placeholder="Enter Email Adress" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="password" class="form-label">Password:</label>
                        <div class="input-group">
                            <i data-lucide="lock" class="input-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Enter password" required>
                            <button type="button" id="togglePassword" class="input-icon-right">
                                <i data-lucide="eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        LOGIN
                    </button>

                    <div class="divider">
                        <span>OR</span>
                    </div>

                    <div class="signup-link">
                        Do you have and account? <a href="{{ route('public.register') }}">Create an Account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();

            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            const updatePasswordToggle = function () {
                const isPasswordVisible = passwordInput.getAttribute('type') === 'text';
                passwordInput.setAttribute('type', isPasswordVisible ? 'password' : 'text');
                eyeIcon.setAttribute('data-lucide', isPasswordVisible ? 'eye' : 'eye-off');
                toggleBtn.setAttribute('aria-label', isPasswordVisible ? 'Show password' : 'Hide password');
                lucide.createIcons();
            };

            toggleBtn.addEventListener('click', function () {
                updatePasswordToggle();
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SimplyCash Login</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {

            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 30px;

            overflow: hidden;

            background:
                radial-gradient(circle at top left,
                    rgba(123, 189, 232, .18),
                    transparent 28%),

                radial-gradient(circle at bottom right,
                    rgba(10, 65, 116, .10),
                    transparent 30%),

                #ffffff;

            position: relative;
        }

        /* =========================
           BACKGROUND GLOW
        ========================== */

        .bg-glow {

            position: absolute;

            border-radius: 50%;

            filter: blur(90px);

            opacity: .10;

            animation: float 10s ease-in-out infinite;
        }

        .glow1 {
            width: 320px;
            height: 320px;
            background: #7BBDE8;
            top: -80px;
            left: -80px;
        }

        .glow2 {
            width: 260px;
            height: 260px;
            background: #4E8EA2;
            bottom: -70px;
            right: -70px;
            animation-delay: 2s;
        }

        .glow3 {
            width: 220px;
            height: 220px;
            background: #6EA2B3;
            top: 45%;
            left: 65%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) translateX(0px);
            }

            50% {
                transform: translateY(-20px) translateX(12px);
            }
        }

        /* =========================
           PHONE FRAME
        ========================== */

        .phone-frame {

            width: 350px;

            height: 720px;

            max-height: 92vh;

            border-radius: 45px;

            border: 10px solid #111;

            background:
                linear-gradient(180deg,
                    #a9c8e5 0%,
                    #8ab7de 25%,
                    #4d7ba8 65%,
                    #163d6a 100%);

            backdrop-filter: blur(20px);

            overflow: hidden;

            position: relative;

            box-shadow:
                0 35px 70px rgba(0, 0, 0, .20),
                inset 0 0 0 1px rgba(255, 255, 255, .08);

            animation: fadeUp 1.2s ease;
        }

        /* =========================
           NOTCH
        ========================== */

        .notch {
            width: 110px;
            height: 28px;

            background: #111;

            border-radius: 20px;

            position: absolute;

            top: 10px;
            left: 50%;

            transform: translateX(-50%);

            z-index: 999;
        }

        /* =========================
           ANIMATED BLOBS
        ========================== */

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(5px);
            opacity: .95;
        }

        .blob-top {

            width: 420px;
            height: 420px;

            background:
                linear-gradient(135deg,
                    #BDD8E9,
                    #7BBDE8,
                    #4E8EA2);

            top: -240px;
            right: -120px;

            animation: blobMove 10s ease-in-out infinite;
        }

        .blob-bottom {

            width: 400px;
            height: 400px;

            background:
                linear-gradient(135deg,
                    #49769F,
                    #0A4174,
                    #001D39);

            bottom: -250px;
            left: -120px;

            animation: blobMove2 12s ease-in-out infinite;
        }

        @keyframes blobMove {

            0%,
            100% {
                transform: rotate(0deg) scale(1);
                border-radius: 42% 58% 63% 37% / 45% 40% 60% 55%;
            }

            50% {
                transform: rotate(10deg) scale(1.05);
                border-radius: 58% 42% 37% 63% / 50% 60% 40% 50%;
            }
        }

        @keyframes blobMove2 {

            0%,
            100% {
                transform: rotate(0deg);
                border-radius: 60% 40% 35% 65% / 50% 55% 45% 50%;
            }

            50% {
                transform: rotate(-12deg) scale(1.05);
                border-radius: 40% 60% 60% 40% / 45% 35% 65% 55%;
            }
        }

        /* =========================
           PARTICLES
        ========================== */

        .particle {
            position: absolute;
            width: 7px;
            height: 7px;

            background: rgba(255, 255, 255, .4);

            border-radius: 50%;

            animation: particleFloat linear infinite;
        }

        .particle:nth-child(1) {
            top: 20%;
            left: 15%;
            animation-duration: 10s;
        }

        .particle:nth-child(2) {
            top: 70%;
            left: 75%;
            width: 5px;
            height: 5px;
            animation-duration: 13s;
        }

        .particle:nth-child(3) {
            top: 50%;
            left: 25%;
            width: 6px;
            height: 6px;
            animation-duration: 11s;
        }

        .particle:nth-child(4) {
            top: 35%;
            left: 80%;
            width: 4px;
            height: 4px;
            animation-duration: 8s;
        }

        @keyframes particleFloat {

            0% {
                transform: translateY(0px);
                opacity: 0;
            }

            30% {
                opacity: 1;
            }

            100% {
                transform: translateY(-90px);
                opacity: 0;
            }
        }

        /* =========================
           CONTENT
        ========================== */

        .content {

            position: relative;
            z-index: 10;

            height: 100%;

            padding:
                48px 26px 24px;

            display: flex;
            flex-direction: column;

            justify-content: flex-start;

            overflow-y: auto;

            scrollbar-width: none;
        }

        .content::-webkit-scrollbar {
            display: none;
        }

        /* =========================
           LOGO
        ========================== */

        .logo {
            animation: slideLeft 1s ease;
            margin-top: 8px;
            margin-bottom: 12px;
        }

        .logo span {
            font-size: 30px;
            font-weight: 700;
            color: white;
            letter-spacing: .5px;
        }

        .logo p {
            margin-top: 8px;

            color: rgba(255, 255, 255, .8);

            font-size: 12px;

            line-height: 1.5;
        }

        @keyframes slideLeft {

            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0px);
            }
        }

        /* =========================
           LOGIN CARD
        ========================== */

        .login-card {

            margin-top: 18px;

            background: rgba(255, 255, 255, 0.12);

            backdrop-filter: blur(18px);

            border: 1px solid rgba(255, 255, 255, 0.18);

            border-radius: 32px;

            padding: 26px 22px;

            box-shadow:
                0 20px 40px rgba(0, 0, 0, .18),
                inset 0 1px 1px rgba(255, 255, 255, .15);

            animation: cardShow 1.2s ease;
        }

        @keyframes cardShow {

            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0px);
            }
        }

        .login-title {

            color: white;

            font-size: 22px;

            font-weight: 600;

            margin-bottom: 22px;
        }

        /* =========================
           INPUT
        ========================== */

        .input-group {
            position: relative;
            margin-bottom: 16px;
        }

        .input-group input {

            width: 100%;

            border: none;
            outline: none;

            padding: 16px 20px;
            padding-right: 48px;

            border-radius: 18px;

            background: rgba(255, 255, 255, .85);

            color: #001D39;

            font-size: 13px;

            transition: .35s;
        }

        .input-group input::placeholder {
            color: #6b7280;
        }

        .input-group input:focus {

            transform: translateY(-2px);

            box-shadow:
                0 0 20px rgba(123, 189, 232, .4);
        }

        .eye {

            position: absolute;

            right: 18px;
            top: 50%;

            transform: translateY(-50%);

            color: #94a3b8;

            cursor: pointer;
        }

        /* =========================
           FORGOT
        ========================== */

        .forgot {

            text-align: right;

            margin-bottom: 18px;
        }

        .forgot a {

            color: rgba(255, 255, 255, .85);

            text-decoration: none;

            font-size: 12px;
        }

        /* =========================
           BUTTON
        ========================== */

        .btn-login {

            width: 100%;

            border: none;

            padding: 16px;

            border-radius: 18px;

            background:
                linear-gradient(135deg,
                    #7BBDE8,
                    #0A4174);

            color: white;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            transition: .4s;

            position: relative;

            overflow: hidden;
        }

        .btn-login::before {

            content: '';

            position: absolute;

            top: 0;
            left: -120%;

            width: 100%;
            height: 100%;

            background: rgba(255, 255, 255, .2);

            transform: skewX(-20deg);

            transition: .7s;
        }

        .btn-login:hover::before {
            left: 120%;
        }

        .btn-login:hover {

            transform: translateY(-3px);

            box-shadow:
                0 15px 30px rgba(10, 65, 116, .4);
        }

        /* =========================
           SOCIAL
        ========================== */

        .social-area {

            margin-top: 24px;

            text-align: center;
        }

        .divider {

            color: rgba(255, 255, 255, .8);

            font-size: 11px;

            margin-bottom: 18px;

            position: relative;
        }

        .divider::before,
        .divider::after {

            content: '';

            position: absolute;

            width: 28%;
            height: 1px;

            background: rgba(255, 255, 255, .25);

            top: 50%;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .social-icons {

            display: flex;

            justify-content: center;

            gap: 16px;
        }

        .social-icons div {

            width: 44px;
            height: 44px;

            border-radius: 15px;

            background: rgba(255, 255, 255, .14);

            display: flex;

            justify-content: center;
            align-items: center;

            color: white;

            font-size: 18px;

            cursor: pointer;

            transition: .35s;

            border: 1px solid rgba(255, 255, 255, .1);
        }

        .social-icons div:hover {

            transform: translateY(-5px) scale(1.05);

            background: rgba(255, 255, 255, .24);
        }

        /* =========================
           SIGNUP
        ========================== */

        .signup {

            text-align: center;

            margin-top: 24px;

            color: rgba(255, 255, 255, .85);

            font-size: 12px;
        }

        .signup a {

            color: white;

            text-decoration: none;

            font-weight: 600;
        }

        /* =========================
           RESPONSIVE
        ========================== */

        @media(max-height:780px) {

            .phone-frame {
                transform: scale(.92);
            }
        }
        html.dark-mode body {
            background: #020617;
            color: #e2e8f0;
        }
        html.dark-mode .phone-frame,
        html.dark-mode .phone {
            border-color: #0f172a !important;
            background: linear-gradient(165deg, #0f172a 0%, #111827 30%, #1f2937 60%, #0f172a 100%) !important;
            box-shadow: 0 40px 90px rgba(0,0,0,.8) !important;
        }
        html.dark-mode .login-panel,
        html.dark-mode .form-card,
        html.dark-mode .input-group,
        html.dark-mode .input-field,
        html.dark-mode .login-footer,
        html.dark-mode .remember-row,
        html.dark-mode .auth-btn {
            background: rgba(15,23,42,.92) !important;
            border-color: rgba(148,163,184,.2) !important;
            color: #e2e8f0 !important;
        }
        html.dark-mode input,
        html.dark-mode select,
        html.dark-mode textarea {
            background: rgba(15,23,42,.96) !important;
            color: #e2e8f0 !important;
            border-color: rgba(148,163,184,.3) !important;
        }
        html.dark-mode .auth-btn {
            background: rgba(37,99,235,.95) !important;
            color: white !important;
        }
    </style>

</head>

<body>

    <!-- GLOW -->
    <div class="bg-glow glow1"></div>
    <div class="bg-glow glow2"></div>
    <div class="bg-glow glow3"></div>

    <!-- PHONE -->
    <div class="phone-frame">

        <!-- NOTCH -->
        <div class="notch"></div>

        <!-- BLOBS -->
        <div class="blob blob-top"></div>
        <div class="blob blob-bottom"></div>

        <!-- PARTICLES -->
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>

        <!-- CONTENT -->
        <div class="content">

            <!-- LOGO -->
            <div class="logo">

                <span>SimplyCash</span>

                <p>
                    Smart finance solution for your business,
                    inventory, and daily cashflow.
                </p>

            </div>

            <!-- LOGIN CARD -->
            <div class="login-card">

                <div class="login-title">
                    Welcome Back
                </div>

                <form action="home.php">

                    <div class="input-group">

                        <input
                            type="email"
                            placeholder="Email Address">

                    </div>

                    <div class="input-group">

                        <input
                            type="password"
                            placeholder="Password"
                            id="password">

                        <i class="fa-regular fa-eye-slash eye"
                            id="togglePassword"></i>

                    </div>

                    <div class="forgot">
                        <a href="#">
                            Forgot Password?
                        </a>
                    </div>

                    <button class="btn-login">
                        Login
                    </button>

                </form>

                <!-- SOCIAL -->
                <div class="social-area">

                    <div class="divider">
                        or continue with
                    </div>

                    <div class="social-icons">

                        <div>
                            <i class="fa-brands fa-apple"></i>
                        </div>

                        <div>
                            <i class="fa-brands fa-google"></i>
                        </div>

                        <div>
                            <i class="fa-brands fa-facebook-f"></i>
                        </div>

                    </div>

                </div>

                <!-- SIGNUP -->
                <div class="signup">

                    Don't have an account?
                    <a href="signUp.php">
                        Sign Up
                    </a>

                </div>

            </div>

        </div>

    </div>

    <script>
        // SHOW PASSWORD

        const togglePassword =
            document.getElementById('togglePassword');

        const password =
            document.getElementById('password');

        togglePassword.addEventListener('click', () => {

            const type =
                password.getAttribute('type') === 'password' ?
                'text' :
                'password';

            password.setAttribute('type', type);

            togglePassword.classList.toggle('fa-eye');
            togglePassword.classList.toggle('fa-eye-slash');

        });
    </script>

    <script src="theme.js"></script>
</body>

</html>
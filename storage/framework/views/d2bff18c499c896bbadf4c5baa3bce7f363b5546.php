<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranext - Acceso</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS via CDN para la estructura -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .login-page {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            color: white;
        }

        .login-logo {
            width: 250px;
            padding: 40px 10px;
        }

        .login-welcome h1 {
            font-weight: 700;
        }

        .login-welcome h2 {
            font-weight: 400;
            color: #eee;
        }

        /* Estilos personalizados de los inputs basados en la captura */
        .login-input-group {
            background: rgba(4, 42, 60, 0.4);
            /* Color azul profundo translúcido */
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            display: flex;
            align-items: center;
            padding: 8px 25px;
            margin-bottom: 20px;
        }

        .input-icon {
            width: 24px;
            height: 24px;
            margin-right: 15px;
        }

        .login-input {
            background: transparent;
            border: none;
            color: white;
            width: 100%;
            font-size: 1.1rem;
            outline: none;
            padding: 8px 0;
        }

        .login-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .btn-login {
            background-color: #00d1e0;
            border: none;
            color: #000;
            font-weight: 700;
            border-radius: 50px;
            padding: 15px;
            font-size: 1.2rem;
            margin-top: 15px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: #00b8c4;
            transform: translateY(-2px);
        }

        .login-footer {
            color: #ccc;
            font-size: 0.9rem;
            padding-bottom: 30px;
        }

        .login-footer img {
            height: 25px;
            vertical-align: middle;
            margin-left: 10px;
        }

        /* Estilos específicos para el campo Empresa */
        .empresa-row {
            margin-bottom: 25px;
        }

        .empresa-label {
            font-size: 1.2rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        @media (max-width: 768px) {
            .login-welcome h1 {
                font-size: 2rem;
            }

            .login-welcome h2 {
                font-size: 1.4rem;
            }

            .login-logo {
                width: 200px;
            }
        }
    </style>
    <?php echo \Livewire\Livewire::styles(); ?>

</head>

<body>
    <div class="main-wrapper">
        <?php echo e($slot); ?>

    </div>

    <?php echo \Livewire\Livewire::scripts(); ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('swal:error', event => {
            Swal.fire({
                title: '<div style="margin-top: 140px; font-size: 1.8rem;">' + event.detail.title + '</div>',
                html: '<div style="font-size: 1.2rem; margin-top: 10px; margin-bottom: 20px;">' + event.detail.text + '</div>',
                icon: undefined,
                confirmButtonColor: '#00d1e0',
                background: '#042a3c url(https://acceso2.intranext.es/images/fondo/LoginFondo.png) center center / cover no-repeat',
                color: '#fff',
                width: '500px',
                padding: '3em 2em', // Más espacio vertical
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                didOpen: () => {
                    const popup = Swal.getPopup();
                    const logo = document.createElement('img');
                    logo.src = 'https://acceso2.intranext.es/images/logos/logo-intranext-login.png';
                    logo.style.position = 'absolute';
                    logo.style.top = '35px';
                    logo.style.left = '50%';
                    logo.style.transform = 'translateX(-50%)';
                    logo.style.width = '45%';
                    logo.style.zIndex = '10';
                    popup.insertAdjacentElement('afterbegin', logo);
                },
                customClass: {
                    popup: 'border-cyan custom-swal-bg'
                }
            });
        });
    </script>
    <style>
        .border-cyan {
            border: 2px solid #00d1e0 !important;
            border-radius: 25px !important;
        }

        .custom-swal-bg {
            /* Resplandor azul de unos 30px */
            box-shadow: 0 0 35px rgba(0, 209, 224, 0.7) !important;
        }

        .swal2-icon.swal2-error {
            border-color: #ff6b6b !important;
            color: #ff6b6b !important;
        }

        .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
            background-color: #ff6b6b !important;
        }
    </style>
</body>

</html><?php /**PATH C:\proyectos_ia\intranext-informes\resources\views/layouts/auth.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #042a3c 0%, #063d58 100%);
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .content {
            padding: 40px;
        }

        .content h2 {
            color: #042a3c;
            font-size: 20px;
            margin-top: 0;
        }

        .content p {
            margin-bottom: 20px;
            color: #4a5568;
        }

        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #718096;
            border-top: 1px solid #edf2f7;
        }

        .highlight {
            color: #00d1e0;
            font-weight: bold;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #00d1e0;
            color: #ffffff;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>INTRANEXT</h1>
        </div>
        <div class="content">
            <h2>¡Hola, <span class="highlight">{{ $nombreCompleto }}</span>!</h2>
            <p>Gracias por inscribirte en nuestro <strong>Registro de Socios Expectantes</strong>. Hemos recibido tu
                solicitud correctamente.</p>
            <p>A partir de ahora, serás el primero en recibir información sobre las nuevas promociones de viviendas en
                régimen de cooperativa que mejor se adapten a tus preferencias.</p>
            <p>Estamos encantados de acompañarte en el proceso de encontrar tu futuro hogar.</p>

            <p>Saludos,<br>El equipo de <strong>Intranext</strong></p>
        </div>
        <div class="footer">
            <p>Este es un mensaje automático, por favor no respondas directamente a este correo.</p>
            <p>&copy; {{ date('Y') }} Intranext. Todos los derechos reservados.</p>
        </div>
    </div>
</body>

</html>
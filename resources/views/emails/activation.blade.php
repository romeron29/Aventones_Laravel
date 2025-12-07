<!DOCTYPE html>
<html>
<head>
    <title>Activa tu cuenta</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="background-color: #fff; padding: 20px; border-radius: 10px; max-width: 600px; margin: 0 auto;">
        <h2 style="color: #764ba2;">¡Hola, {{ $user->name }}!</h2>
        <p>Gracias por registrarte en Aventones. Para comenzar a usar tu cuenta, por favor actívala haciendo clic en el siguiente botón:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('activate.account', $user->id) }}" 
               style="background-color: #764ba2; color: white; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
               Activar mi Cuenta
            </a>
        </div>

        <p>Si no creaste esta cuenta, puedes ignorar este correo.</p>
    </div>
</body>
</html>
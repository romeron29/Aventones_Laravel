<!DOCTYPE html>
<html>
<head><title>Nueva Solicitud</title></head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>¡Tienes un pasajero interesado!</h2>
    <p>Hola <strong>{{ $reservation->ride->user->name }}</strong>,</p>
    
    <p>El usuario <strong>{{ $reservation->user->name }} {{ $reservation->user->lastname }}</strong> quiere unirse a tu viaje:</p>
    
    <ul>
        <li><strong>Ruta:</strong> {{ $reservation->ride->origin }} -> {{ $reservation->ride->destination }}</li>
        <li><strong>Fecha:</strong> {{ $reservation->ride->departure_time }}</li>
    </ul>

    <p>Por favor ingresa a tu Dashboard para Aceptar o Rechazar esta solicitud.</p>
    
    <a href="{{ route('dashboard') }}" style="background: #764ba2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Ir al Dashboard</a>
</body>
</html>
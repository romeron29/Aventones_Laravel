<!DOCTYPE html>
<html>
<head>
    <title>Reserva Aceptada</title>
</head>
<body>
    <h1>¡Buenas noticias, {{ $reservation->user->name }}!</h1>
    <p>Tu solicitud para unirte al viaje <strong>{{ $reservation->ride->name }}</strong> ha sido aceptada.</p>
    <ul>
        <li><strong>Origen:</strong> {{ $reservation->ride->origin }}</li>
        <li><strong>Destino:</strong> {{ $reservation->ride->destination }}</li>
        <li><strong>Fecha:</strong> {{ $reservation->ride->departure_time }}</li>
        <li><strong>Costo:</strong> ₡{{ $reservation->ride->cost }}</li>
    </ul>
    <p>Por favor, llega puntual.</p>
</body>
</html>
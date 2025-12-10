<x-mail::message>
# Tienes solicitudes de reservas pendientes.

Hola **{{ $driverName }}**,

**Recordatorio Urgente** del sistema.

Se han reconocido **{{ $count }}** {{ $count > 1 ? 'solicitudes' : 'solicitud' }} de reserva en estado **Pendiente** que tienen más de **{{ $minutes }} minutos** sin tu respuesta.

Por favor gestiona cada una de las reservas.

<x-mail::button :url="route('dashboard')">
Revisar Solicitudes Pendientes
</x-mail::button>

¡Gracias!

El equipo de {{ config('app.name') }}
</x-mail::message>
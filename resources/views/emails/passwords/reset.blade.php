@component('mail::layout')
@slot('header')
    @component('mail::header', ['url' => config('app.url_client')])
        <img src="https://rincondelmontero.com/wp-content/uploads/2020/07/logo_rincon_vertical_slogan.svg" width="250px" height="60px" alt="">
        <h4 style="margin:1px!important;">Week</h4>
    @endcomponent
@endslot
# Hola {{$user->name}}

Estas recibiendo este correo, ya que hemos recibido una solicitud para cambiar la contraseña de tu cuenta en Week

@component('mail::button', ['url' => $url])
Restablecer contraseña
@endcomponent

{{Lang::get('El enlace para restablecer la contraseña expirará en :count minutos.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')])}}
<br>
En caso de que no hayas realizado esta solicitud, no es necesario restablecerla.

@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} Week. @lang('Todos los derechos reservados')
    @endcomponent
@endslot
@endcomponent

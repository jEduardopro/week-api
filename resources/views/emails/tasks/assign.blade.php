@component('mail::layout')
@slot('header')
    @component('mail::header', ['url' => config('app.url_client')])
        {{-- <h4>
            {{$task->responsable->name}} te asigno una tarea
            <p style="font-size: 13px">
            <a href="{{config('app.url_client')}}/tasks/{{$task->id}}">Ver en week</a>
            </p>
        </h4> --}}
    @endcomponent
@endslot
<h2 style="color: black; line-height: 1;">
    {{$task->responsable->name}} te asigno una tarea
    <p style="font-size: 13px; margin: 0; padding: 0;">
        <a style="color: #30ADF5; text-decoration: none; margin: 0; padding: 0;" href="{{config('app.url_client')}}/tasks/{{$task->id}}">Ver en week</a>
    </p>
</h2>
<hr>
<h5 style="margin: 0; padding: 0;">Tarea</h5>
<h4 style="margin: 0; padding: 0;">{{$task->name}}</h4>

<h5 style="margin: 0; margin-top: 5px; padding: 0;">Fecha de vencimiento</h5>
<h4 style="margin: 0; padding: 0;">{{$task->due_date}}</h4>
{{--
@component('mail::button', ['url' => config('app.url_client')."/pendings/assigned/{$pending->id}/show"])
Ver pendiente asignado
@endcomponent --}}

@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} Week. @lang('Todos los derechos reservados')
    @endcomponent
@endslot
@endcomponent

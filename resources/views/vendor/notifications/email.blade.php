<x-mail::message>

{{-- Custom Header Logo --}}
<x-slot:header>
    <tr>
        <td class="header" style="padding: 25px 0; text-align: center;">
            <a href="{{ config('app.url') }}" style="display: inline-block;">
                @php
                    $path = public_path('images/logo-dekranasda.png');
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_exists($path) ? file_get_contents($path) : '';
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                @endphp
                <img src="{{ $base64 }}" 
                    alt="Dekranasda Kabupaten Tuban" 
                    style="max-height: 75px; width: auto; border: 0;">
            </a>
        </td>
    </tr>
</x-slot:header>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Hormat kami,<br>
**{{ config('app.name') }}**
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset

</x-mail::message>
@php
    $encoded = base64_encode($value ?? '');
    $type = $type ?? 'email';
    $class = $class ?? '';
    $linkText = $text ?? $value ?? '';
@endphp
<a href="#"
   class="obfuscated-link{{ $class ? ' ' . $class : '' }}"
   data-obfuscated="{{ $encoded }}"
   data-type="{{ $type }}"
   @if(!empty($alt)) aria-label="{{ $alt }}"@endif>{{ $linkText }}</a>

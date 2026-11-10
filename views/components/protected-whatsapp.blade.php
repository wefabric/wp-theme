@props(['number', 'message' => '', 'label' => null])
{!! \Theme\Helpers\ContactObfuscator::whatsapp($number, $message, $label, $attributes->toHtml()) !!}

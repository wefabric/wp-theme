@props(['phone', 'label' => null])
{!! \Theme\Helpers\ContactObfuscator::phone($phone, $label, $attributes->toHtml()) !!}

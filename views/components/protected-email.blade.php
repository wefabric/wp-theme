@props(['email', 'label' => null])
{!! \Theme\Helpers\ContactObfuscator::email($email, $label, $attributes->toHtml()) !!}

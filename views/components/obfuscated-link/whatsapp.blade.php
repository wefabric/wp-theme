<a href="#"
   data-obfuscated-whatsapp="{{ \Theme\Helpers\Obfuscator::encode($whatsapp) }}"
   @if(!empty($class)) class="{{ $class }}" @endif
   aria-label="{{ $ariaLabel ?? '' }}">{{ $text ?? '' }}</a>

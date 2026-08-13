<a href="#"
   data-obfuscated-email="{{ \Theme\Helpers\Obfuscator::encode($email) }}"
   @if(!empty($class)) class="{{ $class }}" @endif
   aria-label="{{ $ariaLabel ?? '' }}">{{ $text ?? '' }}</a>

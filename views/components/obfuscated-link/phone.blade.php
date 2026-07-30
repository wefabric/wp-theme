<a href="#"
   data-obfuscated-phone="{{ \Theme\Helpers\Obfuscator::encode($phone) }}"
   @if(!empty($class)) class="{{ $class }}" @endif
   aria-label="{{ $ariaLabel ?? '' }}">{{ $text ?? '' }}</a>

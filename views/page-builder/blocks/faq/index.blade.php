@php
    $faqs = [];
    if($postList = $block->get('faq')) {
        $fields = get_fields($postList->get('ID'));
        $faqs = $fields['faq'] ?? [];
    }
@endphp

@if($faqs)
    <div class="container mx-auto px-4 lg:px-0">
        @if($block->get('title')->get('show_separate_title'))
			@include('components.headings.normal', [
				'title' => $block->get('title'),
			])
        @endif
		
        <div class="faq-drawer lg:px-0">
            @foreach($faqs as $key => $faq)
                <div class="bg-gray-100">
                    <input class="faq-drawer__trigger mb-4" id="faq-drawer-{{$key}}" type="checkbox" />
                    <label class="faq-drawer__title relative block cursor-pointer text-md font-bold p-10 pb-7 lg:text-2xl" for="faq-drawer-{{$key}}">{{ $faq['question_and_answer']['question'] }}</label>
                    <div class="faq-drawer__content-wrapper">
                        <div class="faq-drawer__content bg-cta-light px-10 pb-8">
                            <p class="text-base">{{ $faq['question_and_answer']['answer'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
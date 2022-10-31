@php
    $faqs = [];
    if($postList = $block->get('faq')) {
        $fields = get_fields($postList->get('ID'));
        $faqs = $fields['faq'] ?? [];
    }
@endphp

@if($faqs)
    <div class="">
		@if($block->get('title')->get('show_separate_title'))
			@include('components.headings.collection', [
				'title' => $block->get('title'),
			])
		@endif
		
        <div class="faq-drawer lg:px-0">
            @foreach($faqs as $key => $faq)
				<div class="faq-drawer__block">
					<input class="faq-drawer__trigger" id="faq-drawer-{{$key}}" type="checkbox" />
					<label class="faq-drawer__title p-6" for="faq-drawer-{{$key}}">{{ $faq['question_and_answer']['question'] }}</label>

					<div class="faq-drawer__content-wrapper">
						<div class="faq-drawer__content z-20 p-6">
							<p class="">{{ $faq['question_and_answer']['answer'] }}</p>
						</div>
					</div>
				</div>
            @endforeach
        </div>
    </div>
@endif
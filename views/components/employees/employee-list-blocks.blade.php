<div class="container mx-auto">
    <div class="grid md:grid-cols-3">
        @foreach($postList as $employeeId)
            @php
                $fields = get_fields($employeeId);
                $service = get_post($employeeId);
            @endphp
            <div class="hover:shadow-3xl max-w-md z-10 mt-6 ml-4 mb-10 bg-grey-light">
                <div class="w-full h-96">
                    <img class="w-full h-full object-cover" src="{{ $fields['image'] }}">
                </div>
                <div class="text-2xl p-10 text-center">
                    <h3 class="text-center uppercase text-xl">{{ get_the_title($employeeId) }}</h3>
                    @if(isset($fields['overview_text']) && $fields['overview_text'])
                        <p class="text-center mt-4 mb-5 text-lg">{{ $fields['overview_text'] }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
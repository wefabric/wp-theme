<div class="grid md:grid-cols-2 xl:grid-cols-3">
    @foreach($postList as $employeeId)
        @php
            $fields = get_fields($employeeId);
        @endphp
        <div class="z-10 mt-6 ml-4 mb-10 px-2 md:px-0 employee-item">
            <div class="w-full h-96 relative bg-cover" style="background-image: url({{ $fields['image'] }})">
                <div class="absolute bg-white bottom-12 rounded-r-full w-11/12 pl-5 pr-24 pb-2">
                    <div class="text-left">
                        <h3 class="text-xl mt-3">{{ get_the_title($employeeId) }}</h3>
                        <span class="text-lg">{{ $fields['function'] }}</span>
                    </div>
                    <div class="absolute top-1/2 transform -translate-y-1/2 right-9">
                        @if(isset($fields['email']) && $fields['email'])
                            <a href="mailto:{{ $fields['email'] }}">
                                <i class="fas fa-envelope text-3xl text-tertiary"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
{{--@if($info->get('employees'))--}}
{{--    <div class="my-6">--}}

{{--        @foreach($info->get('employees') as $employeeId)--}}
{{--            @php--}}
{{--                $fields = get_fields($employeeId);--}}
{{--            @endphp--}}


{{--            <div class="flex flex-row gap-4 mb-6">--}}
{{--                <div class="rounded-full border w-[110px] h-[110px]">--}}
{{--                    @include('components.image', [--}}
{{--                       'image_id' => $fields['image'],--}}
{{--                       'size' => 'employee-thumbnail',--}}
{{--                       'class' => 'rounded-full disable-rounded',--}}
{{--                       'img_class' => 'rounded-full'--}}
{{--                   ])--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    @include('components.headings.normal', [--}}
{{--                        'type' => 'h3',--}}
{{--                        'heading' => get_the_title($employeeId),--}}
{{--                        'class' => 'text-xl h4',--}}
{{--                    ])--}}
{{--                    @if(isset($fields['function']) && $fields['function'])--}}
{{--                        <div class="mx-auto mb-3">--}}
{{--                            @include('components.content', [--}}
{{--                                'content' => $fields['function'],--}}
{{--                                'class' => '',--}}
{{--                            ])--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    <div class="mx-auto mb-3">--}}
{{--                        @if(!empty($fields['phonenumber']))--}}
{{--                            @include('components.buttons.icon', [--}}
{{--                                'href' => 'tel:'. $fields['phonenumber'],--}}
{{--                                'alt' => 'Telefoonnummer',--}}
{{--                                'icon' => 'fa-solid fa-phone text-sm align-top pt-1.5',--}}
{{--                                'size' => 'h-8 w-8',--}}
{{--                                'colors' => 'btn-black text-white ',--}}
{{--                                'a_class' => 'mx-1',--}}
{{--                            ])--}}
{{--                        @endif--}}

{{--                        @if(!empty($fields['email']))--}}
{{--                            @include('components.buttons.icon', [--}}
{{--                                'href' => 'mailto:'. $fields['email'],--}}
{{--                                'alt' => 'Emailadres',--}}
{{--                                'icon' => 'fa-solid fa-envelope text-sm align-top pt-1.5',--}}
{{--                                'size' => 'h-8 w-8',--}}
{{--                                'colors' => 'btn-black text-white ',--}}
{{--                                'a_class' => 'mx-1',--}}
{{--                            ])--}}
{{--                        @endif--}}

{{--                        @if(!empty($fields['linkedin']))--}}
{{--                            @include('components.buttons.icon', [--}}
{{--                                'href' => $fields['linkedin'],--}}
{{--                                'alt' => 'LinkedIn',--}}
{{--                                'icon' => 'fa-brands fa-linkedin-in text-sm align-top pt-1.5',--}}
{{--                                'size' => 'h-8 w-8',--}}
{{--                                'colors' => 'btn-black text-white ',--}}
{{--                                'a_class' => 'mx-1',--}}
{{--                            ])--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}


{{--        @endforeach--}}
{{--    </div>--}}
{{--@endif--}}
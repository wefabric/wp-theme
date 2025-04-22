<div class="establishment-item opening-hours-section">
    {{-- Opening hours --}}
    @if(in_array('establishment_opening_hours', $establishmentElements) && !empty($opening_hours))
        <div class="opening-hours-section">
            <div class="opening-hours-text font-bold mb-2">Openingstijden</div>
            <div class="flex flex-col">
                @foreach ($opening_hours as $day)
                    <div class="flex items-center sm:gap-x-4 justify-between sm:justify-start">
                        <span class="w-fit sm:w-[100px]">{{ $day['day'] ?? 'Onbekend' }}</span>
                        @if (!empty($day['closed']) && $day['closed'])
                            <span>Gesloten</span>
                        @else
                            <span>
												{{ $day['opening_hour'] ?? '00:00' }} uur - {{ $day['closing_hour'] ?? '00:00' }} uur
												@if (!empty($day['opening_hour_2']) && !empty($day['closing_hour_2']))
                                    & {{ $day['opening_hour_2'] }} uur - {{ $day['closing_hour_2'] }} uur
                                @endif
											</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

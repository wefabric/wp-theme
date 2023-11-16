<div class="mt-24">
    @foreach ($tables as $index => $table)
        <div class="mt-12">
            @if($table['table_title'])
                <h3 class="text-{{ $titleColor }} mb-4">{{ $table['table_title'] }}</h3>
            @endif
            <table class="w-full border">
                <tbody>
                @foreach ($table['table_data'] as $rowIndex => $row)
                    <tr class="{{ $rowIndex % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} border-b">
                        <td class="py-4 px-4 w-4/5">{{ $row['category'] }}</td>
                        <td class="py-4 px-4 w-1/5 whitespace-nowrap">€ {{ $row['price'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>
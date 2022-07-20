<div class="container mx-auto">
    <div class="grid md:grid-cols-3">
        @foreach($postList as $employeeId)
            @include('components.cards.employee', [
	            'employeeId' => $employeeId,
            ])
        @endforeach
    </div>
</div>
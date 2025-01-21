<div class="steps flex flex-col mx-auto">
    @foreach ($steps as $step)
        @include('components.workflow.vertical-list-item')
    @endforeach
</div>
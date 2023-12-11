@foreach($posts as $post)
    @php $post = $post->get('ID'); @endphp
    @include('components.news.list-item', ['post', $post])
@endforeach
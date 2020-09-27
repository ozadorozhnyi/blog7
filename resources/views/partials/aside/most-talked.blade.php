@isset($mostTalkedAbout)
    @if ($mostTalkedAbout->count() > 0)
        <h4 class="font-italic">
            Most talked about
        </h4>
        @foreach ($mostTalkedAbout as $article)
            <div class="mb-3" title="{{ $article->title }}">
                <a href="{{ route('articles.show', ['article'=>$article->id]) }}">
                    @if (isset($article->image))
                        <img src="{{ asset("images/{$article->image->hashed}") }}"
                            alt="{{ $article->title }}" width="280" class="mb-2">    
                    @endif
                    <h6>{{ $article->title }}</h6>
                </a>
            </div>
        @endforeach
    @endif
@endisset
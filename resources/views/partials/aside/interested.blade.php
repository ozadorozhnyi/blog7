@isset($interested)
    @if ($interested->count() > 0)
        <br>
        <h4 class="font-italic">
            You may also be interested
        </h4>
        <ol class="mt-4 list-unstyled bg-light ">
            @foreach ($interested as $article)
                <li class="mb-1 pb-2">
                    <a href="{{ route('articles.show', ['article'=>$article->id]) }}" class="text-dark font-weight-bold">
                        {{ $article->title }}
                    </a>
                </li>
            @endforeach
        </ol>    
    @endif    
@endisset

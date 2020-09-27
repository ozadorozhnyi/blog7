@php $articlesQty = Auth::user()->articles()->count() @endphp
@if ($articlesQty > 0)
    <h3 class="mb-4">
        My Articles ({{ $articlesQty }})
    </h3>
    <ul class="list-unstyled">
        @foreach (Auth::user()->articles as $article)
            <li class="media mb-3 border-bottom">
                <img src="{{ asset("images/{$article->image->hashed}") }}" class="mr-3" alt="{{ $article->title }}" width="64">
                <div class="media-body">
                    <h6 class="my-0">
                        <a href="{{ route('articles.show', ['article'=>$article->id]) }}" target="__blank" title="Open on the web site.">
                            {{ $article->title }}
                        </a>
                    </h6>
                    <p>
                        <small class="text-muted">
                            Created at: <span class="bg-secondary text-white px-1 rounded">{{ $article->updated_at->format("F j, Y, g:i a") }}</span>
                            Last updated: <span class="bg-warning text-dark px-1 rounded">{{ $article->updated_at->diffForHumans() }}</span>
                        </small>
                        <br>
                        <span class="mt-2">{{ \Str::words($article->preview, 20), }}</span>
                        <div>
                            <form action="{{ route('articles.destroy', ['article'=>$article->id]) }}" method="POST">
                                @csrf
                                {{method_field('DELETE')}}
                                <a href="{{ route('articles.edit', ['article'=>$article->id]) }}" class="btn btn-sm btn-primary" title="Edit article">
                                    Edit
                                </a>
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete article">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </p>
                </div>
            </li>    
        @endforeach
    </ul>
@else
    <p>Sorry, you have no articles yet :(</p>
@endif
@if ($articles->count() > 0)
    <!-- Header -->
    <div>
        <h4 class="pb-1 mb-1 font-italic border-bottom">
            Search results for the <span class="px-1 bg-warning text-dark">{{ $searchTerm }}</span>...
        </h4>
        <small class="text-muted mb-3 d-block font-italic">
            Results found: <strong>{{ $articles->count() }}</strong>
        </small>
    </div>
    
    <ul class="list-unstyled">
        @foreach ($articles as $article)
            <li class="media mb-3 border-bottom">
                @if (isset($article->image))
                    <img src="{{ asset("images/{$article->image->hashed}") }}" 
                        class="mr-3" alt="{{ $article->title }}" width="64">    
                @endif
                
                <div class="media-body">
                    <h6 class="my-0">
                        <a href="{{ route('articles.show', ['article'=>$article->id]) }}" target="_blank" title="Open on the web site.">
                            @php 
                                $hlightedTitle = sprintf('<span class="px-1 bg-warning">%s</span>', $searchTerm);
                                echo \str_ireplace($searchTerm, $hlightedTitle, $article->title);
                            @endphp
                        </a>
                    </h6>
                    <p>
                        <small class="text-muted mb-1 d-inline-block">
                            Created at: <span class="font-weight-bold">{{ $article->updated_at->format("M j, Y, g:i a") }}</span>
                            by <span class="font-weight-bold">{{ $article->author->name }}</span>
                        </small>
                        <br>
                        <!-- Body highlighted -->
                        <span class="mt-2">
                            @if (Str::contains($article->description, $searchTerm))
                                @php 
                                    $hlightedTerm = sprintf('<span class="px-1 bg-warning font-weight-bold">%s</span>', $searchTerm);
                                    $hlightedBody = \str_ireplace($searchTerm, $hlightedTerm, $article->description);
                                    
                                    $textBefore = Str::words(Str::before($hlightedBody, $searchTerm), rand(8,11), '');
                                    $textAfter = Str::words(Str::after($hlightedBody, $searchTerm), rand(8,11), '');

                                    echo "$textBefore...$hlightedTerm...$textAfter";
                                @endphp    
                            @else
                                {{ Str::words($article->preview, 20) }}
                            @endif
                        </span>
                    </p>
                </div>
            </li>
        @endforeach
      </ul>
@else
    <p>No records matches your search :(</p>
@endif
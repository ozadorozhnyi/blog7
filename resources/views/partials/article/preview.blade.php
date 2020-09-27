@if ($articles->count() > 0)
    <h3 class="pb-4 mb-4 font-italic border-bottom">
        Read latest hot news
    </h3>

    <!-- Display lates X articles -->
    @foreach ($articles as $article)
        <div class="blog-post">
            
            @php $url_title = 'Read more' @endphp 
            @php $article_url = route('articles.show', ['article'=>$article->id]) @endphp 
            
            <!-- Title -->
            <a href="{{ $article_url }}" title="{{ $url_title }}">
                <h3 class="blog-post-title">
                    {{ $article->title }}
                </h3>
            </a>

            <!-- Meta Info -->
            @include('partials.article.meta-info')

            <!-- Image Assigned -->
            @include('partials.article.image')
            
            <!-- Short description -->
            <p class="blog-post-preview">
                {{ $article->preview }}
            </p>
            
            <!-- Read more url -->
            <a href="{{ $article_url }}" title="{{ $url_title }}">
                Read more&nbsp;&#8594;
            </a>

        </div>    
    @endforeach

    {{ $articles->links() }}
    
@else
    @include('partials.alert.warning')    
@endif
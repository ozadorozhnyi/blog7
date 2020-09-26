<div class="blog-post">
        
    <h3 class="blog-post-title">
        {{ $article->title }}
    </h3>

    @include('partials.article.meta-info')

    <img src="{{ $article->image }}" alt="{{ $article->title }}" title="{{ $article->title }}" class="blog-post-image">
    
    <p class="blog-post-preview">
        {{ $article->description }}
    </p>

    <!-- Share Links -->
    @if (config('blog.share_links')->display)
        @include(sprintf("partials.share.%s", config('blog.share_links')->service))    
    @endif

</div>
@if (isset($article->image))
    <img src="{{ asset("images/{$article->image->hashed}") }}"
        alt="{{ $article->title }}" title="{{ $article->title }}"
        class="blog-post-image" width="{{ config('blog.image')->resolution->width }}">    
@endif
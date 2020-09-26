<p class="blog-post-meta">
    {{ $article->updated_at->diffForHumans() }} by
    <a href="mailto:{{ $article->author->email }}" class="">
        {{ $article->author->name }}
    </a>
</p>
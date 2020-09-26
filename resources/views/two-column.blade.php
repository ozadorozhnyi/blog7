@extends('layouts.app')

@section('content')
    <main role="main" class="container">
        <div class="row">
            <div class="col-md-8 blog-main">
                @include(sprintf("partials.article.%s", $template))
            </div>
            <aside class="col-md-4 blog-sidebar">
                <div class="px-3 mb-3 bg-light rounded">
                    @include('partials.aside.most-talked')
                    @include('partials.aside.interested')
                </div>
                <div class="p-4">
                    @include('partials.aside.developer')
                </div>
            </aside>
        </div>
    </main>
@endsection
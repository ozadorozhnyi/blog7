@extends('layouts.app')

@section('content')
    <main role="main" class="container">
        @include('partials.alert.session')
        <div class="row">
            <div class="col-md-8 blog-main">
                @include(sprintf("ArtManager.%s", $page))
            </div>
            <aside class="col-md-4 blog-sidebar">
                <div class="px-3 mb-3 bg-light rounded p-2" style="background-color: #fff !important;">
                    <!-- Create New Article -->
                    @include('ArtManager.create')
                </div>
            </aside>
        </div>
    </main>
@endsection
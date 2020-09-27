@extends('layouts.app')

@section('content')
    <main role="main" class="container">
        @include('partials.alert.session') <!-- ??? -->
        <div class="row">
            <div class="col-md-8 blog-main">
                
                <h4 class="mb-4">
                    Edit Article Info
                </h4>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('articles.update', ['article'=>$article->id]) }}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <!-- Title -->
                    <div class="form-group">
                        <label for="title">
                            <strong>Title</strong><span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title" value="{{ $article->title }}" id="title" class="form-control" placeholder="Put article title" minlength="10" maxlength="255" required autofocus>
                    </div>
                
                    <!-- Preview -->
                    <div class="form-group">
                        <label for="preview">
                            <strong>Preview Text</strong>&nbsp;<span class="text-danger">*</span>
                        </label>
                        <textarea name="preview" id="preview" class="form-control" rows="6" placeholder="Put article preview text" minlength="10" required>{{ $article->preview }}</textarea>
                    </div>
                
                    <!-- Body -->
                    <div class="form-group">
                        <label for="description">
                            <strong>Article Body</strong>&nbsp;<span class="text-danger">*</span>
                        </label>
                        <textarea name="description" id="description" class="form-control" rows="12" placeholder="Put article body" minlength="10" required>{{ $article->description }}</textarea>
                    </div>
                
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary">
                        Update Info
                    </button>
                </form>
            </div>
            <aside class="col-md-4 mt-3">
                <div class="px-3 mb-3 bg-light rounded p-2" style="background-color: #fff !important;">
                    <!-- Manage Linked File -->
                    <h5 class="font-italic">
                        Linked File
                    </h5>
                    @if (isset($article->image))
                        <img src="{{ asset("images/{$article->image->hashed}") }}" alt="{{ $article->title }}" width="300" class="rounded">
                        <ul class="list-group ml-3 mt-3 p-0">
                            <li>
                                Size on disk: <strong>{{ \round(Storage::disk('images')->size($article->image->hashed)/1024,2) }}</strong> Kb
                            </li>
                            <li>Updated: <strong>{{ $article->image->updated_at }}</strong></li>
                            <li>
                                MIME Type: <strong>{{ Storage::disk('images')->getMimeType($article->image->hashed) }}</strong>
                            </li>
                        </ul>
                    @endif
                </div>
            </aside>
        </div>
    </main>
@endsection
<h4 class="mb-4">
    Create a new article
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

<form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- Title -->
    <div class="form-group">
        <label for="title">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control" placeholder="Put article title" minlength="10" maxlength="255" required autofocus>
    </div>

    <!-- Preview -->
    <div class="form-group">
        <label for="preview">Preview Text <span class="text-danger">*</span></label>
        <textarea name="preview" id="preview" class="form-control" rows="3" placeholder="Put article preview text" minlength="10" required>{{ old('preview') }}</textarea>
    </div>

    <!-- Body -->
    <div class="form-group">
        <label for="description">Article Body <span class="text-danger">*</span></label>
        <textarea name="description" id="description" class="form-control" rows="6" placeholder="Put article body" minlength="10" required>{{ old('description') }}</textarea>
    </div>

    <!-- Image File -->
    <div class="form-group p-3 mb-3 bg-light text-dark border border-info rounded">
        <label for="image">Article Image <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="custom-file">
                <input type="hidden" name="MAX_FILE_SIZE" value="{{ config('blog.image')->max_file_size }}" />
                <input type="file" name="image" id="image" class="custom-file-input" required>
                <label class="custom-file-label" for="image">Choose file</label>
            </div>
        </div>
        <small class="form-text text-muted mb-3 font-italic" title="File requirements">
            {{ sprintf("Only image file is allowed with min. resolution: %dx%d", 
                config('blog.image')->resolution->width,
                config('blog.image')->resolution->height)
            }}
        </small>
    </div>

    <!-- Submit button -->
    <button type="submit" class="btn btn-primary">
        Create Article
    </button>
</form>
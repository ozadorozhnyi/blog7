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

    <!-- Image File -->
    <div class="form-group">
        <label for="image">Article Image <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="custom-file">
                <input type="hidden" name="MAX_FILE_SIZE" value="15728640" />
                <input type="file" name="image" id="image" class="custom-file-input" required>
                <label class="custom-file-label" for="image">Choose file</label>
            </div>
        </div>
        <small class="form-text text-muted mb-3 font-italic" title="File requirements">
            @php
                $uploadConf = config('blog.image');
                echo sprintf("Res. %dx%d px, Max: %dMb; %s only.", 
                    $uploadConf->resolution->width,
                    $uploadConf->resolution->height,
                    (($uploadConf->max_file_size/1024)/1024),
                    $uploadConf->mime_types_allowed
                )
            @endphp
        </small>
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

    <!-- Submit button -->
    <button type="submit" class="btn btn-primary">
        Create Article
    </button>
</form>
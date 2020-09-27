<form action="{{ route('articles.search') }}" method="POST" class="form-inline mr-5">
    @csrf
    <input type="text" name="searchTerm" value="" class="form-control form-control-sm mr-sm-2" placeholder="what are you looking for?" aria-label="Search" minlength="3" maxlength="255">
    <button type="submit" class="btn btn-sm btn-outline-primary my-2 my-sm-0">
        Search
    </button>
</form>
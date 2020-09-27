@if (session('status'))
    <p>
        <div id="session-alert" class="alert alert-primary" role="alert">
            {{ session('status') }}
        </div>
    </p>
@endif
<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

use App\Http\Requests\StoreArticle;
use App\Http\Requests\StoreImage;
use App\Http\Requests\OverSizeImage;
use App\Http\Requests\SearchTerm;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Image;
use Illuminate\Support\Facades\Storage;

class ArticlesController extends Controller
{
    /**
     * Search articles by title or description.
     *
     * @param  App\Http\Requests\SearchTerm  $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchTerm $request)
    {
        $validated = $request->validated();
        
        $matches = Article::orderBy('updated_at', 'desc')
            ->where('title', 'LIKE', "%{$validated['searchTerm']}%")
            ->orWhere('description', 'LIKE', "%{$validated['searchTerm']}%")
            ->get();

        return view('two-column', [
            'articles' => $matches,
            'searchTerm' => $validated['searchTerm'],
            'template' => 'search'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latest = Article::latest()->simplePaginate(
            config('blog.articles')->per_page
        );

        $interested = Article::latest()
            ->select('id', 'title')
            ->take(config('blog.articles')->interested)
            ->whereNotIn('id', $latest->pluck('id')->toArray())
            ->get()
            ->shuffle();

        $mostTalkedAbout = $interested->splice(0, config('blog.articles')->most_talked);
        
        return view('two-column', [
            'articles' => $latest,
            'interested' => $interested,
            'mostTalkedAbout' => $mostTalkedAbout,
            'template' => 'preview'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreArticle  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticle $request)
    {
        // Run a validation for the Article 
        $articleData = $request->validated();
        
        // and Image, uploaded with...
        $storeImage = Validator::make(
            $request->all(), (new StoreImage)->rules()
        );

        if ($storeImage->fails()) {
            return redirect('artmanager')
                    ->withErrors($storeImage)
                    ->withInput();
        }

        // Create a new Article record into the articles table.
        $article = Auth::user()->articles()->create($articleData);
        
        /**
         * Move uploaded file into the public storage.
         * First argument is skipped to allow a file name to be automatically generated.
         */
        $uniqueFileName = $request->image->store(null, 'images');

        // Run a validation for the oversized images
        $overSizeImage = Validator::make(
            $request->all(), (new OverSizeImage)->rules()
        );

        if ($overSizeImage->fails()) {
            // Resize to parameters specified in the configuration file
            Image::make(Storage::disk('images')->get($uniqueFileName))
                ->resize(
                    config('blog.image')->resolution->width,
                    config('blog.image')->resolution->height
                )->save(Storage::disk('images')->path($uniqueFileName));
        }

        // Add Image record into the images table.
        $article->image()->create([
            'original' => $request->image->getClientOriginalName(),
            'hashed' => $uniqueFileName
        ]);
        
        return redirect('artmanager')->with(
            'status', 'New article was successfully added!'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $interested = Article::latest()
            ->select('id', 'title')
            ->take(config('blog.articles')->interested)
            ->whereNotIn('id', [$article->id])
            ->get()
            ->shuffle();

        $mostTalkedAbout = $interested->splice(0, config('blog.articles')->most_talked);
        
        return view('two-column', [
            'article' => $article,
            'interested' => $interested,
            'mostTalkedAbout' => $mostTalkedAbout,
            'template' => 'full'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->middleware('auth');

        if ($article->user_id === Auth::user()->id) {
            return view('ArtManager.edit', [
                'article' => $article
            ]);
        } else {
            return redirect('artmanager')
                ->with('status', 'Error! You can edit your own articles only.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreArticle  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArticle $request, Article $article)
    {
        $this->middleware('auth');

        // Run a validation for the Article 
        $articleData = $request->validated();

        if ($article->user_id === Auth::user()->id) {
        
            // Update Article with a fresh data
            $article->title = $articleData['title'];
            $article->preview = $articleData['preview'];
            $article->description = $articleData['description'];

            // and changes into th database
            $article->save();

            $statusMsg = 'Article information was successfully updated!';
        } else {
            $statusMsg = 'Error! You can edit your own articles only.';
        }

        return redirect('artmanager')
                ->with('status', $statusMsg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->middleware('auth');

        if ($article->user_id === Auth::user()->id) {

            if (isset($article->image)) {
                // for first: try to delete file linked
                $article->image->delete();
            }

            // then, delete from the database Article instance itself...
            $article->delete();
            
            $statusMsg = 'Article with all related information was successfully deleted!';
        } else {
            $statusMsg = 'Error! You can delete your own articles only .';
        }
        
        return redirect('artmanager')->with('status', $statusMsg);
    }
}

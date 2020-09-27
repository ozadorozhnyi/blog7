<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticle;
use App\Http\Requests\StoreImage;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticle $request)
    {

        $article_data = $request->validated();
        
        $storeImage = Validator::make(
            $request->all(), (new StoreImage)->rules()
        );

        if ($storeImage->fails()) {
            return redirect('artmanager')
                    ->withErrors($storeImage)
                    ->withInput();
        }

        /**
         * Create a new Article record into the articles table.
         */
        $article = Auth::user()->articles()->create($article_data);
        
        /**
         * Move uploaded file into the public storage.
         * First argument is skipped to allow a file name to be automatically generated.
         */
        $uniqFileName = $request->image->store(null, 'images');

        /**
         * Add Image record into the images table.
         */
        $article->image()->create([
            'original' => $request->image->getClientOriginalName(),
            'hashed' => $uniqFileName
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

        echo __METHOD__;
        dd($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $this->middleware('auth');
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

            /**
             * For first: delete Image record from the database
             * and File linked with this instance.
             */
            if (isset($article->image)) {
                $article->image->delete();
            }

            // Delete Article instance itself
            $article->delete();
            
            $statusMsg = 'Article with all related information was successfully deleted!';
        } else {
            $statusMsg = 'Error! You can delete only your own articles.';
        }
        
        return redirect('artmanager')->with('status', $statusMsg);
    }
}

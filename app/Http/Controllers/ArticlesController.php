<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
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
            ->select('id', 'title', 'image')
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'bail|required|min:10|max:255',
            'preview' => 'bail|required|min:10',
            'description' => 'bail|required|min:10',
        ]);

        $image = $request->validate([
            'image' => sprintf('bail|required|file|image'),
            'image' => sprintf("max:%d",config('blog.image')->max_file_size),
            'image' => sprintf("mimes:%s",config('blog.image')->mime_types_allowed),
            'image' => sprintf("dimensions:max_width=%d,max_height=%d",
                config('blog.image')->resolution->width,
                config('blog.image')->resolution->height
            ),
        ]); 

        dd(
            $request->all(),
            $data,
            $image
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
            ->select('id', 'title', 'image')
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
            $article->delete();
            $statusMsg = 'Article was successfully deleted!';
        } else {
            $statusMsg = 'Error! You can delete only your own articles.';
        }
        
        return redirect('artmanager')->with('status', $statusMsg);
    }
}

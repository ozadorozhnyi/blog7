<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Contracts\Image\ImageContract;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Article::class);
        $articles = Article::get();
        return view('articles/index', compact('articles'));
    }

    public function indexToHome() {

        $articles = Article::get();

        $articles->map(function ($article) {
            $article->image_url = $article->image ? Storage::url($article->image) : 'storage/images/articles/blank_l.jpg';
            return $article;
        });
        return view('welcome', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Article $article)
    {
        Gate::authorize('create', $article);
        $action = '/articles';
        return view('articles/create', compact('article', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        Gate::authorize('create', Article::class);
        $input = $request->input();

        if($request->hasFile('image')) {
            $path = $this->storeImage($request);
            $input['image'] = $path;
        }

        Article::create($input);
        return redirect('/articles');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('articles/show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        Gate::authorize('update', $article);
        $article->image_url = $article->image ? Storage::url($article->image) : null;
        $action = '/articles/'.$article->id;
        $method = 'PUT';
        return view('articles/create', compact('article', 'action', 'method'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        Gate::authorize('update', $article);
        $input = $request->input();

        if($request->hasFile('image')) {
            $path = $this->storeImage($request);
            $input['image'] = $path;
        }
        $article->update($input);
        return redirect('/articles');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);
        $article->delete();
        return 'article ' . $article->id . ' has been deleted';
    }

    protected function storeImage($request) {

        $url = $request->file('image')->store('images/articles', 'public');
        $path_origin = Storage::disk('public')->path($url);
        $pattern = '/(\.[0-9a-z]{1,5})$/i';
        $repl = '_l' . '$1';
        $new_url = preg_replace($pattern, $repl, $url);
        $new_path = Storage::disk('public')->path($new_url);
        $imageManager = App::make(ImageContract::class);
        $imageManager->make($path_origin)->resize(200, 200)->save($new_path);
        return $new_url;
    }
}

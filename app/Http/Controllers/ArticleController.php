<?php

namespace App\Http\Controllers;

use Auth;
use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CommentResource;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Article::class);
        return ArticleResource::collection(Article::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Article::class);
        $article = request()->user()->Articles()->create($this->validateData());

        ArticleResource::withoutWrapping();
        return (new ArticleResource($article))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $Article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->authorize('view', $article);
        ArticleResource::withoutWrapping();
        return new ArticleResource($article);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $Article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $article->update($this->validateData());
        return (new ArticleResource(Article::find($article->id)))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $Article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();
        return response([], Response::HTTP_NO_CONTENT);
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param  \App\Article  $Article
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'score' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $comment = $article->comments()->create($data);
        CommentResource::withoutWrapping();
        return (new CommentResource($comment))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }

    public function comments(Article $article)
    {
        return CommentResource::collection($article->comments);
    }

    public function myArticles()
    {
        $user = Auth::user();
        return ArticleResource::collection($user->Articles()->paginate(3)); 
    }
    
    public function validateData()
    {
        return request()->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'required'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Auth;
use App\Book;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Resources\CommentResource;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Book::class);
        return BookResource::collection(Book::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Book::class);
        $book = request()->user()->books()->create($this->validateData());

        BookResource::withoutWrapping();
        return (new BookResource($book))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $this->authorize('view', $book);
        BookResource::withoutWrapping();
        return new BookResource($book);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $book->update($request->all());
        return (new BookResource($contact))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);
        $book->delete();
        return response([], Response::HTTP_NO_CONTENT);
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'score' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $comment = $book->comments()->create($data);
        
        CommentResource::withoutWrapping();
        return (new CommentResource($comment))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }

    public function comments(Book $book)
    {
        return CommentResource::collection($book->comments);
    }

    public function myBooks()
    {
        $user = Auth::user();
        return BookResource::collection($user->books()->paginate(3)); 
    }
    
    public function validateData()
    {
        return request()->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'required',
            'author_id' => 'required'
        ]);
    }
}

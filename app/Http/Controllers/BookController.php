<?php

namespace App\Http\Controllers;

use Auth;
use App\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
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
        return BookResource::collection(Book::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validateData();
        $data['user_id'] = Auth::user()->id;
        $book = Book::create($data);
        
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
        $book->delete();
        return response([], Response::HTTP_NO_CONTENT);
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

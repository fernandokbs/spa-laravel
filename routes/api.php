<?php

Route::middleware('auth:api')->group(function() {
    Route::apiResource('/books', 'BookController');
    Route::post('/books/{book}/comment', 'BookController@comment');
    Route::get('/books/{book}/comments', 'BookController@comments');
    Route::get('/my_books', 'BookController@myBooks');
    Route::get('/authors', 'AuthorController@index');
});

<?php

Route::middleware('auth:api')->group(function() {
    Route::get('/authors', 'AuthorController@index');
    Route::apiResource('/books', 'BookController');
    Route::post('/books/{book}/comment', 'BookController@comment');
    Route::get('/books/{book}/comments', 'BookController@comments');
});

<?php

Route::middleware('auth:api')->group(function() {
    Route::get('/authors', 'AuthorController@index');
    Route::apiResource('/books', 'BookController');
});

<?php

Route::get('/authors', 'AuthorController@index');
Route::apiResource('/books', 'BookController');
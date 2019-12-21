<?php

Route::middleware('auth:api')->group(function() {
    Route::apiResource('/articles', 'ArticleController');
    Route::get('/articles/{article}/comments', 'ArticleController@comments');
    Route::get('/my_articles', 'ArticleController@myArticles');
    Route::get('/authors', 'AuthorController@index');
});

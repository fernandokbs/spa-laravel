<?php

Route::middleware('auth:api')->group(function() {
    Route::apiResource('/articles', 'ArticleController');
    Route::post('/articles/{articles}/comment', 'ArticleController@comment');
    Route::get('/articles/{articles}/comments', 'ArticleController@comments');
    Route::get('/my_articles', 'ArticleController@myArticles');
    Route::get('/authors', 'AuthorController@index');
});

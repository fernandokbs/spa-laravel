<?php

Route::get('/{any}', 'HomeController@index')->where('any','.*');
Auth::routes();
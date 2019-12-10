<?php

Auth::routes();

Route::get('/{any}', 'HomeController@index')->where('any','.*');
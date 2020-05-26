<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PostController@index')->name('home');

Auth::routes(['verify' => true]);

// Route::get('/download-laravel-file', 'HomeController@downloadLaravelFile')->name('downloadLaravelFile');
// Route::get('/download-fajar-picture', 'HomeController@downloadFajarPicture')->name('downloadFajarPicture');
// Route::get('/view-laravel-file', 'HomeController@viewLaravelFile')->name('viewLaravelFile');
// Route::get('/view-fajar-picture', 'HomeController@viewFajarPicture')->name('viewFajarPicture');
Route::get('/post/my-posts', 'PostController@myPosts')->name('post.myPosts');
Route::get('/post/my-trashed-posts', 'PostController@myTrashedPosts')->name('post.myTrashedPosts');
Route::get('/post/{post}/restore', 'PostController@restore')->name('post.restore');
Route::get('/post/{post}/force-delete', 'PostController@forceDelete')->name('post.forceDelete');
Route::post('/post/add-comment', 'PostController@addComment')->name('post.addComment');
Route::resource('/post', 'PostController');
Route::resource('/user', 'UserController');
Route::resource('posts.comments', 'PostCommentController');
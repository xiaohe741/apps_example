<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Author: xiaohe741@sina.com
// +----------------------------------------------------------------------

Route::rule('login','index/login');

Route::rule('plugin/:name','plugin/index');

Route::get('photos/[:folder]', 'photo/index')->mergeExtraVars();
Route::post('photos/create', 'photo/create');
Route::post('photos/update', 'photo/update');
Route::post('photos/remove', 'photo/remove');
Route::post('photos/rename', 'photo/rename');


// Route::resource('photos', 'photo')->vars(['photos'=> 'folder']);
Route::resource('plugins', 'plugin');
Route::resource('datas', 'data')->vars(['data'=> 'name']);
Route::resource('collections', 'collection');


Route::get('hello/:id','index/hello')->model('\app\model\User');

return [

];
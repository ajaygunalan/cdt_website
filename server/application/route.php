<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::group('api', [
    'user/login' => ['index/user/login', ['method' => 'post']],
    'user/register' => ['index/user/register', ['method' => 'post']],
    'user/detail' => ['index/user/detail', ['method' => 'get']],

    'data/getData' => ['index/data/getData', ['method' => 'get']],
    'data/delete' => ['index/data/delete', ['method' => 'post']],
    'data/getGPSData' => ['index/data/getGPSData', ['method' => 'get']],
    'data/addGPSData' => ['index/data/addGPSData', ['method' => 'post']],
    
    'file/upload' => ['index/file/upload', ['method' => 'post']],
]);

Route::group('admin', [
    'admin/login' => ['admin/admin/login', ['method' => 'post']],
    'admin/register' => ['admin/admin/register', ['method' => 'post']],
    'admin/detail' => ['admin/admin/detail', ['method' => 'get']],


    'user/getList' => ['admin/user/getList', ['method' => 'get']],

    'data/getData' => ['admin/data/getData', ['method' => 'get']],
    'data/delete' => ['admin/data/delete', ['method' => 'post']],
    'data/getGPSData' => ['admin/data/getGPSData', ['method' => 'get']],
    
    'file/upload' => ['admin/file/upload', ['method' => 'post']],
    'data/download' => ['admin/data/download', ['method' => 'post']],
]);

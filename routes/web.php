<?php

use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/departments', function () { {
        return view('departments.index');
    }
});

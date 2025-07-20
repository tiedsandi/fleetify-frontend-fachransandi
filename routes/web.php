<?php

use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('absensi');
});

Route::get('/departments', function () { {
        return view('departments');
    }
});
Route::get('/employees', function () { {
        return view('employee');
    }
});
Route::get('/absensi-log', function () { {
        return view('absensi-log');
    }
});

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColaboratorsController;
use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RhController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\AdminOrRH;
use App\Http\Middleware\Colaborator;
use App\Http\Middleware\RH;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
  // email confirmation and password definition
  Route::get('/confirm-account/{token}', [ConfirmAccountController::class, 'confirmAccount'])->name('confirm-account');
  Route::post('/confirm-account', [ConfirmAccountController::class, 'confirmAccountSubmit'])->name('confirm-account-submit');
});

Route::middleware('auth')->group(function () {

  Route::redirect('/', 'home');
  Route::get('/home', [HomeController::class, 'index'])->name('home');

  // user profile page
  Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
  Route::post('/user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.profile.update-password');
  Route::post('/user/profile/update-user-data', [ProfileController::class, 'updateUserData'])->name('user.profile.update-user-data');
  Route::post('/user/profile/update-user-address', [ProfileController::class, 'updateUserAddress'])->name('user.profile.update-user-address');

  Route::middleware([Admin::class])->group(function () {

    // dash admin
    Route::get('/users-admin/home', [AdminController::class, 'home'])->name('users.admin.home');

    // department route
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/departments/new', [DepartmentController::class, 'newDepartment'])->name('departments.new');
    Route::post('/departments/create', [DepartmentController::class, 'createDepartment'])->name('departments.create');
    Route::get('/departments/edit/{id}', [DepartmentController::class, 'editDepartment'])->name('departments.edit');
    Route::post('/departments/update', [DepartmentController::class, 'updateDepartment'])->name('departments.update');
    Route::get('/departments/delete/{id}', [DepartmentController::class, 'deleteDepartment'])->name('departments.delete');
    Route::get('/departments/delete-confirm/{id}', [DepartmentController::class, 'deleteDepartmentConfirm'])->name('departments.delete-confirm');

    // colaborators rh
    Route::get('/users-rh', [RhController::class, 'index'])->name('users.rh');
    Route::get('/users-rh/new', [RhController::class, 'newColaborator'])->name('users.rh.new');
    Route::post('/users-rh/create', [RhController::class, 'createColaborator'])->name('users.rh.create');
    Route::get('/users-rh/edit/{id}', [RhController::class, 'editColaborator'])->name('users.rh.edit');
    Route::post('/users-rh/update', [RhController::class, 'updateColaborator'])->name('users.rh.update');
    Route::get('/users-rh/delete/{id}', [RhController::class, 'deleteColaborator'])->name('users.rh.delete');
    Route::get('/users-rh/delete-confirm/{id}', [RhController::class, 'deleteColaboratorConfirm'])->name('users.rh.delete-confirm');
    Route::get('/users-rh/restore/{id}', [RhController::class, 'restoreColaborator'])->name('users.rh.restore');
    Route::get('/users-rh/details/{id}', [RhController::class, 'showDetails'])->name('users.rh.details');
  
  });

  Route::middleware([AdminOrRH::class])->group(function () {
    
    // colaborators other departments
    Route::get('/users-colaborators', [ColaboratorsController::class, 'index'])->name('users.colaborators');
    Route::get('/users-colaborators/new', [ColaboratorsController::class, 'newColaborator'])->name('users.colaborators.new');
    Route::post('/users-colaborators/create', [ColaboratorsController::class, 'createColaborator'])->name('users.colaborators.create');
    Route::get('/users-colaborators/edit/{id}', [ColaboratorsController::class, 'editColaborator'])->name('users.colaborators.edit');
    Route::post('/users-colaborators/update', [ColaboratorsController::class, 'updateColaborator'])->name('users.colaborators.update');
    Route::get('/users-colaborators/delete/{id}', [ColaboratorsController::class, 'deleteColaborator'])->name('users.colaborators.delete');
    Route::get('/users-colaborators/delete-confirm/{id}', [ColaboratorsController::class, 'deleteColaboratorConfirm'])->name('users.colaborators.delete-confirm');
    Route::get('/users-colaborators/restore/{id}', [ColaboratorsController::class, 'restoreColaborator'])->name('users.colaborators.restore');
    Route::get('/users-colaborators/details/{id}', [ColaboratorsController::class, 'showDetails'])->name('users.colaborators.details');
  });

  // dash rh
  Route::middleware([RH::class])->group(function () {
    Route::get('/users-rh/home', [RhController::class, 'home'])->name('users.rh.home');
  });

  // dash colaborator
  Route::middleware([Colaborator::class])->group(function () {
    Route::get('/users-colaborators/home', [ColaboratorsController::class, 'home'])->name('users.colaborators.home');
  });
});

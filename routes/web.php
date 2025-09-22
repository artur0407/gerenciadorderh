<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColaboratorsController;
use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RhManagementController;
use App\Http\Controllers\RhUserController;
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
  Route::get('/home', function () {
    if (auth()->user()->role === 'admin') {
      return redirect()->route('admin.home');
    } else if (auth()->user()->role === 'rh') {
      return redirect()->route('users.colaborators');
    } else {
      return redirect()->route('colaborator.home');
    }
  })->name('home');

  // user profile page
  Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
  Route::post('/user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.profile.update-password');
  Route::post('/user/profile/update-user-data', [ProfileController::class, 'updateUserData'])->name('user.profile.update-user-data');
  Route::post('/user/profile/update-user-address', [ProfileController::class, 'updateUserAddress'])->name('user.profile.update-user-address');

  Route::middleware([Admin::class])->group(function () {

    // dash admin
    Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');

    // department route
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/departments/new', [DepartmentController::class, 'newDepartment'])->name('departments.new');
    Route::post('/departments/create', [DepartmentController::class, 'createDepartment'])->name('departments.create');
    Route::get('/departments/edit/{id}', [DepartmentController::class, 'editDepartment'])->name('departments.edit');
    Route::post('/departments/update', [DepartmentController::class, 'updateDepartment'])->name('departments.update');
    Route::get('/departments/delete/{id}', [DepartmentController::class, 'deleteDepartment'])->name('departments.delete');
    Route::get('/departments/delete-confirm/{id}', [DepartmentController::class, 'deleteDepartmentConfirm'])->name('departments.delete-confirm');

    // colaborators rh
    Route::get('/users-rh', [RhUserController::class, 'index'])->name('users.rh');
    Route::get('/users-rh/new', [RhUserController::class, 'newColaborator'])->name('users.rh.new');
    Route::post('/users-rh/create', [RhUserController::class, 'createColaborator'])->name('users.rh.create');
    Route::get('/users-rh/edit/{id}', [RhUserController::class, 'editColaborator'])->name('users.rh.edit');
    Route::post('/users-rh/update', [RhUserController::class, 'updateColaborator'])->name('users.rh.update');
    Route::get('/users-rh/delete/{id}', [RhUserController::class, 'deleteColaborator'])->name('users.rh.delete');
    Route::get('/users-rh/delete-confirm/{id}', [RhUserController::class, 'deleteColaboratorConfirm'])->name('users.rh.delete-confirm');
    Route::get('/users-rh/restore/{id}', [RhUserController::class, 'restoreColaborator'])->name('users.rh.restore');
    Route::get('/users-rh/details/{id}', [RhUserController::class, 'showDetails'])->name('users.rh.details');
  
  });

  Route::middleware([AdminOrRH::class])->group(function () {
    
    // colaborators other departments
    Route::get('/users-colaborators', [RhManagementController::class, 'index'])->name('users.colaborators');
    Route::get('/users-colaborators/new', [RhManagementController::class, 'newColaborator'])->name('users.colaborators.new');
    Route::post('/users-colaborators/create', [RhManagementController::class, 'createColaborator'])->name('users.colaborators.create');
    Route::get('/users-colaborators/edit/{id}', [RhManagementController::class, 'editColaborator'])->name('users.colaborators.edit');
    Route::post('/users-colaborators/update', [RhManagementController::class, 'updateColaborator'])->name('users.colaborators.update');
    Route::get('/users-colaborators/delete/{id}', [RhManagementController::class, 'deleteColaborator'])->name('users.colaborators.delete');
    Route::get('/users-colaborators/delete-confirm/{id}', [RhManagementController::class, 'deleteColaboratorConfirm'])->name('users.colaborators.delete-confirm');
    Route::get('/users-colaborators/restore/{id}', [RhManagementController::class, 'restoreColaborator'])->name('users.colaborators.restore');
    Route::get('/users-colaborators/details/{id}', [RhManagementController::class, 'showDetails'])->name('users.colaborators.details');
    
    // admin colaborators
    // Route::get('/colaborators', [ColaboratorsController::class, 'index'])->name('colaborators');
    // Route::get('/colaborators/details/{id}', [ColaboratorsController::class, 'showDetails'])->name('colaborators.details');
    // Route::get('/colaborators/delete-colaborator/{id}', [ColaboratorsController::class, 'deleteColaborator'])->name('colaborators.delete');
    // Route::get('/colaborators/delete-colaborator-confirm/{id}', [ColaboratorsController::class, 'deleteColaboratorConfirm'])->name('colaborators.delete-confirm');
    // Route::get('/colaborators/restore/{id}', [ColaboratorsController::class, 'restoreColaborator'])->name('colaborators.restore');
  });

  // dash colaborator
  Route::middleware([Colaborator::class])->group(function () {
    Route::get('/colaborator/home', [ColaboratorsController::class, 'home'])->name('colaborator.home');
  });

  Route::middleware([RH::class])->group(function () {});
});

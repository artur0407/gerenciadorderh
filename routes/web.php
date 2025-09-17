<?php

use App\Http\Controllers\ColaboratorsController;
use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RhUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
  // email confirmation and password definition
  Route::get('/confirm-account/{token}', [ConfirmAccountController::class, 'confirmAccount'])->name('confirm-account');
  Route::post('/confirm-account', [ConfirmAccountController::class, 'confirmAccountSubmit'])->name('confirm-account-submit');
});

Route::middleware('auth')->group(function () {

  Route::redirect('/', 'home');
  Route::view('/home', 'home')->name('home');

  // user profile page
  Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
  Route::post('/user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.profile.update-password');
  Route::post('/user/profile/update-user-data', [ProfileController::class, 'updateUserData'])->name('user.profile.update-user-data');

  // department route
  Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
  Route::get('/departments/new-department', [DepartmentController::class, 'newDepartment'])->name('departments.new');
  Route::post('/departments/create-department', [DepartmentController::class, 'createDepartment'])->name('departments.create');
  Route::get('/departments/edit-department/{id}', [DepartmentController::class, 'editDepartment'])->name('departments.edit');
  Route::post('/departments/update-department', [DepartmentController::class, 'updateDepartment'])->name('departments.update');
  Route::get('/departments/delete-department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('departments.delete');
  Route::get('/departments/delete-department-confirm/{id}', [DepartmentController::class, 'deleteDepartmentConfirm'])->name('departments.delete-confirm');

  // rh colaborators routes
  Route::get('/rh-users', [RhUserController::class, 'index'])->name('colaborators.rh');
  Route::get('/rh-users/new-colaborator', [RhUserController::class, 'newColaborator'])->name('colaborators.rh-new');
  Route::post('/rh-users/create-colaborator', [RhUserController::class, 'createColaborator'])->name('colaborators.rh-create');
  Route::get('/rh-users/edit-colaborator/{id}', [RhUserController::class, 'editColaborator'])->name('colaborators.rh-edit');
  Route::post('/rh-users/update-colaborator', [RhUserController::class, 'updateColaborator'])->name('colaborators.rh-update');
  Route::get('/rh-users/delete-colaborator/{id}', [RhUserController::class, 'deleteColaborator'])->name('colaborators.rh-delete');
  Route::get('/rh-users/delete-colaborator-confirm/{id}', [RhUserController::class, 'deleteColaboratorConfirm'])->name('colaborators.rh-delete-confirm');

  // admin colaborators list
  Route::get('/colaborators', [ColaboratorsController::class, 'index'])->name('colaborators');
  Route::get('/colaborators/details/{id}', [ColaboratorsController::class, 'showDetails'])->name('colaborators.details');
  Route::get('/colaborators/delete-colaborator/{id}', [ColaboratorsController::class, 'deleteColaborator'])->name('colaborators.delete');
  Route::get('/colaborators/delete-colaborator-confirm/{id}', [ColaboratorsController::class, 'deleteColaboratorConfirm'])->name('colaborators.delete-confirm');

});

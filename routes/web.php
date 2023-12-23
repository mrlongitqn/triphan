<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
//Route::get('/', function () {
//    return view('welcome');
//});
//


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

Route::resource('subjects', App\Http\Controllers\SubjectController::class);






Route::resource('levels', App\Http\Controllers\LevelController::class);


Route::resource('courses', App\Http\Controllers\CourseController::class);




Route::resource('students', App\Http\Controllers\StudentController::class);
Route::get('student/search', [App\Http\Controllers\StudentController::class, 'search'])->name('student.search');

Route::prefix('courseStudents')->group(function () {
    Route::get('/{id?}', [App\Http\Controllers\CourseStudentController::class,'index'])->name('courseStudents.index');
    Route::post('/store', [App\Http\Controllers\CourseStudentController::class,'store'])->name('courseStudents.store');
});



Route::resource('fees', App\Http\Controllers\FeeController::class);


Route::resource('marks', App\Http\Controllers\MarkController::class);


Route::resource('sessionMarks', App\Http\Controllers\SessionMarkController::class);

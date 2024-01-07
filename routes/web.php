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
Route::prefix("")->middleware('auth')->group(function () {
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
        Route::get('/{id?}', [App\Http\Controllers\CourseStudentController::class, 'index'])->name('courseStudents.index');
        Route::get('/update-status/{id?}', [App\Http\Controllers\CourseStudentController::class, 'updateStatus'])->name('courseStudents.updateStatus');
        Route::post('/store', [App\Http\Controllers\CourseStudentController::class, 'store'])->name('courseStudents.store');
        Route::delete('/destroy', [App\Http\Controllers\CourseStudentController::class, 'destroy'])->name('courseStudents.destroy');
        Route::get('/list-student/{student?}', [App\Http\Controllers\CourseStudentController::class, 'listCourses'])->name('courseStudents.listCourse');
    });

    Route::prefix('fees')->group(function () {
        Route::get('/', [\App\Http\Controllers\FeeController::class, 'index'])->name('fees.index');
        Route::get('collect/{student_id?}/{course_id?}', [\App\Http\Controllers\FeeController::class, 'collect'])->name('fees.collect');
        Route::post('collect/{student_id?}/{course_id?}', [\App\Http\Controllers\FeeController::class, 'saveCollect'])->name('fees.saveCollect');
        Route::get('get-list-fee/{id?}', [\App\Http\Controllers\FeeController::class, 'getListFee'])->name('fees.getListFee');
        Route::get('bill/{id?}', [\App\Http\Controllers\FeeController::class, 'getBill'])->name('fees.getBill');
        Route::get('show/{id?}', [\App\Http\Controllers\FeeController::class, 'show'])->name('fees.show');
        Route::get('cancel', [\App\Http\Controllers\FeeController::class, 'cancel'])->name('fees.cancel');
    });

    Route::resource('marks', App\Http\Controllers\MarkController::class);

    Route::resource('sessionMarks', App\Http\Controllers\SessionMarkController::class);
});


Route::resource('courseSessions', App\Http\Controllers\CourseSessionController::class);


Route::resource('courseSessionStudents', App\Http\Controllers\CourseSessionStudentController::class);

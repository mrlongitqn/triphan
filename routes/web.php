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
    Route::get('course/search', [App\Http\Controllers\CourseController::class, 'search'])->name('courses.search');


    Route::resource('students', App\Http\Controllers\StudentController::class);
    Route::get('student/search', [App\Http\Controllers\StudentController::class, 'search'])->name('student.search');

    Route::prefix('courseStudents')->group(function () {
        Route::get('/{id?}', [App\Http\Controllers\CourseStudentController::class, 'index'])->name('courseStudents.index');
        Route::get('/update-status/{id?}', [App\Http\Controllers\CourseStudentController::class, 'updateStatus'])->name('courseStudents.updateStatus');
        Route::post('/store', [App\Http\Controllers\CourseStudentController::class, 'store'])->name('courseStudents.store');
        Route::delete('/destroy', [App\Http\Controllers\CourseStudentController::class, 'destroy'])->name('courseStudents.destroy');
        Route::get('/list-student/{student?}', [App\Http\Controllers\CourseStudentController::class, 'listCourses'])->name('courseStudents.listCourse');
        Route::post('/update-session', [App\Http\Controllers\CourseStudentController::class, 'updateSession'])->name('courseStudents.updateSession');
        Route::get('/print-list/{course?}/{status?}', [App\Http\Controllers\CourseStudentController::class, 'printList'])->name('courseStudents.printList');
        Route::get('/print-list-by-session/{course?}/{session?}', [App\Http\Controllers\CourseStudentController::class, 'printListBySession'])->name('courseStudents.printListBySession');
    });

    Route::prefix('fees')->group(function () {
        Route::get('/', [\App\Http\Controllers\FeeController::class, 'index'])->name('fees.index');
        Route::get('collect/{student_id?}/{course_id?}', [\App\Http\Controllers\FeeController::class, 'collect'])->name('fees.collect');
        Route::post('collect/{student_id?}/{course_id?}', [\App\Http\Controllers\FeeController::class, 'saveCollect'])->name('fees.saveCollect');
        Route::get('get-list-fee/{id?}', [\App\Http\Controllers\FeeController::class, 'getListFee'])->name('fees.getListFee');
        Route::get('bill/{id?}', [\App\Http\Controllers\FeeController::class, 'getBill'])->name('fees.getBill');
        Route::get('show/{id?}', [\App\Http\Controllers\FeeController::class, 'show'])->name('fees.show');
        Route::get('fee-by-student/{id?}', [\App\Http\Controllers\FeeController::class, 'feeByStudent'])->name('fees.feeByStudent');
        Route::get('cancel', [\App\Http\Controllers\FeeController::class, 'cancel'])->name('fees.cancel');
        Route::get('list-debt-by-course/{course?}', [\App\Http\Controllers\FeeController::class, 'listFeeDebtByCourse'])->name('fees.listFeeDebtByCourse');
        Route::get('jobUpdateFeeList', [\App\Http\Controllers\FeeController::class, 'jobUpdateFeeList'])->name('fees.jobUpdateFeeList');
    });

    Route::prefix('reports')->group(function () {
        Route::get('export-debt-list', [\App\Http\Controllers\ReportController::class, 'ExportDebtList'])->name('reports.ExportDebtList');
        Route::get('report-collect', [\App\Http\Controllers\ReportController::class, 'ReportCollect'])->name('reports.ReportCollect');
        Route::get('report-collect-refund', [\App\Http\Controllers\ReportController::class, 'ReportCollectRefund'])->name('reports.ReportCollectRefund');
        Route::get('report-collect-cancel', [\App\Http\Controllers\ReportController::class, 'ReportCollectCancel'])->name('reports.ReportCollectCancel');

    });
    Route::prefix('marks')->group(function () {
        Route::get('/{id?}', [\App\Http\Controllers\MarkController::class, 'index'])->name('marks.index');
        Route::post('/save', [\App\Http\Controllers\MarkController::class, 'store'])->name('marks.store');
        Route::post('/import', [\App\Http\Controllers\MarkController::class, 'import'])->name('marks.import');
        Route::get('/export/{id?}', [\App\Http\Controllers\MarkController::class, 'exportMarks'])->name('marks.exportMarks');
    });
    //Route::resource('marks', App\Http\Controllers\MarkController::class);

    Route::resource('sessionMarks', App\Http\Controllers\SessionMarkController::class);
    Route::resource('courseSessions', App\Http\Controllers\CourseSessionController::class);


    Route::resource('courseSessionStudents', App\Http\Controllers\CourseSessionStudentController::class);

    Route::get('import', [\App\Http\Controllers\ImportController::class, 'index']);


    Route::resource('refunds', App\Http\Controllers\RefundController::class);
    Route::get('refunds/{id?}', [\App\Http\Controllers\RefundController::class, 'show'])->name('refunds.show');

    Route::resource('markTypes', App\Http\Controllers\MarkTypeController::class);

    Route::get('mark-type-detail/{id}', [\App\Http\Controllers\MarkTypeDetailController::class, 'index'])->name('markTypeDetails.index');
    Route::get('mark-type-detail/create', [\App\Http\Controllers\MarkTypeDetailController::class, 'create'])->name('markTypeDetails.create');
});





//Route::resource('sessionMarkDetails', App\Http\Controllers\SessionMarkDetailController::class);





//Route::resource('markTypeDetails', App\Http\Controllers\MarkTypeDetailController::class);

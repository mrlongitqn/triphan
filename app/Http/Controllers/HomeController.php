<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSession;
use App\Models\CourseSessionStudent;
use App\Models\CourseStudent;
use App\Models\Fee;
use App\Models\FeeDetail;
use App\Models\Mark;
use App\Models\Refund;
use App\Models\SessionMark;
use App\Models\SessionMarkDetail;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    function reset(Request $request)
    {
        if ($request->pass == 'truncate') {
            CourseStudent::truncate();
            CourseSession::truncate();
            CourseSessionStudent::truncate();
            Student::truncate();
            Course::truncate();
            FeeDetail::truncate();
            Fee::truncate();
            Refund::truncate();
            Mark::truncate();
            SessionMark::truncate();
            SessionMarkDetail::truncate();
      }
        return redirect('home');
    }
}

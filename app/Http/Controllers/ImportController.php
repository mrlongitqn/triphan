<?php

namespace App\Http\Controllers;

use App\Imports\MultisheeStudentImport;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    function index()
    {

        Excel::import(new MultisheeStudentImport(), 'long.xlsx');
    }
}

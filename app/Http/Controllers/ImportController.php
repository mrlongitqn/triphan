<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    function index()
    {
        Excel::import(new StudentImport, 'long.xlsx');
    }
}

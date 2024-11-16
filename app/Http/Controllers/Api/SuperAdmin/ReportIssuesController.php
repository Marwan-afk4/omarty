<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ReportIssue;
use Illuminate\Http\Request;

class ReportIssuesController extends Controller
{

    public function getissues(){
        $reportissues=ReportIssue::all();
        $issues=[
            'data'=>$reportissues
        ];
        return response()->json($issues);
    }
}

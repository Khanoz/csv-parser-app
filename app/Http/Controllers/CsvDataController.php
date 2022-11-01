<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\csvtest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CsvDataController extends Controller
{
    public function uploadData(Request $request)
    {
        // Validate the request...
        $errorCounter = 0;
        $errorMsg = "";
        $arr = $request->inputTest;
        foreach ($arr as $value){
            $dataArr = explode('|', $value);

            try {
                
            $dataTable = new csvtest;
            $dataTable->catid = $dataArr[0];
            $dataTable->catname = $dataArr[1];
            $dataTable->cangid = $dataArr[2];
            $dataTable->cangname = $dataArr[3];
            $dataTable->autoComplete = $dataArr[4];
            $dataTable->save();
            } catch (QueryException $e) {
                $errorMsg = $errorMsg . "<br><br>" . $dataArr[0] . "  " . $dataArr[1] . "  |  " . $dataArr[2] . "  " . $dataArr[3];
                $errorCounter++;
            }
        }
        $msg = "Se agregaron de manera exitosa";
        
        return view('loaded', compact('msg', 'errorMsg', 'errorCounter'));
        
    }
}

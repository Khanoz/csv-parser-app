<?php
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\csvtest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class csvtestController extends Controller
{
    /*$test = new csvtest;
 
    $test->catname = 'London to Paris';
   
    $test->save();
   /*$test = csvtest::create([
       'catname' => 'London to Paris',
   ]);
   echo "hola";*/

   public function store(Request $request)
    {
        // Validate the request...

        $arr = $request->inputTest;
        foreach ($arr as $value){
            $dataArr = explode('|', $value);

            try {
                
            $dataTable = new csvtest;
            $dataTable->catid = $dataArr[0];
            $dataTable->catname = $dataArr[1];
            $dataTable->cangid = $dataArr[2];
            $dataTable->cangname = $dataArr[3];
            $dataTable->save();
            } catch (QueryException $e) {
                print $e->getMessage();
                print " ----  error <br>";
            }
        }
        //$this->show();
        
    }

   
   public function show()
       {
           return view('test');
       }
   
}
?>
<?php

namespace App\Http\Controllers;

use App\Dtr;
use App\Employee;
use App\User;
use Illuminate\Http\Request;
use JasperPHP\JasperPHP as JasperPHP;

class DtrController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth","2fa"]);
    }

    public function index()
    {

	    return view('admin.view_dtr');
    }

    public function getDtr(Request $request)
    {   
        // dd($request->all());
        // $task = User::find(768);
        // return \Response::json($task);
        if ( $request->limit == '' ) {
            $request->limit =  "0, 31";
        }
   
        $limit = explode(",", $request->limit);

        $inject = $limit[0];

        if ($inject==16) {
            $inject = 1;
        }else{
            $inject = 0;
        }

    	$dtr = Dtr::where(\DB::raw("YEAR(fdate)"), '=', $request->searchYear)
            ->where(\DB::raw("MONTH(fdate)"), '=', $request->searchMonth)
            ->where('fempidno','=',$request->searchId)
            ->offset($limit[0]-$inject)
            ->limit($limit[1]);



        // if(\Auth::user()->hasRole('personal')){
        //     $dtr->where('fempidno','=',\Auth::user()->FEMPIDNO);
        // }else{
        //     $dtr->where('fempidno',$request->searchId);
        // }

        $dtr = $dtr->get();

    	return $dtr;
    }

    public function getEmployee(Request $request)
    {
        if ($request->searchId == 0) {
            $request['searchId'] = auth()->user()->FEMPIDNO;
        }

    	$dtr = Employee::where('FEMPIDNO', $request->searchId)->get();

    	return $dtr;
    }

    public function printer(Request $request)
    {
        $jasper = new JasperPHP;
        $jasper->compile(public_path() . '/reports/report1.jrxml')->execute();

        $jasper->process(
            public_path() . '/reports/report1.jasper',
            public_path() . '/reports/report1',
            array("pdf"),
            array(
                "title" => $request->cats,
                "fyear" => $request->searchYear,
                "fmonth" => $request->searchMonth,
                "taman" => $request->limit,
            ),
            \Config::get('database.connections.hrmd') //DB connection array
        )->execute();

    }

    public function open_pdf()
    {
        return view('admin.open_pdf');
    }
}
// "E:\\xampp\\htdocs\\portal\\public\\reports\\images\\comval-2-final_01_02.png"
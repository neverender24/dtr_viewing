<?php

namespace App\Http\Controllers;

use App\Dtr;
use App\User;
use App\Employee;
use PHPJasper\PHPJasper;
use Illuminate\Http\Request;

class DtrController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth"]);
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
        // $jasper = new JasperPHP;
        // $jasper->compile(public_path() . '/reports/report1.jrxml')->execute();

        // $jasper->process(
        //     public_path() . '/reports/report1.jasper',
        //     public_path() . '/reports/report1',
        //     array("pdf"),
        //     array(
        //         "title" => $request->cats,
        //         "fyear" => $request->searchYear,
        //         "fmonth" => $request->searchMonth,
        //         "taman" => $request->limit,
        //     ),
        //     \Config::get('database.connections.hrmd') //DB connection array
        // )->execute();
        require base_path() . '/vendor/autoload.php'; 
                
        $inputj = public_path() . '/reports/report1.jrxml';
        $outputj = public_path() . '/reports';   

        $jasper = new PHPJasper;
        $jasper->compile($inputj, $outputj)->execute();

        $input = public_path() . '/reports/report1.jasper';   
        $output = public_path() . '/reports';
        $options = [
            'format' => ['pdf'],
            'locale' => 'en',
            'params' => [
                'title' => $request->cats,
                'fyear' => $request->searchYear,
                'fmonth' => $request->searchMonth,
                'taman' => $request->limit,
            ],
            'db_connection'=>[
                'driver' => 'mysql',
                'host' => '192.168.6.13',
                'port' => '3306',
                'database' => 'hrmddos',
                'username' => 'itcdd',
                'password' => '145',
            ] 
        ];

        $jasper = new PHPJasper; 
        $jasper->process(
                $input,
                $output,
                $options
        )->execute();
    }

    public function open_pdf()
    {
        return view('admin.open_pdf');
    }
}
// "E:\\xampp\\htdocs\\portal\\public\\reports\\images\\comval-2-final_01_02.png"
<?php

namespace app\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use app\Mahasiswa;
use app\Course;
use Illuminate\Support\Facades\Log;

class KRSController extends Controller
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
    public function index(Request $request)
    {
		$id = $request->cookie('id');
		$biodata = \app\mahasiswa::select('*')
             ->where('id', $id)
             ->orderBy('id', 'desc')
             ->take(1)
             ->get();
			 /*if($request->cookie('mkrs')!=null)
			 {
				 $idKRS = $request->cookie('mkrs');
				 $array=array();
				 foreach($idKRS as $idK)
				 {
					 $course = \app\course::select('*')
							->where('id', $idK)
							->get();
					array_push($array,$course);
				 }

			 }
			 else
			 {
				 return 0;
			 }*/
       $idKRS = \app\student_course::select('id_course')
              ->where('id_mahasiswa',$id)
              ->get();
       $array=array();
       foreach($idKRS as $idK)
       {
         $course = \app\course::select('*')
            ->where('id', $idK->id_course)
            ->get();
        array_push($array,$course);
       }

		return view('krs',['biodata'=>$biodata,'course'=>$array]);
    }
    public function coloumn(Request $request)
    {
      $email = $request->input('email');


      $table = \app\mahasiswa::select('*')
             ->where('email', $email)
             ->orderBy('id', 'desc')
             ->take(1)
             ->get();
        return $table ;
    }
}

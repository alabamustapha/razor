<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Home;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('aff_status_approved');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isadmin = DB::table('users')->select('isadmin')->where('id', Auth::user()->id)->pluck('isadmin');

        if($isadmin->first() == true){
            $devis = DB::table('devis')->orderBy('id', 'desc' )->get();
            $old_devis = DB::table('old_devis')->orderBy('id', 'desc' )->get();
        }else if($isadmin->first() == false) {
            $devis = DB::table('devis')->where('affiliate_users', Auth::user()->id)->orderBy('id', 'desc' )->get();
            $old_devis = DB::table('old_devis')->where('affiliate_users', Auth::user()->id)->orderBy('id', 'desc' )->get();

        }



        $count_devis = DB::table('devis')->where('affiliate_users', Auth::user()->id)->count();

            //dd($devis);
        //dd($test1);

        return view('home',compact('devis', 'count_devis','old_devis','contrat','old_contrat'));
    }
}

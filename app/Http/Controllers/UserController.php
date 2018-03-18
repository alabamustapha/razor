<?php

namespace App\Http\Controllers;

use App\Mail\ModificationUserActive;
use App\Mail\ModificationUserDesactive;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use App\Mail\ModificationUser;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('isadmin');
        $this->middleware('auth');
    }
    public function index()
    {
        $user_aff = User::all();
        //$user_affi = $user_aff->aff_link;
        $user = DB::table('users')->where('aff_link','=','-1')->orderBy('id', 'desc' )->get();

        //dd($user_affi, $user);
        return view('user.index', compact('user', 'user_aff'));
    }
    
    public function test_index(){
        $user_aff = DB::table('users')->get();

        $user = DB::table('users')->where('aff_link','=','-1')->get();


        //dd($user_aff, $user);
        return view('user.test_index', compact('user', 'user_aff'));
    }

    public function convert_affilie_to_courtier($id){

        $user = User::findOrFail($id);
        $affilie = DB::table('users')->get();

        return view('user.convert_to_courtier', compact('user','affilie'));

    }

    public function convert_courtier_to_affilie($id){

        $user = User::findOrFail($id);
        $affilie = DB::table('users')->get();

        return view('user.convert_to_affilie', compact('user','affilie'));

    }

    public function courtier_affilie($id){

        $user = User::findOrFail($id);
        $affilie = DB::table('users')->where('aff_link','=',$id)->get();

        return view('user.courtier_affilie', compact('user','affilie'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'indice' => 'required',
            'valeur' => 'required'
        ],
            [
                'indice.required' => 'Indice de base obligatoire',
                'valeur.required' => 'Valeur de l\'indice de base obligatoire',

            ]);

        $user = new User;
        $input = $request->input();


        $user->fill($input)->save();
        return redirect()
            ->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Afficher un article
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$user_convert = DB::table('users')->where('id','=',$id)->get();

        $user = User::findOrFail($id);
        //Afficher le formulaire d'édition d'un article
        return view('user.edit', compact('user'));
    }

    public function update_afflink_post($id){

        $change_aff_link = request()->input('convert_affilie_to_courtier');

        DB::table('users')->where('id', $id)->update([
            'aff_link' => $change_aff_link,
        ]);

        return redirect()->route('convert_aff', ['id' => $id]);
    }

    public function update_afflink_post2($id){

        $change_aff_link = request()->input('convert_courtier_to_affilie');

        DB::table('users')->where('id', $id)->update([
            'aff_link' => $change_aff_link,
        ]);

        return redirect()->route('user.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->input();

        if(request()->input('aff_status_approved') == 0){
            \Mail::to($user)->send(New ModificationUserDesactive($user));
        }elseif(request()->input('aff_status_approved') == 1){
            \Mail::to($user)->send(New ModificationUserActive($user));

        }

        $user->fill($input)->save();


        return redirect()
            ->route('user.index');

        /*->with('success', 'event mis à jour');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()
            ->route('user.index');
        /* ->with('success', 'Suppression de l\'indice');*/
    }
}

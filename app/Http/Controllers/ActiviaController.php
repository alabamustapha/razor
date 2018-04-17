<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActiviaController extends Controller
{
    public function index()
    {
        
        $professions = activia_professions();
        $options =  activia_options();

        return view('activia.create', compact(['professions', 'options']));
    }


    public function result(Request $request){


        $classe_de_rique_pour_contole = classe_de_rique_pour_contole($request->profession);

        
        // return $classe_de_rique_pour_contole['bg'];
        //total = ((D156 - 4.7 - I152) * F157 * F158 * F159 + I152) + 21.6 + 4.7
           
        //D156 = I155+I152+I141+I116+I91+I88+I82+I78+I69+I60+I42+I36+I25+4.7

                //I155 = (I116+I91+I88+I82+I78+I69+I60+I42+I36+I25)*0.14 ---> ( 0.62 + 47.0 + I60 + G40 + I36 + I25)

                    //I116 = +G109+G111+G112+G113+G114+G116  -----> 0
                        
                        $I116 = i116();
                                                    
                    //I91 = G92+G93+G95+G96+G97+G98+G100+G101+G102+G104+G105+G106 ---> 0
                        $I91 = i91();
                        
                    //I88 =  G85+G86+G87+G88 ----> 0.62 + 0 + 0 + 0

                        $I88 = i88();
                        
                    //I82 = 0
                        $I82 = i82();
                        
                    //I78 = activia_option_12 = 47.0
                        $I78 = i78($classe_de_rique_pour_contole['bg']);
                        
                    //I69 = 0
                        $I69 = i69();
                        
                    //I60: if activia_option_11 I60 = 279.00 else 0
                                         
                        $I60 = i60($classe_de_rique_pour_contole['vol'], $request->location, $request->activia_option_11, $request->surface_of_property);

                        
                    //I42: G40 + G41 + G42 = G40 + 0 + 0
                        
                        //G40: 0.15 * (I25 + I36)

                            
                            $I25 = i25($request->profession, $request->activia_option_1, $request->surface_of_property);
                            
                            // I36: G27 + G28 + G29 + G30 + G31 + G32 + G33 + G34 + G35 + G36

                                $I36 = i36($I25, $request);

                    $I42 = i42($I25, $I36);

            //I152 = 0
            $I152 = i152();
        
            //I141 (G120+G121+G122+G124+G125+G126+G127+G128+G130+G131+G132+G133+G134+G136+G137+G138+G139+G140+G141) = if activia_option_15 36 else 0
            $I141 = i141($request->activia_option_15, $request->surface_of_property);

            
            //I116 = 0
            $I116 = i116();
            
        
        
        $I155 = ($I116 + $I91 + $I88 + $I82 + $I78 + $I69 + $I60 + $I42 + $I36 + $I25) * 0.14;
        
        $D156 = $I155 + $I152 + $I141 + $I116 + $I91 + $I88 + $I82 + $I78 + $I69 + $I60 + $I42 + $I36 + $I25 + 4.7;

        $F157 = f157($D156);  //F157 = 1
        $F158 = f158($D156);  //F158 = 1
        $F159 = f159();  //F159 = 1

        
        $total = (($D156 - 4.7 - $I152) * $F157 * $F158 * $F159 + $I152) + 21.6 + 4.7;

        $options = [
            'activia_option_1' => $request->activia_option_1,
            'activia_option_2' => $request->activia_option_2,
            'activia_option_3' => $request->activia_option_3,
            'activia_option_4' => $request->activia_option_4,
            'activia_option_5' => $request->activia_option_5,
            'activia_option_6' => $request->activia_option_6,
            'activia_option_7' => $request->activia_option_7,
            'activia_option_8' => $request->activia_option_8,
            'activia_option_9' => $request->activia_option_9,
            'activia_option_10' => $request->activia_option_10,
            'activia_option_11' => $request->activia_option_11,
            'activia_option_12' => $request->activia_option_12,
            'activia_option_13' => $request->activia_option_13,
            'activia_option_14' => $request->activia_option_14,
            'activia_option_15' => $request->activia_option_15,
        ];

        $activia_result = [
            'surface_of_property' => $request->surface_of_property,
            'profession' => $request->profession,
            'location' => $request->location,
            'options' => $options,
            'total' => $total,
        ];

        \Session::put('activia_result', $activia_result);

        $response = "<div><u>Tarifs:</u><center><table class='tarificateur'><tr><td>PNO : &nbsp </td><td> " . $total . " </td> <td> &nbsp euros </td> </tr></table> </center><br><u>Clauses: </u><center><table class='tarificateur'><tr><td>PNO :</td><td></td></tr></table> </center></div><br><div class='form_field'><a href='" . route('home') . "'> Annuler</a>-<a class='btn-orange-a' href='" . route('activia_step2') . "'> Aller &agrave;l'&eacute;tape 2</a></div>";

        // return $I36;
        return $response;
    }

    public function step2(){
        return view('activia.step2');
    }

    public function step3(Request $request){

        // $coef_zone = Session::get('result.in_coef_zone');


        $costumer = $request->except('_token');

        \Session::put("activia_costumer", $costumer);


        return view('activia.step3');
    }

    public function step4(){
        $costumer_sigle = \Session::get('costumer.in_customer_sigle');
        $costumer_nom = \Session::get('costumer.in_customer_nom');
        $result_rc = \Session::get('result.rc');
        //$all_clauses = Session::get('result.clauses');
        //$test = Session::all();
        $product_n = session('result');
        $proposant_n = session('costumer');
        dd(\Session::all());
        $product = serialize($product_n);
        $proposant = serialize($proposant_n);
        $date = date("Y-m-d");

        DB::table('devis')->insert([
            [
                'id_contrat' => -1,
                'affiliate_users' => Auth::user()->id,
                'type_product' => 4,
                'data_product' => $product,
                'data_proposant' => $proposant,
                'customer_nom' => $costumer_sigle . ' ' . $costumer_nom,
                'affiliate_lastname' => Auth::user()->aff_lname,
                'affiliate_firstname' => Auth::user()->aff_fname,
                'affiliate_company' => Auth::user()->aff_company,
                'affiliate_address' => Auth::user()->aff_adresse,
                'affiliate_city' => Auth::user()->aff_city,
                'affiliate_zip' => Auth::user()->aff_zip,
                'affiliate_email' => Auth::user()->email,
                'affiliate_orias' => Auth::user()->aff_orias,
                'affiliate_tel' => Auth::user()->aff_tel,
                'affiliate_ref' => Auth::user()->aff_ref,
                'date_creation' => $date,
                'status' => '100-' . time() . ';10-' . time() . ';',
                'formule' => '',
                'periodicity' => 1,
                'tarificateur_amount' => 0.00,
                'customer_amount' => 0.00,
                'partner_amount' => 0.00,
                'affiliate_amount' => 0.00,
                'customer_amount_rc' => 0.00,
                'date_contract' => 0,
                'clauses' => '',



            ],

        ]);

        $ref_contrat = DB::table('devis')->where('affiliate_users', Auth::user()->id)->pluck('id', 'id')->last();
        //dd($costumer_sigle, $costumer_nom, $product, $proposant,  $result_rc, $ref_contrat);
        $contrat = $ref_contrat;
        return view('tarificateurgroupama.tarifgroupama_step4', compact('contrat'));
    }
}

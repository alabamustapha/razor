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
        
        //total = ((D156 - 4.7 - I152) * F157 * F158 * F159 + I152) + 21.6 + 4.7
           
        //D156 = I155+I152+I141+I116+I91+I88+I82+I78+I69+I60+I42+I36+I25+4.7

                //I155 = (I116+I91+I88+I82+I78+I69+I60+I42+I36+I25)*0.14 ---> ( 0.62 + 47.0 + I60 + G40 + I36 + I25)

                    //I116 = +G109+G111+G112+G113+G114+G116  -----> 0
                        
                        $G109 = 0; //G109 if yes return tardde_test_1 else 0, default 0
                        $G111 = 0; //G111 if yes return tardde_test_2 else 0, defualt 0
                        $G112 = 0; //G112 if yes return tardde_test_2 else 0, default 0
                        $G113 = 0; //G113 0
                        $G114 = 0; //G114 0
                        $G116 = 0; // G116 = if E116 is yes, (G109+G111+G112+G113+G114) * 0.2 else 0, always 0
                        
                        $I116 = $G109 + $G111 + $G112 + $G113 + $G114 + $G116;
                                    
                    //I91 = G92+G93+G95+G96+G97+G98+G100+G101+G102+G104+G105+G106 ---> 0
                        $I91 = 0;  
                    //I88 =  G85+G86+G87+G88 ----> 0.62 + 0 + 0 + 0
                        $G86 = 0; //G86
                        $G87 = 0; //G87
                        $G88 = 0; //G88
                        $G85 = 0.62; //G85  = 0.62 //activia_option_13
                        $I88 = $G85 + $G86 + $G87 + $G88;
        
                    //I82 = 0
                        $I82 = 0;
                    //I78 = activia_option_12 = 47.0
                        $I78 = 47.0;
                    //I69 = 0
                        $I69 = 0;
                    //I60: if activia_option_11 I60 = 279.00 else 0
                        if($request->activia_option_11 == 1){
                            $I60 = 279.00;    
                        }else{
                            $I60 = 0;   
                        }
        
                    //I42: G40 + G41 + G42 = G40 + 0 + 0
                        
                        //G40: 0.15 * (I25 + I36)

                            // I25: if activia_option_1 396.00 else 0

                                if ($request->activia_option_1 == 1) {
                                    $I25 = 396.00;
                                } else {
                                    $I25 = 0;
                                }

                            // I36: G27 + G28 + G29 + G30 + G31 + G32 + G33 + G34 + G35 + G36

                                //G27: if activia_option_2 I25 * 0.30 else 0
                                $G27 = $request->activia_option_1 == 1 ? 0.30 * $I25 : 0;
                                //G28: if activia_option_3 I25 * 1 else 0
                                $G28 = $request->activia_option_3 == 1 ? 1 * $I25 : 0;    
                                //G29: if activia_option_4 I25 * 0.30 else 0
                                $G29 = $request->activia_option_4 == 1 ? 0.30 * $I25 : 0;    
                                //G30: if activia_option_5 I25 * 0.50 else 0
                                $G30 = $request->activia_option_5 == 1 ? 0.5 * $I25 : 0;    
                                //G31: if activia_option_6 I25 * 0.25 else 0
                                $G31 = $request->activia_option_5 == 1 ? 0.25 * $I25 : 0;    
                                //G32: if activia_option_7 I25 * 0.20 else 0
                                $G32 = $request->activia_option_7 == 1 ? 0.20 * $I25 : 0;       
                                //G33: if activia_option_8 I25 * 0.25 else 0
                                $G33 = $request->activia_option_8 == 1 ? 0.25 * $I25 : 0;       
                                //G34: 0.4 * I25
                                $G34 =  0.4 * $I25 ;           
                                //G35: if activia_option_9 I25 * 0.5 else 0
                                $G35 = $request->activia_option_9 == 1 ? 0.5 * $I25 : 0;       
                                //G36: if activia_option_10 I25 * 0.3 else 0
                                $G36 = $request->activia_option_10 == 1 ? 0.3 * $I25 : 0;

                                $I36 = $G27 + $G28 + $G29 + $G30 + $G31 + $G32 + $G33 + $G34 + $G35 + $G36;

                        $G40 = 0.15 * ($I25 + $I36);      
                    $I42 = $G40 + 0 + 0;    
            //I152 = 0
            $I152 = 0;
            //I141 (G120+G121+G122+G124+G125+G126+G127+G128+G130+G131+G132+G133+G134+G136+G137+G138+G139+G140+G141) = if activia_option_15 36 else 0
            $I141 = $request->activia_option_15 == 1 ? 36.0 : 0;                           
            //I116 = 0
            $I116 = 0;
            //I91 = 0
            $I191 = 0;                    
            

        $F157 = 1;  //F157 = 1
        $F158 = 1;  //F158 = 1
        $F159 = 1;  //F159 = 1
        
        $I155 = ($I116 + $I91 + $I88 + $I82 + $I78 + $I69 + $I60 + $I42 + $I36 + $I25) * 0.14;

        $D156 = $I155 + $I152 + $I141 + $I116 + $I91 + $I88 + $I82 + $I78 + $I69 + $I60 + $I42 + $I36 + $I25 + 4.7;

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

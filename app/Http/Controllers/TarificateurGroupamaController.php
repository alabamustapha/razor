<?php

namespace App\Http\Controllers;

use App\Models\TarificateurGroupama;
use Illuminate\Http\Request;
use Session;
use Auth;
use DB;

class TarificateurGroupamaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('aff_status_approved');
        // $this->middleware('isadmin');
        $this->middleware('auth');
    }

    public function index()
    {

        $value_nbr_sinistres = request()->input('in_nbr_sinistre');

        $value_in_nbr_surface = 0;


        $coef_zone = array( "designation" => array (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95 ),
            "coefficient" => array(1,1,1,1,1,1.1,1,1,1,1,1.1,1,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1.2,1,1.2,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1,1,1,1,1,1,1.2,1,1,1.2,1,1,1,1,1,1.5,1,1.5,1.5,1,1,1,1,1.1,1,1,1,1,1,1,1,1.5,1.5,1.5,1.5,1.5),
            "clause" => array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "")
        );

        $coef_annee_construction = array(
            "designation" => array ("Antérieure à 1980",
                "Postérieure à 1980"),
            "coefficient" => array( 1.25, 1),
            "clause" => array("", "")
        );
        $liste_sini = array('designation' => array('Incendie','Dégât des eaux','Brie de glace','Vol','Responsabilité civile'));

        return view('tarificateurgroupama.create', compact('coef_zone','coef_annee_construction','liste_sini','value_in_nbr_surface','value_nbr_sinistres'));
    }

    public function result_tarif_groupama()
    {
        $warnings = array();

        $prime_mini = 800;

        /////// PARIS ////////

        /////// Franchise 0€ Paris////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 1.15;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 1.05;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.95;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 1.05;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.95;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.90;
            }
        }
        /////// Franchise 0.5€ Paris////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 1.07;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 1.00;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.92;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 1.00;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.92;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.85;
            }
        }

        /////// Franchise 1€ Paris////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 1.00;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.95;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.90;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.95;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.90;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.80;
            }
        }
        /////// Franchise 2€ Paris////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.90;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.85;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.80;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.85;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.80;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.75;
            }
        }


        /////// - de 200 000 habitants ////////


        /////// Franchise 0€ ////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.90;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.85;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.80;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.78;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.75;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.68;
            }
        }
        /////// Franchise 0.5€ ////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.81;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.78;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.74;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.70;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.67;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.63;
            }
        }

        /////// Franchise 1€ ////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.72;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.70;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.68;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.62;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.60;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.58;
            }
        }
        /////// Franchise 2€ ////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.68;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.65;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.60;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.58;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.56;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.54;
            }
        }

        /////// + de 200 000 habitants ////////


        /////// Franchise 0€ ////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 1.00;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.90;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.85;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.85;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.80;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.75;
            }
        }
        /////// Franchise 0.5€ ////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.90;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.85;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.80;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.75;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.71;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.67;
            }
        }

        /////// Franchise 1€ ////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.80;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.80;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.75;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.68;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.62;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.60;
            }
        }
        /////// Franchise 2€ ////////

        if(request()->input('in_nombre_surface') == 0){

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.75;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.70;
            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.68;
            }
        }else{

            if(request()->input('in_nombre_surface') <= 2000)
            {
                $coef_franchise_indice = 0.65;
            }elseif(request()->input('in_nombre_surface') <= 5000)
            {
                $coef_franchise_indice = 0.60;

            }elseif(request()->input('in_nombre_surface') > 5000){
                $coef_franchise_indice = 0.58;
            }
        }

        ////////////// Protection juridique //////////////////////

        $nbr_surface_dev = request()->input('in_nombre_surface');

        if(request()->input('in_nombre_surface') <= 2000){
            $prime_pj_annuelle = 0.16;
            $calcul_total_coti_pj = $prime_pj_annuelle * $nbr_surface_dev;

        }elseif (request()->input('in_nombre_surface') >= 2001){
            $prime_pj_annuelle = 0.15;
            $calcul_total_coti_pj = $prime_pj_annuelle * $nbr_surface_dev;

        }elseif(request()->input('in_nombre_surface') >= 5001){
            $prime_pj_annuelle = 0.14;
            $calcul_total_coti_pj = $prime_pj_annuelle * $nbr_surface_dev;

        }elseif(request()->input('in_nombre_surface') >= 10001){
            $prime_pj_annuelle = 0.13;
            $calcul_total_coti_pj = $prime_pj_annuelle * $nbr_surface_dev;

        }elseif (request()->input('in_nombre_surface') >= 50001){
            $prime_pj_annuelle = 0.10;
            $calcul_total_coti_pj = $prime_pj_annuelle * $nbr_surface_dev;
        }

        $total_coti_pj = $calcul_total_coti_pj;

    }

    public function resultat_tarif_groupama(){

        // Warning
        $warnings = array();

        $Nbr_sinistre = request()->input('in_nombre_sinistres');
        $cout_total_sinistre = 0;

        if($Nbr_sinistre > 9){
            $warnings[] = '"Nombre de sinistres trop élevé"';
        }
        if($Nbr_sinistre == 1){
            $value_sini_1 = request()->input('in_sinitre1');

            $cout_total_sinistre = $value_sini_1;

        }else if($Nbr_sinistre == 2){
            $value_sini_1 = request()->input('in_sinitre1');
            $value_sini_2 = request()->input('in_sinitre2');

            $cout_total_sinistre = $value_sini_1 + $value_sini_2;

        }else if($Nbr_sinistre == 3){
            $value_sini_1 = request()->input('in_sinitre1');
            $value_sini_2 = request()->input('in_sinitre2');
            $value_sini_3 = request()->input('in_sinitre3');

            $cout_total_sinistre = $value_sini_1 + $value_sini_2 + $value_sini_3;

        }else if($Nbr_sinistre == 4){
            $value_sini_1 = request()->input('in_sinitre1');
            $value_sini_2 = request()->input('in_sinitre2');
            $value_sini_3 = request()->input('in_sinitre3');
            $value_sini_4 = request()->input('in_sinitre4');

            $cout_total_sinistre = $value_sini_1 + $value_sini_2 + $value_sini_3 + $value_sini_4;

        }else if($Nbr_sinistre == 5){
            $value_sini_1 = request()->input('in_sinitre1');
            $value_sini_2 = request()->input('in_sinitre2');
            $value_sini_3 = request()->input('in_sinitre3');
            $value_sini_4 = request()->input('in_sinitre4');
            $value_sini_5 = request()->input('in_sinitre5');

            $cout_total_sinistre = $value_sini_1 + $value_sini_2 + $value_sini_3 + $value_sini_4 + $value_sini_5;

        }

        $result = $cout_total_sinistre;




        return view('tarificateurgroupama.result_tarificateur_groupama', compact('result', 'warnings'));


    }

    public function nbr_sinistre(){

        $value_nbr_sinistres = 0;



        return view('tarificateurgroupama.nbr_sinistre', compact('value_nbr_sinistres'));
    }

    public function nbr_sinistre_post(){

        $value_in_nbr_sinistre = request()->input('in_nbr_sinistre');
        $value_in_nbr_surface = 0;
        $liste_sini = array('designation' => array('Incendie','Dégât des eaux','Brie de glace','Vol','Responsabilité civile'),
                            'coefficient' => array('')
        );

        $in_zone = array(
            "designation" => array ("- de 200 000 Habitants",
                "+ de 200 000 Habitants",
                "Paris et sa région",
            ),
            "coefficient" => array(1,2,3),
            "clause" => array()
        );

        $coef_minorations_possibles = array(
            "designation" => array ("Suppression GARANTIE VOL",
                "Suppression GARANTIE DDE",
                "Suppression GARANTIE Bris de glace"),
            "coefficient" => array( 0.9, 0.9, 0.95),
            "clause" => array("R04", "R03", "R02")
        );

        $coef_annee_construction = array(
            "designation" => array ("Antérieure à 1980",
                "Postérieure à 1980"),
            "coefficient" => array(1,2),
            "clause" => array()

        );

        Session::put("value_in_nbr_sinistre",$value_in_nbr_sinistre);


        return view('tarificateurgroupama.create', compact('value_in_nbr_surface','value_in_nbr_sinistre','liste_sini','in_zone', 'coef_annee_construction','coef_specificites_techniques', 'coef_minorations_possibles'));


    }

    public function test_result(){

        // Clauses

        $clauses = ",";
        // Warning
        $warnings = array();
        $Nbr_sisnitre = Session('value_in_nbr_sinistre');
        //$liste_sini = array('designation' => array('Incendie','Dégât des eaux','Brie de glace','Vol','Responsabilité civile'));

        $zone = array(
            "designation" => array ("- de 200 000 Habitants",
                "+ de 200 000 Habitants",
                "Paris et sa région",
            ),
            "coefficient" => array(1,2,3),
            "clause" => array()
        );
        $coef_annee_construction = array(
            "designation" => array ("Antérieure à 1980",
                "Postérieure à 1980"),
            "coefficient" => array(1,2),
            "clause" => array()

        );

        $coef_minorations_possibles = array(
            "designation" => array ("Suppression GARANTIE VOL",
                "Suppression GARANTIE DDE",
                "Suppression GARANTIE Bris de glace"),
            "coefficient" => array( 0.9, 0.9, 0.95),
            "clause" => array("R04", "R03", "R02")
        );
        ////////// Prime mini ////////

        $prime_mini = 800;



        ////////// Calcul Nombre sinistre //////////

        $Nbr_surface = request()->input('in_nombre_surface');

        if(request()->input('sinistre_1') == 0){
            $value1 = 0;
        }else{
            $value1 = request()->input('sinistre_1');
        }

        if(request()->input('sinistre_2') == 0){
            $value2 = 0;
        }else{
            $value2 = request()->input('sinistre_2');
        }

        if(request()->input('sinistre_3') == 0){
            $value3 = 0;
        }else{
            $value3 = request()->input('sinistre_3');
        }

        if(request()->input('sinistre_4') == 0){
            $value4 = 0;
        }else{
            $value4 = request()->input('sinistre_4');
        }

        if(request()->input('sinistre_5') == 0){
            $value5 = 0;
        }else{
            $value5 = request()->input('sinistre_5');
        }

        if(request()->input('sinistre_6') == 0){
            $value6 = 0;
        }else{
            $value6 = request()->input('sinistre_6');
        }

        if(request()->input('sinistre_7') == 0){
            $value7 = 0;
        }else{
            $value7 = request()->input('sinistre_7');
        }

        if(request()->input('sinistre_8') == 0){
            $value8 = 0;
        }else{
            $value8 = request()->input('sinistre_8');
        }

        if(request()->input('sinistre_9') == 0){
            $value9= 0;
        }else{
            $value9 = request()->input('sinistre_9');
        }

        $compa_sinistre = max($value1, $value2, $value3, $value4, $value5, $value6, $value7, $value8, $value9);
        //$cout_total_sinistres = $value1 + $value2 + $value3 + $value4 + $value5 + $value6 + $value7 + $value8 + $value9;

        ///////////// Calcul franchise /////////////
        ///
        ///

        if($compa_sinistre >= 3001){
            $coef_franchise_indice = 0.00;
            $warnings[] = '"Sinistre supérieurs à 3000€"';
        }else{

        if($zone['coefficient'][$_POST['in_zone']] == 1) {
            if ($compa_sinistre <= 430) {
                if ($coef_annee_construction['coefficient'][$_POST['coef_annee_construction']] == 1) {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 0.90;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 0.85;
                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.80;
                    }
                } else {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 0.78;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 0.75;

                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.68;
                    }
                }
            } elseif ($compa_sinistre <= 960) {

                if ($coef_annee_construction['coefficient'][$_POST['coef_annee_construction']] == 1) {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 0.81;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 0.78;
                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.74;
                    }
                } else {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 0.70;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 0.67;

                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.63;
                    }
                }

            } elseif ($compa_sinistre <= 3000) {
                if ($coef_annee_construction['coefficient'][$_POST['coef_annee_construction']] == 1) {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 0.72;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 0.70;
                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.68;
                    }
                } else {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 0.62;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 0.60;

                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.58;
                    }
                }
            }elseif($compa_sinistre >= 3001){
                $warnings[] = '"Sinistre supérieurs à 3000€"';
            }
        }elseif($zone['coefficient'][$_POST['in_zone']] == 2) {

            if ($compa_sinistre <= 430) {
                if ($coef_annee_construction['coefficient'][$_POST['coef_annee_construction']] == 1) {

                    if($Nbr_surface <= 2000)
                    {
                        $coef_franchise_indice = 1.00;
                    }elseif($Nbr_surface <= 5000)
                    {
                        $coef_franchise_indice = 0.90;
                    }elseif($Nbr_surface > 5000){
                        $coef_franchise_indice = 0.85;
                    }
                }else{

                    if($Nbr_surface <= 2000)
                    {
                        $coef_franchise_indice = 0.85;
                    }elseif($Nbr_surface <= 5000)
                    {
                        $coef_franchise_indice = 0.80;

                    }elseif($Nbr_surface > 5000){
                        $coef_franchise_indice = 0.75;
                    }
                }
            } elseif ($compa_sinistre <= 960) {

                if ($coef_annee_construction['coefficient'][$_POST['coef_annee_construction']] == 1) {

                    if($Nbr_surface <= 2000)
                    {
                        $coef_franchise_indice = 0.90;
                    }elseif($Nbr_surface <= 5000)
                    {
                        $coef_franchise_indice = 0.85;
                    }elseif($Nbr_surface > 5000){
                        $coef_franchise_indice = 0.80;
                    }
                }else{

                    if($Nbr_surface <= 2000)
                    {
                        $coef_franchise_indice = 0.75;
                    }elseif($Nbr_surface <= 5000)
                    {
                        $coef_franchise_indice = 0.71;

                    }elseif($Nbr_surface > 5000){
                        $coef_franchise_indice = 0.67;
                    }
                }

            } elseif ($compa_sinistre <= 3000) {
                if ($coef_annee_construction['coefficient'][$_POST['coef_annee_construction']] == 1) {

                    if($Nbr_surface <= 2000)
                    {
                        $coef_franchise_indice = 0.80;
                    }elseif($Nbr_surface <= 5000)
                    {
                        $coef_franchise_indice = 0.80;
                    }elseif($Nbr_surface > 5000){
                        $coef_franchise_indice = 0.75;
                    }
                }else{

                    if($Nbr_surface <= 2000)
                    {
                        $coef_franchise_indice = 0.68;
                    }elseif($Nbr_surface <= 5000)
                    {
                        $coef_franchise_indice = 0.62;

                    }elseif($Nbr_surface > 5000){
                        $coef_franchise_indice = 0.60;
                    }
                }
            } elseif ($compa_sinistre >= 3001) {
                $warnings[] = '"Sinistre supérieurs à 3000€"';
            }
        }elseif($zone['coefficient'][$_POST['in_zone']] == 3) {

            if ($compa_sinistre <= 430) {
                if ($coef_annee_construction['coefficient'][$_POST['coef_annee_construction']] == 1) {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 1.15;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 1.05;
                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.95;
                    }
                } else {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 1.05;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 0.95;

                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.90;
                    }
                }
            } elseif ($compa_sinistre <= 960) {

                if ($coef_annee_construction['coefficient'][$_POST['coef_annee_construction']] == 1) {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 1.07;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 1.00;
                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.92;
                    }
                } else {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 1.00;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 0.92;

                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.85;
                    }
                }

            } elseif ($compa_sinistre <= 3000) {
                if ($coef_annee_construction['coefficient'][$_POST['coef_annee_construction']] == 1) {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 1.00;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 0.95;
                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.90;
                    }
                } else {

                    if ($Nbr_surface <= 2000) {
                        $coef_franchise_indice = 0.95;
                    } elseif ($Nbr_surface <= 5000) {
                        $coef_franchise_indice = 0.90;

                    } elseif ($Nbr_surface > 5000) {
                        $coef_franchise_indice = 0.80;
                    }
                }
            } elseif ($compa_sinistre >= 3001) {
                $warnings[] = '"Sinistre supérieurs à 3000€"';
            }
        }
    }
        //////// Protection juridique ///////////
        $calcul_total_coti_pj = 0;


            

            if($Nbr_surface <= 2000){
                $prime_pj_annuelle = 0.16;
                $calcul_total_coti_pj = $prime_pj_annuelle * $Nbr_surface;

            }elseif ($Nbr_surface <= 5000){
                $prime_pj_annuelle = 0.15;
                $calcul_total_coti_pj = $prime_pj_annuelle * $Nbr_surface;

            }elseif($Nbr_surface <= 10000){
                $prime_pj_annuelle = 0.14;
                $calcul_total_coti_pj = $prime_pj_annuelle * $Nbr_surface;

            }elseif($Nbr_surface <= 50000){
                $prime_pj_annuelle = 0.13;
                $calcul_total_coti_pj = $prime_pj_annuelle * $Nbr_surface;

            }elseif ($Nbr_surface >= 50001){
                $prime_pj_annuelle = 0.10;
                $calcul_total_coti_pj = $prime_pj_annuelle * $Nbr_surface;
            }
        

        ///////////// Coef_minoration_possible /////////////

        $coef_simple = 1;

        if (request()->input('in_coef_minorations_possibles_0') > -1)
        {
            $coef_simple = $coef_simple * $coef_minorations_possibles['coefficient'][request()->input('in_coef_minorations_possibles_0')];
            $clauses .= $coef_minorations_possibles['clause'][request()->input('in_coef_minorations_possibles_0')].",";
        }
        if (request()->input('in_coef_minorations_possibles_1') > -1)
        {
            $coef_simple = $coef_simple * $coef_minorations_possibles['coefficient'][request()->input('in_coef_minorations_possibles_1')];
            $clauses .= $coef_minorations_possibles['clause'][request()->input('in_coef_minorations_possibles_1')].",";
        }
        if (request()->input('in_coef_minorations_possibles_2') > -1)
        {
            $coef_simple = $coef_simple * $coef_minorations_possibles['coefficient'][request()->input('in_coef_minorations_possibles_2')];
            $clauses .= $coef_minorations_possibles['clause'][request()->input('in_coef_minorations_possibles_2')].",";
        }

        $total_coti_pj = $calcul_total_coti_pj;


        $coef_franchise = $coef_franchise_indice * $Nbr_surface;
        //$coef_franchise = $coef_franchise_indice;

        $total_franchise  = $coef_franchise;

        if($total_franchise * $coef_simple > 800){

            $cotisation_ttc = $total_franchise * $coef_simple;
            $prime_minimum = 0;

        }else{
            $cotisation_ttc = 800;
            $prime_minimum = 800;
        }

        $test_cacul = $cotisation_ttc * 1.17;


        $result_ttc= $prime_mini + $total_coti_pj + $total_franchise;
        //$result =  $total_franchise;

        $result = array("juridique" => $total_coti_pj,
            "cotisation" => $cotisation_ttc,
            "clauses" => $clauses,
             "warnings" => $warnings,
            "rc" => 0.00,
            "in_nombre_sinistres" => $Nbr_sisnitre,
            "in_nombre_surface" => $Nbr_surface,
            "in_coef_zone" => $zone['coefficient'][$_POST['in_zone']],
            "in_coef_annee_construction" => $coef_annee_construction['designation'][$_POST['coef_annee_construction']],
            "in_coef_minorations_possibles_0" => request()->input('in_coef_minorations_possibles_0'),
            "in_coef_minorations_possibles_1" => request()->input('in_coef_minorations_possibles_1'),
            "in_coef_minorations_possibles_2" => request()->input('in_coef_minorations_possibles_2'),
            "sinistre_1" => request()->input('sinistre_1'),
            "sinistre_2" => request()->input('sinistre_2'),
            "sinistre_3" => request()->input('sinistre_3'),
            "sinistre_4" => request()->input('sinistre_4'),
            "sinistre_5" => request()->input('sinistre_5'),
            "sinistre_6" => request()->input('sinistre_6'),
            "sinistre_7" => request()->input('sinistre_7'),
            "sinistre_8" => request()->input('sinistre_8'),
            "sinistre_9" => request()->input('sinistre_9'),
            "Liste_sinistre_0" => request()->input('in_liste_sini_0'),
            "Liste_sinistre_1" => request()->input('in_liste_sini_1'),
            "Liste_sinistre_2" => request()->input('in_liste_sini_2'),
            "Liste_sinistre_3" => request()->input('in_liste_sini_3'),
            "Liste_sinistre_4" => request()->input('in_liste_sini_4'),
            "Liste_sinistre_5" => request()->input('in_liste_sini_5'),
            "Liste_sinistre_6" => request()->input('in_liste_sini_6'),
            "Liste_sinistre_7" => request()->input('in_liste_sini_7'),
            "Liste_sinistre_8" => request()->input('in_liste_sini_8'),
            "in_marge" => request()->input('in_marge'),


        );
        //dd($result , $prime_minimum , $cotisation_ttc, $test_cacul);
        Session::put("result",$result);
        //dd($result, $warnings, $clauses);

        return view('tarificateurgroupama.result_tarificateur_groupama', compact('result', 'warnings'));
    }

    public function step2(){

        $result = Session('result');

        //dd($result);
        return view('tarificateurgroupama.tarifgroupama_step2', compact('result'));

    }
    public function step3(){

        $costumer = array("in_customer_sigle" => $_POST['in_customer_sigle'],
            "in_customer_nom" => $_POST['in_customer_nom'],
            "in_customer_prenom" => $_POST['in_customer_prenom'],
            "in_customer_adresse" => $_POST['in_customer_adresse'],
            "in_customer_codepostal" => $_POST['in_customer_codepostal'],
            "in_customer_ville" => $_POST['in_customer_ville'],
            "in_customer_datedenaissance" => $_POST['in_customer_datedenaissance'],
            "in_customer_telephone" => $_POST['in_customer_telephone'],
            "in_customer_fax" => $_POST['in_customer_fax'],
            "in_customer_courriel" => $_POST['in_customer_courriel'],
            "in_risk_adresse" => $_POST['in_risk_adresse'],
            "in_risk_codepostal" => $_POST['in_risk_codepostal'],
            "in_risk_ville" => $_POST['in_risk_ville'],
            "in_risk_occupant" => $_POST['in_risk_occupant'],
            "in_risk_naturerisque" => $_POST['in_risk_naturerisque'],
            "in_risk_residence" => $_POST['in_risk_residence'],


        );

        Session::put("costumer",$costumer);

        return view('tarificateurgroupama.tarifgroupama_step3', compact('result'));

    }

    public function step4(){

        $costumer_sigle = Session::get('costumer.in_customer_sigle');
        $costumer_nom = Session::get('costumer.in_customer_nom');
        $result_rc = Session::get('result.rc');
        //$all_clauses = Session::get('result.clauses');
        //$test = Session::all();
        $product_n = session('result');
        $proposant_n = session('costumer');

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
                'customer_nom' => $costumer_sigle .' '. $costumer_nom,
                'affiliate_lastname' => Auth::user()->aff_lname,
                'affiliate_firstname' => Auth::user()->aff_fname,
                'affiliate_company' => Auth::user()->aff_company,
                'affiliate_address' =>Auth::user()->aff_adresse,
                'affiliate_city' => Auth::user()->aff_city,
                'affiliate_zip' =>Auth::user()->aff_zip,
                'affiliate_email' =>Auth::user()->email,
                'affiliate_orias' =>Auth::user()->aff_orias,
                'affiliate_tel' =>Auth::user()->aff_tel,
                'affiliate_ref' =>Auth::user()->aff_ref,
                'date_creation' => $date,
                'status' => '100-'.time().';10-'.time().';',
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
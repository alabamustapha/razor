<?php

namespace App\Http\Controllers;

use App\Models\TarificateurBatiment;
use function Composer\Autoload\includeFile;
use Illuminate\Http\Request;
use Session;
use Auth;
use DB;


class TarificateurBatimentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('aff_status_approved');
        $this->middleware('auth');
    }

    public function index1(){

        $devis = DB::table('devis')->orderBy('id', 'desc' )->paginate(10, ['*'], 'devis');

        $old_devis = DB::table('old_devis')->orderBy('id', 'desc' )->paginate(10, ['*'], 'old_devis');


        return view('tarificateurbatiment.index', compact('devis','old_devis'));
    }
    public function details($id){

        ////// Affiche

        $tarif_bat = TarificateurBatiment::findorfail($id);

        return view('tarificateurbatiment.details', compact('tarif_bat'));

    }

    public function edition_contrat($id){

        // Affiche le formulaire d'edition d'un contrat

        $tarif_bat = TarificateurBatiment::findorfail($id);


        return view('tarificateurbatiment.editioncontrat', compact('tarif_bat'));
    }

    public function edition_contrat_post($id){

        $tarif_bat = TarificateurBatiment::findorfail($id);

       $add_status = request()->input('add_status');

       DB::table('devis')->where('id', $id)->update([
           'status' => $tarif_bat->status.$add_status
       ]);


        return redirect()->route('editioncontrat', ['id' => $id]);
    }

    public function edition_contrat_post2($id){

        $tarif_bat = TarificateurBatiment::findorfail($id);

        $add_status = request()->input('add_status');
        $periodicity = request()->input('in_periodicity');

        if (TarificateurBatiment::search_status($_POST['add_status'], "30-")) {
            (float)$customer_cotisation = 0.00;
            (float)$marge = 0.00;
            (float)$cot = 0.00;
            $clauses = "";

            $product = unserialize($tarif_bat->data_product);

            if (TarificateurBatiment::search_status($_POST['add_status'], "21-")) {
                $cot = $product['cotisation'];
                $formule = "OPTION PROPRIETAIRE NON OCCUPANT";
                $rc = $product['rc'];
                $clauses = $product['clauses'];
            } else if (TarificateurBatiment::search_status($_POST['add_status'], "22-")) {
                $cot = $product['result_eco']['cotisation'];
                $formule = "OPTION ECO";
                $rc = $product['result_eco']['rc'];
                $clauses = $product['result_eco']['clauses'];
            } else if (TarificateurBatiment::search_status($_POST['add_status'], "23-")) {
                $cot = $product['result_confort']['cotisation'];
                $formule = "OPTION CONFORT";
                $rc = $product['result_confort']['rc'];
                $clauses = $product['result_confort']['clauses'];
            } else if (TarificateurBatiment::search_status($_POST['add_status'], "24-")) {
                $cot = $product['result_prestige']['cotisation'];
                $formule = "OPTION PRESTIGE";
                $rc = $product['result_prestige']['rc'];
                $clauses = $product['result_prestige']['clauses'];
            } else if (TarificateurBatiment::search_status($_POST['add_status'], "28-")) {
                $cot = $product['result_pne']['cotisation'];
                $formule = "OPTION PNE";
                $rc = $product['result_pne'];
                $clauses = $product['result_pne'];
            }else {
                $cot = -1;
                $formule = "";
            }


            $result_max_contrat_id = DB::table('devis')->select(DB::raw('MAX(id_contrat) as contrat_max_id'))->first();
            $result_old_max_contrat_id = DB::table('old_devis')->select(DB::raw('MAX(id_contrat) as contrat_max_id'))->first();
            //dd($req_contrat_max_id->contrat_max_id);
            $req_contrat_max_id = $result_max_contrat_id->contrat_max_id;
            $req_old_contrat_max_id = $result_old_max_contrat_id->contrat_max_id;



            if ($req_contrat_max_id < $req_old_contrat_max_id) {

                $contrat_max_id = $req_old_contrat_max_id + 1;

            }else{
                $contrat_max_id = $req_contrat_max_id + 1;
            }

            $date_contract = mktime(0, 0, 0, $_POST['in_date_contract_months'], $_POST['in_date_contract_days'], $_POST['in_date_contract_years']);

        }
        $calcul_customer_amount = TarificateurBatiment::calcul_customer_amount($cot, $product['in_marge']);
        $calcul_partner_amount = TarificateurBatiment::calcul_partner_amount($cot);
        $calcul_affiliate_amount =TarificateurBatiment::calcul_affiliate_amount($cot, $product['in_marge']);


            DB::table('devis')->where('id', $id)->update([
                "id_contrat" => $contrat_max_id,
                "status" => $tarif_bat->status.$add_status,
                "periodicity" => $periodicity,
                "date_contract" => $date_contract,
                "tarificateur_amount" => $cot,
                "customer_amount" => $calcul_customer_amount,
                "partner_amount" => $calcul_partner_amount,
                "affiliate_amount" => $calcul_affiliate_amount,
                "formule" => $formule,
                'customer_amount_rc' => $rc,
                'clauses' => TarificateurBatiment::clean_clauses($clauses),
            ]);

        return redirect()->route('editioncontrat', ['id' => $id]);
    }
            ////////// Edition contrat Groupama /////////

    public function edition_contrat_post3($id){

        $tarif_bat = TarificateurBatiment::findorfail($id);

        $add_status = request()->input('add_status');
        $periodicity = request()->input('in_periodicity');

        if (TarificateurBatiment::search_status($_POST['add_status'], "30-")) {
            (float)$customer_cotisation = 0.00;
            (float)$marge = 0.00;
            (float)$cot = 0.00;
            $clauses = "";

            $product = unserialize($tarif_bat->data_product);

            if (TarificateurBatiment::search_status($_POST['add_status'], "21-")) {
                $cot = $product['cotisation'] + $product['juridique'];
                $formule = "OPTION PROPRIETAIRE NON OCCUPANT";
                $rc = $product['rc'];
                $clauses = $product['clauses'];
            } else if (TarificateurBatiment::search_status($_POST['add_status'], "22-")) {
                $cot = $product['result_eco']['cotisation'];
                $formule = "OPTION ECO";
                $rc = $product['result_eco']['rc'];
                $clauses = $product['result_eco']['clauses'];
            } else if (TarificateurBatiment::search_status($_POST['add_status'], "23-")) {
                $cot = $product['result_confort']['cotisation'];
                $formule = "OPTION CONFORT";
                $rc = $product['result_confort']['rc'];
                $clauses = $product['result_confort']['clauses'];
            } else if (TarificateurBatiment::search_status($_POST['add_status'], "24-")) {
                $cot = $product['result_prestige']['cotisation'];
                $formule = "OPTION PRESTIGE";
                $rc = $product['result_prestige']['rc'];
                $clauses = $product['result_prestige']['clauses'];
            } else if (TarificateurBatiment::search_status($_POST['add_status'], "28-")) {
                $cot = $product['result_pne']['cotisation'];
                $formule = "OPTION PNE";
                $rc = $product['result_pne'];
                $clauses = $product['result_pne'];
            }else {
                $cot = -1;
                $formule = "";
            }


            $result_max_contrat_id = DB::table('devis')->select(DB::raw('MAX(id_contrat) as contrat_max_id'))->first();
            $result_old_max_contrat_id = DB::table('old_devis')->select(DB::raw('MAX(id_contrat) as contrat_max_id'))->first();
            //dd($req_contrat_max_id->contrat_max_id);
            $req_contrat_max_id = $result_max_contrat_id->contrat_max_id;
            $req_old_contrat_max_id = $result_old_max_contrat_id->contrat_max_id;



            if ($req_contrat_max_id < $req_old_contrat_max_id) {

                $contrat_max_id = $req_old_contrat_max_id + 1;

            }else{
                $contrat_max_id = $req_contrat_max_id + 1;
            }

            $date_contract = mktime(0, 0, 0, $_POST['in_date_contract_months'], $_POST['in_date_contract_days'], $_POST['in_date_contract_years']);

        }
        $calcul_customer_amount_groupama = TarificateurBatiment::calcul_customer_amount_groupama($cot, $product['in_marge']);
        $calcul_partner_amount_groupama = TarificateurBatiment::calcul_partner_amount_groupama($cot);
        $calcul_affiliate_amount_groupama =TarificateurBatiment::calcul_affiliate_amount_groupama($cot, $product['in_marge']);


            DB::table('devis')->where('id', $id)->update([
                "id_contrat" => $contrat_max_id,
                "status" => $tarif_bat->status.$add_status,
                "periodicity" => $periodicity,
                "date_contract" => $date_contract,
                "tarificateur_amount" => $cot,
                "customer_amount" => $calcul_customer_amount_groupama,
                "partner_amount" => $calcul_partner_amount_groupama,
                "affiliate_amount" => $calcul_affiliate_amount_groupama,
                "formule" => $formule,
                'customer_amount_rc' => $rc,
                'clauses' => TarificateurBatiment::clean_clauses($clauses),
            ]);

        return redirect()->route('editioncontrat', ['id' => $id]);
    }

    public function index()
    {
        $value_in_nombre_sinistre = 1;
        $value_in_nombre_surface = 0;

        $in_nombre_surface = 0;

        $tarif_bat = new TarificateurBatiment;

        $coef_zone = array( 
                "designation" => array ('01','02','03','04','05','06','07','08','09',10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95),
                "coefficient" => array (1,1,1,1,1,1.1,1,1,1,1,1.1,1,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1.2,1,1.2,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1,1,1,1,1,1,1.2,1,1,1.2,1,1,1,1,1,1.5,1,1.5,1.5,1,1,1,1,1.1,1,1,1,1,1,1,1,1.5,1.5,1.5,1.5,1.5),
                "clause"      => array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "")
        );


        $coef_aggravation_occupation = array(
            "designation" => array ("Sans aggravation",
                "Activité commerciale de 0 à 50 % SD totale",
                "agricole et fourrage < 3 tonnes",
                "agricole et fourrage > 10 tonnes",
                "agricole et fourrage > 3 et < 10 tonnes",
                "agricole sans fourrage",
                "bouteilles de gaz de 8 à 30 maximum",
                "liquides inflammables de 3000 à 8000 litres" ),
            "coefficient" => array(1, 1.15, 1.1, 1.32, 1.21, 1.1, 1.1, 1.1),
            "clause" => array("", "C04", "C07,C08", "C10", "C09", "C07", "C11", "C12")
        );

        $coef_annee_construction = array(
            "designation" => array ("Antérieure à 1948",
                "Postérieure à 1948"),
            "coefficient" => array( 1.25, 1),
            "clause" => array("", "")
        );

        $coef_antecedents = array(
            "designation" => array ("Sans antécédents aggravants",
                "Résilié compagnie",
                "Résilié non paiement"),
            "coefficient" => array(1, -1, -1),
            "clause" => array("", "", "")
        );

        $coef_specificites_techniques = array(
            "designation" => array ("Construction < 50 % matériaux durs",
                "Couverture < 90 % matériaux durs",
                "Vitres > 3 m2",
                "Couverture shingle",
                "Renonciation à recours contre l'état",
                "Renonciation à recours prop / locataire",
                "Doublement des limites en tempête" ),
            "coefficient" => array( 1.2, 1.2, 1.1, 1.1, 1.1, 1.2, 1.1),
            "clause" => array("C02", "C03", "C14", "C28", "C13", "M05", "M06")
        );

        $coef_minorations_possibles = array(
            "designation" => array ("Suppression GARANTIE VOL",
                "Suppression GARANTIE DDE",
                "Suppression GARANTIE Bris de glace",
                "Franchise suppléméntaire"),
            "coefficient" => array( 0.9, 0.9, 0.95, 0.85),
            "clause" => array("R04", "R03", "R02"," ")
        );
        $coef_protection_juridique_etendu = array(
            "designation" => array ("Protection juridique étendue"),
            "coefficient" => array(155),
            "clause" => array("")
        );

        function fill_value($values,$field,$default)
        {
            if ($values != 0)
                return $values[$field];
            else
                return $default;
        }



        return view('tarificateurbatiment.create',compact('tarif_bat', 'default','in_nombre_surface', 'values' ,'coef_zone','coef_aggravation_occupation', 'coef_annee_construction', 'coef_antecedents', 'coef_specificites_techniques', 'coef_minorations_possibles','coef_protection_juridique_etendu', 'value_in_nombre_sinistre', 'value_in_nombre_surface'));
    }


    public function index_result()
    {
        $value1 = request()->input('in_nombre_sinistres');
        $value2 = request()->input('in_nombre_surface');

        $resultat = $value1 + $value2;

        return view('tarificateurbatiment.index_result',compact('resultat'));
    }
    public function result_tarif_batiment()
    {

        
        // tarif seul
        $forfait_CP_et_fds_de_garantie = 26.3;

        // Clauses

        $clauses = ",";
        // Warning
        $warnings = array();


        

        //---------------------------------TARIF DE BASE----------------------------//
        $min_cotisation = 144;

        if (request()->input('in_nombre_surface') < 300)
            $coef_tarif_base = 0.78;
        else if (request()->input('in_nombre_surface') < 1500)
            $coef_tarif_base = 0.77;
        else if (request()->input('in_nombre_surface') < 3000)
            $coef_tarif_base = 0.76;
        else
            $coef_tarif_base = 0.75;


        $total_base = $coef_tarif_base * request()->input('in_nombre_surface');

        //---------------------------------COEF MULTIPLE----------------------------//

        $coef_zone = array( "designation" => array (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95 ),
            "coefficient" => array(1,1,1,1,1,1.1,1,1,1,1,1.1,1,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1.2,1,1.2,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1,1,1,1,1,1,1.2,1,1,1.2,1,1,1,1,1,1.5,1,1.5,1.5,1,1,1,1,1.1,1,1,1,1,1,1,1,1.5,1.5,1.5,1.5,1.5),
            "clause" => array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "")
        );

        if ($coef_zone['coefficient'][$_POST['in_coef_zone']] == 1.5)
        {
            $clauses .= "C21,";


        } else if ($coef_zone['coefficient'][$_POST['in_coef_zone']] == 1.2)
        {
            $clauses .= "C22,";
        } else {}

        $coef_nombre_sinistres= 1.05;
        if ($_POST['in_nombre_sinistres'] < 3)
        {
            $coef_nombre_sinistres = 1;
        } else if ($_POST['in_nombre_sinistres'] > 3)
        {
            $coef_nombre_sinistres = -1;
            $warnings[] = '"Nombre de sinistres trop élevé"';
        } else {

        }

        $coef_aggravation_occupation = array(
            "designation" => array ("Sans aggravation",
                "Activité commerciale de 0 à 50 % SD totale",
                "agricole et fourrage < 3 tonnes",
                "agricole et fourrage > 10 tonnes",
                "agricole et fourrage > 3 et < 10 tonnes",
                "agricole sans fourrage",
                "bouteilles de gaz de 8 à 30 maximum",
                "liquides inflammables de 3000 à 8000 litres" ),
            "coefficient" => array(1, 1.15, 1.1, 1.32, 1.21, 1.1, 1.1, 1.1),
            "clause" => array("", "C04", "C07,C08", "C10", "C09", "C07", "C11", "C12")
        );

        $coef_annee_construction = array(
            "designation" => array ("Antérieure à 1948",
                "Postérieure à 1948"),
            "coefficient" => array( 1.25, 1),
            "clause" => array("", "")
        );

        $coef_antecedents = array(
            "designation" => array ("Sans antécédents aggravants",
                "Résilié compagnie",
                "Résilié non paiement"),
            "coefficient" => array(1, -1, -1),
            "clause" => array("", "", "")
        );

        $coef_multiple = $coef_aggravation_occupation['coefficient'][$_POST['in_coef_aggravation_occupation']] *
            $coef_annee_construction['coefficient'][$_POST['in_coef_annee_construction']] *
            $coef_zone['coefficient'][$_POST['in_coef_zone']] *
            $coef_nombre_sinistres *
            $coef_antecedents['coefficient'][$_POST['in_coef_antecedents']];

        $clauses .= $coef_aggravation_occupation['clause'][$_POST['in_coef_aggravation_occupation']] .",".
            $coef_annee_construction['clause'][$_POST['in_coef_annee_construction']] .",";

        if ($coef_antecedents['coefficient'][$_POST['in_coef_antecedents']] == -1)
        {
            $warnings[] = '"Antecedents de resiliation"';
        }

        //----------------------------------COEF SIMPLE-----------------------------//
        $coef_defautprotection = 1;
        if (request()->input('in_etat_defautprotection') > 0)
        {
            $clauses .= "C16,";
            if ($coef_zone['coefficient'][request()->input('in_coef_zone')] == 1.5)
            {
                $coef_defautprotection = -1;
                $warnings[] = '"Defaut de protection" et "Departement en zone de coefficient 1.5" selectionnes';
            }
            else if ($coef_zone['coefficient'][request()->input('in_coef_zone')] == 1.2)
                $coef_defautprotection = 1.25;
            else
                $coef_defautprotection = 1.15;
        }


        $coef_specificites_techniques = array(
            "designation" => array ("Construction < 50 % matériaux durs",
                "Couverture < 90 % matériaux durs",
                "Vitres > 3 m2",
                "Couverture shingle",
                "Renonciation à recours contre l'état",
                "Renonciation à recours prop / locataire",
                "Doublement des limites en tempête" ),
            "coefficient" => array( 1.2, 1.2, 1.1, 1.1, 1.1, 1.2, 1.1),
            "clause" => array("C02", "C03", "C14", "C28", "C13", "M05", "M06")
        );


        $coef_simple = 1 * $coef_defautprotection;
        if (request()->input('in_coef_specificites_techniques_0') > -1)
        {
            $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][request()->input('in_coef_specificites_techniques_0')];
            $clauses .= $coef_specificites_techniques['clause'][request()->input('in_coef_specificites_techniques_0')].",";
        }
        if (request()->input('in_coef_specificites_techniques_1') > -1)
        {
            $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][request()->input('in_coef_specificites_techniques_1')];
            $clauses .= $coef_specificites_techniques['clause'][request()->input('in_coef_specificites_techniques_1')].",";
        }
        if (request()->input('in_coef_specificites_techniques_2') > -1)
        {
            $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][request()->input('in_coef_specificites_techniques_2')];
            $clauses .= $coef_specificites_techniques['clause'][request()->input('in_coef_specificites_techniques_2')].",";
        }
        if (request()->input('in_coef_specificites_techniques_3') > -1)
        {
            $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][request()->input('in_coef_specificites_techniques_3')];
            $clauses .= $coef_specificites_techniques['clause'][request()->input('in_coef_specificites_techniques_3')].",";
        }
        if (request()->input('in_coef_specificites_techniques_4') > -1)
        {
            $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][request()->input('in_coef_specificites_techniques_4')];
            $clauses .= $coef_specificites_techniques['clause'][request()->input('in_coef_specificites_techniques_4')].",";
        }
        if (request()->input('in_coef_specificites_techniques_5') > -1)
        {
            $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][request()->input('in_coef_specificites_techniques_5')];
            $clauses .= $coef_specificites_techniques['clause'][request()->input('in_coef_specificites_techniques_5')].",";
        }
        if (request()->input('in_coef_specificites_techniques_6') > -1)
        {
            $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][request()->input('in_coef_specificites_techniques_6')];
            $clauses .= $coef_specificites_techniques['clause'][request()->input('in_coef_specificites_techniques_6')].",";
        }
        $coef_minorations_possibles = array(
            "designation" => array ("Suppression GARANTIE VOL",
                "Suppression GARANTIE DDE",
                "Suppression GARANTIE Bris de glace",
                "Franchise suppléméntaire"),
            "coefficient" => array( 0.9, 0.9, 0.95, 0.85),
            "clause" => array("R04", "R03", "R02"," ")
        );

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

// if ($_POST['in_coef_minorations_possibles_3'] > -1)
// {
//	$coef_simple = $coef_simple * $coef_minorations_possibles['coefficient'][$_POST['in_coef_minorations_possibles_3']];
//	$clauses .= $coef_minorations_possibles['clause'][$_POST['in_coef_minorations_possibles_3']].",";
// }
        //----------------------------------Protection juridique étendu-----------------------------//
        /*$protection_juridique_etendu = array(
            "designation" => array ("Protection juridique étendue"),
            "coefficient" => array(155),
            "clause" => array("")
        );

        if ($_POST['in_protection_juridique_etendu'] > -1)
        {
            $coef_simple_protection =  $protection_juridique_etendu['coefficient'][$_POST['in_coef_minorations_possibles_2']];

        }*/
        //----------------------------------CALCUL CMT-----------------------------//

        if (( $coef_zone['designation'][$_POST['in_coef_zone']] == 25 ) || ($coef_zone['designation'][$_POST['in_coef_zone']] == 88) || ($coef_zone['designation'][$_POST['in_coef_zone']] == 95)){
            $CMT_total = 1;
        }else{
            $CMT_total = 1.10;
        }

        $CMT = $CMT_total;


        if($_POST['in_nombre_surface'] >= 1501){
            $coef_tarif_base = 0.78;
            $warnings[] = '"Surface développée trop élévé"';
        }


        //----------------------------------CALCUL COTI-----------------------------//

        // TMP A VARIABILISER

        $total_corrige_coef = ($total_base * $coef_multiple * $coef_simple * $CMT * 0.85);	// total corrigé coef = total base X coef global retenu X CMT

        $tarif_retenu = max($total_corrige_coef, $min_cotisation);

        $surfaceDeveloppee = $_POST['in_nombre_surface'];
        if ($_POST['in_nombre_baux'] > 0 and $surfaceDeveloppee > 0)
        {
            $protection_juridique = $surfaceDeveloppee * 0.13;
            if($protection_juridique < 135)
            {
                $protection_juridique = 135;
            }

            $protection_juridique = $protection_juridique + 20;
        }
        else
        {
            $protection_juridique = 0;
        }


        $cotisation_total_annuelle = $tarif_retenu + $forfait_CP_et_fds_de_garantie;

        $result = array("juridique" => $protection_juridique,
            "cotisation" => $cotisation_total_annuelle,
            "clauses" => $clauses, "warnings" => $warnings,
            "rc" => 0.00,
            "in_nombre_sinistres" => $_POST['in_nombre_sinistres'],
            "in_nombre_surface" => $_POST['in_nombre_surface'],
            "in_coef_zone" => $_POST['in_coef_zone'],
            "in_coef_aggravation_occupation" => $_POST['in_coef_aggravation_occupation'],
            "in_coef_annee_construction" => $_POST['in_coef_annee_construction'],
            "in_coef_antecedents" => $_POST['in_coef_antecedents'],
            "in_coef_specificites_techniques_0" => $_POST['in_coef_specificites_techniques_0'],
            "in_coef_specificites_techniques_1" => $_POST['in_coef_specificites_techniques_1'],
            "in_coef_specificites_techniques_2" => $_POST['in_coef_specificites_techniques_2'],
            "in_coef_specificites_techniques_3" => $_POST['in_coef_specificites_techniques_3'],
            "in_coef_specificites_techniques_4" => $_POST['in_coef_specificites_techniques_4'],
            "in_coef_specificites_techniques_5" => $_POST['in_coef_specificites_techniques_5'],
            "in_coef_specificites_techniques_6" => $_POST['in_coef_specificites_techniques_6'],
            "in_etat_defautprotection" => $_POST['in_etat_defautprotection'],
            "in_nombre_baux" => $_POST['in_nombre_baux'],
            "in_coef_minorations_possibles_0" => $_POST['in_coef_minorations_possibles_0'],
            "in_coef_minorations_possibles_1" => $_POST['in_coef_minorations_possibles_1'],
            "in_coef_minorations_possibles_2" => $_POST['in_coef_minorations_possibles_2'],
            "in_marge" => $_POST['in_marge'],

        );





        //dd($clauses, $test, $coef_zone['coefficient'][$_POST['in_coef_zone']]);



        Session::put("result",$result);



        return view('tarificateurbatiment.result_tarif_batiment', compact('result', 'warnings','clauses'));


    }
    public function step2(){

        $coef_zone = Session::get('result.in_coef_zone');




        //dd($data, $test);



        return view('tarificateurbatiment.tarifbat_step2',compact('coef_zone'));
    }
    public function step3(){


        $coef_zone = Session::get('result.in_coef_zone');


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
            "in_risk_codepostal" => ($coef_zone +1) .''. $_POST['in_risk_codepostal'],
            "in_risk_ville" => $_POST['in_risk_ville'],
            "in_risk_occupant" => $_POST['in_risk_occupant'],
            "in_risk_naturerisque" => $_POST['in_risk_naturerisque'],
            "in_risk_residence" => $_POST['in_risk_residence'],


        );


        //dd($costumer, $Session);


        Session::put("costumer",$costumer);


        return view('tarificateurbatiment.tarifbat_step3');

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
                'type_product' => 2,
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
                'customer_amount_rc' => $result_rc,
                'date_contract' => 0,
                'clauses' => '',



            ],

        ]);

        $ref_contrat = DB::table('devis')->where('affiliate_users', Auth::user()->id)->pluck('id', 'id')->last();
        //dd($costumer_sigle, $costumer_nom, $product, $proposant,  $result_rc, $ref_contrat);
        $contrat = $ref_contrat;
        return view('tarificateurbatiment.tarifbat_step4', compact('contrat'));
    }

    ////// Modification du devis batiment ////////

    public function modif_batiment_step_1($id){

        $modif_tarif_bat = DB::table('devis')->where('id', $id)->get();

        $devis_id = $modif_tarif_bat[0]->id;
        $proposant = unserialize($modif_tarif_bat[0]->data_proposant);
        $product = unserialize($modif_tarif_bat[0]->data_product);

        $coef_zone = array( "designation" => array (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95 ),
            "coefficient" => array(1,1,1,1,1,1.1,1,1,1,1,1.1,1,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1.2,1,1.2,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1,1,1,1,1,1,1.2,1,1,1.2,1,1,1,1,1,1.5,1,1.5,1.5,1,1,1,1,1.1,1,1,1,1,1,1,1,1.5,1.5,1.5,1.5,1.5),
            "clause" => array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "")
        );
        $coef_aggravation_occupation = array(
            "designation" => array ("Sans aggravation",
                "Activité commerciale de 0 à 50 % SD totale",
                "agricole et fourrage < 3 tonnes",
                "agricole et fourrage > 10 tonnes",
                "agricole et fourrage > 3 et < 10 tonnes",
                "agricole sans fourrage",
                "bouteilles de gaz de 8 à 30 maximum",
                "liquides inflammables de 3000 à 8000 litres" ),
            "coefficient" => array(1, 1.15, 1.1, 1.32, 1.21, 1.1, 1.1, 1.1),
            "clause" => array("", "C04", "C07,C08", "C10", "C09", "C07", "C11", "C12")
        );

        $coef_annee_construction = array(
            "designation" => array ("Antérieure à 1948",
                "Postérieure à 1948"),
            "coefficient" => array( 1.25, 1),
            "clause" => array("", "")
        );

        $coef_antecedents = array(
            "designation" => array ("Sans antécédents aggravants",
                "Résilié compagnie",
                "Résilié non paiement"),
            "coefficient" => array(1, -1, -1),
            "clause" => array("", "", "")
        );

        $coef_specificites_techniques = array(
            "designation" => array ("Construction < 50 % matériaux durs",
                "Couverture < 90 % matériaux durs",
                "Vitres > 3 m2",
                "Couverture shingle",
                "Renonciation à recours contre l'état",
                "Renonciation à recours prop / locataire",
                "Doublement des limites en tempête" ),
            "coefficient" => array( 1.2, 1.2, 1.1, 1.1, 1.1, 1.2, 1.1),
            "clause" => array("C02", "C03", "C14", "C28", "C13", "M05", "M06")
        );

        $coef_minorations_possibles = array(
            "designation" => array ("Suppression GARANTIE VOL",
                "Suppression GARANTIE DDE",
                "Suppression GARANTIE Bris de glace",
                "Franchise suppléméntaire"),
            "coefficient" => array( 0.9, 0.9, 0.95, 0.85),
            "clause" => array("R04", "R03", "R02"," ")
        );
        $coef_protection_juridique_etendu = array(
            "designation" => array ("Protection juridique étendue"),
            "coefficient" => array(155),
            "clause" => array("")
        );

        //dd($product);
        return view('tarificateurbatiment.modif_step_1', compact('tarif_bat','product', 'proposant', 'coef_zone', 'coef_aggravation_occupation','coef_annee_construction','coef_antecedents','coef_specificites_techniques','coef_minorations_possibles','coef_protection_juridique_etendu','devis_id'));
    }
    public function result_tarif_modif()
    {
        // tarif seul
        $forfait_CP_et_fds_de_garantie = 26.3;

        // Clauses

        $clauses = ",";
        // Warning
        $warnings = array();


        //---------------------------------TARIF DE BASE----------------------------//
        $min_cotisation = 144;

        if (request()->input('in_nombre_surface') < 300)
            $coef_tarif_base = 0.78;
        else if (request()->input('in_nombre_surface') < 1500)
            $coef_tarif_base = 0.77;
        else if (request()->input('in_nombre_surface') < 3000)
            $coef_tarif_base = 0.76;
        else
            $coef_tarif_base = 0.75;


        $total_base = $coef_tarif_base * request()->input('in_nombre_surface');

        //---------------------------------COEF MULTIPLE----------------------------//

        $coef_zone = array( "designation" => array (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95 ),
            "coefficient" => array(1,1,1,1,1,1.1,1,1,1,1,1.1,1,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1.2,1,1.2,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1,1,1,1,1,1,1.2,1,1,1.2,1,1,1,1,1,1.5,1,1.5,1.5,1,1,1,1,1.1,1,1,1,1,1,1,1,1.5,1.5,1.5,1.5,1.5),
            "clause" => array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "")
        );

        if ($coef_zone['coefficient'][$_POST['in_coef_zone']] == 1.5)
        {
            $clauses .= "C21,";


        } else if ($coef_zone['coefficient'][$_POST['in_coef_zone']] == 1.2)
        {
            $clauses .= "C22,";
        } else {}

        $coef_nombre_sinistres= 1.05;
        if ($_POST['in_nombre_sinistres'] < 3)
        {
            $coef_nombre_sinistres = 1;
        } else if ($_POST['in_nombre_sinistres'] > 3)
        {
            $coef_nombre_sinistres = -1;
            $warnings[] = '"Nombre de sinistres trop élevé"';
        } else {

        }

        $coef_aggravation_occupation = array(
            "designation" => array ("Sans aggravation",
                "Activité commerciale de 0 à 50 % SD totale",
                "agricole et fourrage < 3 tonnes",
                "agricole et fourrage > 10 tonnes",
                "agricole et fourrage > 3 et < 10 tonnes",
                "agricole sans fourrage",
                "bouteilles de gaz de 8 à 30 maximum",
                "liquides inflammables de 3000 à 8000 litres" ),
            "coefficient" => array(1, 1.15, 1.1, 1.32, 1.21, 1.1, 1.1, 1.1),
            "clause" => array("", "C04", "C07,C08", "C10", "C09", "C07", "C11", "C12")
        );

        $coef_annee_construction = array(
            "designation" => array ("Antérieure à 1948",
                "Postérieure à 1948"),
            "coefficient" => array( 1.25, 1),
            "clause" => array("", "")
        );

        $coef_antecedents = array(
            "designation" => array ("Sans antécédents aggravants",
                "Résilié compagnie",
                "Résilié non paiement"),
            "coefficient" => array(1, -1, -1),
            "clause" => array("", "", "")
        );

        $coef_multiple = $coef_aggravation_occupation['coefficient'][$_POST['in_coef_aggravation_occupation']] *
            $coef_annee_construction['coefficient'][$_POST['in_coef_annee_construction']] *
            $coef_zone['coefficient'][$_POST['in_coef_zone']] *
            $coef_nombre_sinistres *
            $coef_antecedents['coefficient'][$_POST['in_coef_antecedents']];

        $clauses .= $coef_aggravation_occupation['clause'][$_POST['in_coef_aggravation_occupation']] .",".
            $coef_annee_construction['clause'][$_POST['in_coef_annee_construction']] .",";

        if ($coef_antecedents['coefficient'][$_POST['in_coef_antecedents']] == -1)
        {
            $warnings[] = '"Antecedents de resiliation"';
        }

        //----------------------------------COEF SIMPLE-----------------------------//
        $coef_defautprotection = 1;
        if (request()->input('in_etat_defautprotection') > 0)
        {
            $clauses .= "C16,";
            if ($coef_zone['coefficient'][request()->input('in_coef_zone')] == 1.5)
            {
                $coef_defautprotection = -1;
                $warnings[] = '"Defaut de protection" et "Departement en zone de coefficient 1.5" selectionnes';
            }
            else if ($coef_zone['coefficient'][request()->input('in_coef_zone')] == 1.2)
                $coef_defautprotection = 1.25;
            else
                $coef_defautprotection = 1.15;
        }


        $coef_specificites_techniques = array(
            "designation" => array ("Construction < 50 % matériaux durs",
                "Couverture < 90 % matériaux durs",
                "Vitres > 3 m2",
                "Couverture shingle",
                "Renonciation à recours contre l'état",
                "Renonciation à recours prop / locataire",
                "Doublement des limites en tempête" ),
            "coefficient" => array( 1.2, 1.2, 1.1, 1.1, 1.1, 1.2, 1.1),
            "clause" => array("C02", "C03", "C14", "C28", "C13", "M05", "M06")
        );


        $coef_simple = 1 * $coef_defautprotection;
        if (request()->input('in_coef_specificites_techniques_0') > -1)
        {
            $coef_simple = $coef_simple * 1.2;
            $clauses .= "C02,";
        }
        if (request()->input('in_coef_specificites_techniques_1') > -1)
        {
            $coef_simple = $coef_simple * 1.2;
            $clauses .= "C03,";
        }
        if (request()->input('in_coef_specificites_techniques_2') > -1)
        {
            $coef_simple = $coef_simple * 1.1;
            $clauses .= "C14,";
        }
        if (request()->input('in_coef_specificites_techniques_3') > -1)
        {
            $coef_simple = $coef_simple * 1.1;
            $clauses .= "C28,";
        }
        if (request()->input('in_coef_specificites_techniques_4') > -1)
        {
            $coef_simple = $coef_simple * 1.1;
            $clauses .= "C13,";
        }
        if (request()->input('in_coef_specificites_techniques_5') > -1)
        {
            $coef_simple = $coef_simple * 1.2;
            $clauses .= "M05,";;
        }
        if (request()->input('in_coef_specificites_techniques_6') > -1)
        {
            $coef_simple = $coef_simple * 1.1;
            $clauses .= "M06,";
        }
        $coef_minorations_possibles = array(
            "designation" => array ("Suppression GARANTIE VOL",
                "Suppression GARANTIE DDE",
                "Suppression GARANTIE Bris de glace",
                "Franchise suppléméntaire"),
            "coefficient" => array( 0.9, 0.9, 0.95, 0.85),
            "clause" => array("R04", "R03", "R02"," ")
        );

        if (request()->input('in_coef_minorations_possibles_0') > -1)
        {
            $coef_simple = $coef_simple * 0.9;
            $clauses .= "R04,";
        }
        if (request()->input('in_coef_minorations_possibles_1') > -1)
        {
            $coef_simple = $coef_simple * 0.9;
            $clauses .= "R03,";
        }
        if (request()->input('in_coef_minorations_possibles_2') > -1)
        {
            $coef_simple = $coef_simple * 0.95;
            $clauses .= "R02,";
        }

// if ($_POST['in_coef_minorations_possibles_3'] > -1)
// {
//	$coef_simple = $coef_simple * $coef_minorations_possibles['coefficient'][$_POST['in_coef_minorations_possibles_3']];
//	$clauses .= $coef_minorations_possibles['clause'][$_POST['in_coef_minorations_possibles_3']].",";
// }
        //----------------------------------Protection juridique étendu-----------------------------//
        /*$protection_juridique_etendu = array(
            "designation" => array ("Protection juridique étendue"),
            "coefficient" => array(155),
            "clause" => array("")
        );

        if ($_POST['in_protection_juridique_etendu'] > -1)
        {
            $coef_simple_protection =  $protection_juridique_etendu['coefficient'][$_POST['in_coef_minorations_possibles_2']];

        }*/
        //----------------------------------CALCUL CMT-----------------------------//

        if (( $coef_zone['designation'][$_POST['in_coef_zone']] == 25 ) || ($coef_zone['designation'][$_POST['in_coef_zone']] == 88) || ($coef_zone['designation'][$_POST['in_coef_zone']] == 95)){
            $CMT_total = 1;
        }else{
            $CMT_total = 1.10;
        }

        $CMT = $CMT_total;




        //----------------------------------CALCUL COTI-----------------------------//

        // TMP A VARIABILISER

        $total_corrige_coef = ($total_base * $coef_multiple * $coef_simple * $CMT * 0.85);	// total corrigé coef = total base X coef global retenu X CMT

        $tarif_retenu = max($total_corrige_coef, $min_cotisation);

        $surfaceDeveloppee = $_POST['in_nombre_surface'];
        if ($_POST['in_nombre_baux'] > 0 and $surfaceDeveloppee > 0)
        {
            $protection_juridique = $surfaceDeveloppee * 0.13;
            if($protection_juridique < 135)
            {
                $protection_juridique = 135;
            }

            $protection_juridique = $protection_juridique + 20;
        }
        else
        {
            $protection_juridique = 0;
        }


        $cotisation_total_annuelle = $tarif_retenu + $forfait_CP_et_fds_de_garantie;

        $result = array("juridique" => $protection_juridique,
            "cotisation" => $cotisation_total_annuelle,
            "clauses" => $clauses, "warnings" => $warnings,
            "rc" => 0.00,
            "in_nombre_sinistres" => $_POST['in_nombre_sinistres'],
            "in_nombre_surface" => $_POST['in_nombre_surface'],
            "in_coef_zone" => $_POST['in_coef_zone'],
            "in_coef_aggravation_occupation" => $_POST['in_coef_aggravation_occupation'],
            "in_coef_annee_construction" => $_POST['in_coef_annee_construction'],
            "in_coef_antecedents" => $_POST['in_coef_antecedents'],
            "in_coef_specificites_techniques_0" => $_POST['in_coef_specificites_techniques_0'],
            "in_coef_specificites_techniques_1" => $_POST['in_coef_specificites_techniques_1'],
            "in_coef_specificites_techniques_2" => $_POST['in_coef_specificites_techniques_2'],
            "in_coef_specificites_techniques_3" => $_POST['in_coef_specificites_techniques_3'],
            "in_coef_specificites_techniques_4" => $_POST['in_coef_specificites_techniques_4'],
            "in_coef_specificites_techniques_5" => $_POST['in_coef_specificites_techniques_5'],
            "in_coef_specificites_techniques_6" => $_POST['in_coef_specificites_techniques_6'],
            "in_etat_defautprotection" => $_POST['in_etat_defautprotection'],
            "in_nombre_baux" => $_POST['in_nombre_baux'],
            "in_coef_minorations_possibles_0" => $_POST['in_coef_minorations_possibles_0'],
            "in_coef_minorations_possibles_1" => $_POST['in_coef_minorations_possibles_1'],
            "in_coef_minorations_possibles_2" => $_POST['in_coef_minorations_possibles_2'],
            "in_marge" => $_POST['in_marge'],

        );



        Session::put("result",$result);

        //dd($result, $warnings, $clauses);

        return view('tarificateurbatiment.result_tarif_modif', compact('result', 'warnings','clauses'));


    }
    public function modif_step_1_post($id){

// tarif seul
        $forfait_CP_et_fds_de_garantie = 26.3;

        // Clauses

        $clauses = ",";
        // Warning
        $warnings = array();


        //---------------------------------TARIF DE BASE----------------------------//
        $min_cotisation = 144;

        if (request()->input('in_nombre_surface') < 300)
            $coef_tarif_base = 0.78;
        else if (request()->input('in_nombre_surface') < 1500)
            $coef_tarif_base = 0.77;
        else if (request()->input('in_nombre_surface') < 3000)
            $coef_tarif_base = 0.76;
        else
            $coef_tarif_base = 0.75;


        $total_base = $coef_tarif_base * request()->input('in_nombre_surface');

        //---------------------------------COEF MULTIPLE----------------------------//

        $coef_zone = array( "designation" => array (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95 ),
            "coefficient" => array(1,1,1,1,1,1.1,1,1,1,1,1.1,1,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1.2,1,1.2,1.2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1.2,1,1,1,1,1,1,1.2,1,1,1.2,1,1,1,1,1,1.5,1,1.5,1.5,1,1,1,1,1.1,1,1,1,1,1,1,1,1.5,1.5,1.5,1.5,1.5),
            "clause" => array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "")
        );

        if ($coef_zone['coefficient'][$_POST['in_coef_zone']] == 1.5)
        {
            $clauses .= "C21,";


        } else if ($coef_zone['coefficient'][$_POST['in_coef_zone']] == 1.2)
        {
            $clauses .= "C22,";
        } else {}

        $coef_nombre_sinistres= 1.05;
        if ($_POST['in_nombre_sinistres'] < 3)
        {
            $coef_nombre_sinistres = 1;
        } else if ($_POST['in_nombre_sinistres'] > 3)
        {
            $coef_nombre_sinistres = -1;
            $warnings[] = '"Nombre de sinistres trop élevé"';
        } else {

        }

        $coef_aggravation_occupation = array(
            "designation" => array ("Sans aggravation",
                "Activité commerciale de 0 à 50 % SD totale",
                "agricole et fourrage < 3 tonnes",
                "agricole et fourrage > 10 tonnes",
                "agricole et fourrage > 3 et < 10 tonnes",
                "agricole sans fourrage",
                "bouteilles de gaz de 8 à 30 maximum",
                "liquides inflammables de 3000 à 8000 litres" ),
            "coefficient" => array(1, 1.15, 1.1, 1.32, 1.21, 1.1, 1.1, 1.1),
            "clause" => array("", "C04", "C07,C08", "C10", "C09", "C07", "C11", "C12")
        );

        $coef_annee_construction = array(
            "designation" => array ("Antérieure à 1948",
                "Postérieure à 1948"),
            "coefficient" => array( 1.25, 1),
            "clause" => array("", "")
        );

        $coef_antecedents = array(
            "designation" => array ("Sans antécédents aggravants",
                "Résilié compagnie",
                "Résilié non paiement"),
            "coefficient" => array(1, -1, -1),
            "clause" => array("", "", "")
        );

        $coef_multiple = $coef_aggravation_occupation['coefficient'][$_POST['in_coef_aggravation_occupation']] *
            $coef_annee_construction['coefficient'][$_POST['in_coef_annee_construction']] *
            $coef_zone['coefficient'][$_POST['in_coef_zone']] *
            $coef_nombre_sinistres *
            $coef_antecedents['coefficient'][$_POST['in_coef_antecedents']];

        $clauses .= $coef_aggravation_occupation['clause'][$_POST['in_coef_aggravation_occupation']] .",".
            $coef_annee_construction['clause'][$_POST['in_coef_annee_construction']] .",";

        if ($coef_antecedents['coefficient'][$_POST['in_coef_antecedents']] == -1)
        {
            $warnings[] = '"Antecedents de resiliation"';
        }

        //----------------------------------COEF SIMPLE-----------------------------//
        $coef_defautprotection = 1;
        if (request()->input('in_etat_defautprotection') > 0)
        {
            $clauses .= "C16,";
            if ($coef_zone['coefficient'][request()->input('in_coef_zone')] == 1.5)
            {
                $coef_defautprotection = -1;
                $warnings[] = '"Defaut de protection" et "Departement en zone de coefficient 1.5" selectionnes';
            }
            else if ($coef_zone['coefficient'][request()->input('in_coef_zone')] == 1.2)
                $coef_defautprotection = 1.25;
            else
                $coef_defautprotection = 1.15;
        }


        $coef_specificites_techniques = array(
            "designation" => array ("Construction < 50 % matériaux durs",
                "Couverture < 90 % matériaux durs",
                "Vitres > 3 m2",
                "Couverture shingle",
                "Renonciation à recours contre l'état",
                "Renonciation à recours prop / locataire",
                "Doublement des limites en tempête" ),
            "coefficient" => array( 1.2, 1.2, 1.1, 1.1, 1.1, 1.2, 1.1),
            "clause" => array("C02", "C03", "C14", "C28", "C13", "M05", "M06")
        );


        $coef_simple = 1 * $coef_defautprotection;
        if (request()->input('in_coef_specificites_techniques_0') > -1)
        {
            $coef_simple = $coef_simple * 1.2;
            $clauses .= "C02,";
        }
        if (request()->input('in_coef_specificites_techniques_1') > -1)
        {
            $coef_simple = $coef_simple * 1.2;
            $clauses .= "C03,";
        }
        if (request()->input('in_coef_specificites_techniques_2') > -1)
        {
            $coef_simple = $coef_simple * 1.1;
            $clauses .= "C14,";
        }
        if (request()->input('in_coef_specificites_techniques_3') > -1)
        {
            $coef_simple = $coef_simple * 1.1;
            $clauses .= "C28,";
        }
        if (request()->input('in_coef_specificites_techniques_4') > -1)
        {
            $coef_simple = $coef_simple * 1.1;
            $clauses .= "C13,";
        }
        if (request()->input('in_coef_specificites_techniques_5') > -1)
        {
            $coef_simple = $coef_simple * 1.2;
            $clauses .= "M05,";;
        }
        if (request()->input('in_coef_specificites_techniques_6') > -1)
        {
            $coef_simple = $coef_simple * 1.1;
            $clauses .= "M06,";
        }
        $coef_minorations_possibles = array(
            "designation" => array ("Suppression GARANTIE VOL",
                "Suppression GARANTIE DDE",
                "Suppression GARANTIE Bris de glace",
                "Franchise suppléméntaire"),
            "coefficient" => array( 0.9, 0.9, 0.95, 0.85),
            "clause" => array("R04", "R03", "R02"," ")
        );

        if (request()->input('in_coef_minorations_possibles_0') > -1)
        {
            $coef_simple = $coef_simple * 0.9;
            $clauses .= "R04,";
        }
        if (request()->input('in_coef_minorations_possibles_1') > -1)
        {
            $coef_simple = $coef_simple * 0.9;
            $clauses .= "R03,";
        }
        if (request()->input('in_coef_minorations_possibles_2') > -1)
        {
            $coef_simple = $coef_simple * 0.95;
            $clauses .= "R02,";
        }

// if ($_POST['in_coef_minorations_possibles_3'] > -1)
// {
//	$coef_simple = $coef_simple * $coef_minorations_possibles['coefficient'][$_POST['in_coef_minorations_possibles_3']];
//	$clauses .= $coef_minorations_possibles['clause'][$_POST['in_coef_minorations_possibles_3']].",";
// }
        //----------------------------------Protection juridique étendu-----------------------------//
        /*$protection_juridique_etendu = array(
            "designation" => array ("Protection juridique étendue"),
            "coefficient" => array(155),
            "clause" => array("")
        );

        if ($_POST['in_protection_juridique_etendu'] > -1)
        {
            $coef_simple_protection =  $protection_juridique_etendu['coefficient'][$_POST['in_coef_minorations_possibles_2']];

        }*/
        //----------------------------------CALCUL CMT-----------------------------//

        if (( $coef_zone['designation'][$_POST['in_coef_zone']] == 25 ) || ($coef_zone['designation'][$_POST['in_coef_zone']] == 88) || ($coef_zone['designation'][$_POST['in_coef_zone']] == 95)){
            $CMT_total = 1;
        }else{
            $CMT_total = 1.10;
        }

        $CMT = $CMT_total;




        //----------------------------------CALCUL COTI-----------------------------//

        // TMP A VARIABILISER

        $total_corrige_coef = ($total_base * $coef_multiple * $coef_simple * $CMT * 0.85);	// total corrigé coef = total base X coef global retenu X CMT

        $tarif_retenu = max($total_corrige_coef, $min_cotisation);

        $surfaceDeveloppee = $_POST['in_nombre_surface'];
        if ($_POST['in_nombre_baux'] > 0 and $surfaceDeveloppee > 0)
        {
            $protection_juridique = $surfaceDeveloppee * 0.13;
            if($protection_juridique < 135)
            {
                $protection_juridique = 135;
            }

            $protection_juridique = $protection_juridique + 20;
        }
        else
        {
            $protection_juridique = 0;
        }


        $cotisation_total_annuelle = $tarif_retenu + $forfait_CP_et_fds_de_garantie;

        $result = array("juridique" => $protection_juridique,
            "cotisation" => $cotisation_total_annuelle,
            "clauses" => $clauses, "warnings" => $warnings,
            "rc" => 0.00,
            "in_nombre_sinistres" => $_POST['in_nombre_sinistres'],
            "in_nombre_surface" => $_POST['in_nombre_surface'],
            "in_coef_zone" => $_POST['in_coef_zone'],
            "in_coef_aggravation_occupation" => $_POST['in_coef_aggravation_occupation'],
            "in_coef_annee_construction" => $_POST['in_coef_annee_construction'],
            "in_coef_antecedents" => $_POST['in_coef_antecedents'],
            "in_coef_specificites_techniques_0" => $_POST['in_coef_specificites_techniques_0'],
            "in_coef_specificites_techniques_1" => $_POST['in_coef_specificites_techniques_1'],
            "in_coef_specificites_techniques_2" => $_POST['in_coef_specificites_techniques_2'],
            "in_coef_specificites_techniques_3" => $_POST['in_coef_specificites_techniques_3'],
            "in_coef_specificites_techniques_4" => $_POST['in_coef_specificites_techniques_4'],
            "in_coef_specificites_techniques_5" => $_POST['in_coef_specificites_techniques_5'],
            "in_coef_specificites_techniques_6" => $_POST['in_coef_specificites_techniques_6'],
            "in_etat_defautprotection" => $_POST['in_etat_defautprotection'],
            "in_nombre_baux" => $_POST['in_nombre_baux'],
            "in_coef_minorations_possibles_0" => $_POST['in_coef_minorations_possibles_0'],
            "in_coef_minorations_possibles_1" => $_POST['in_coef_minorations_possibles_1'],
            "in_coef_minorations_possibles_2" => $_POST['in_coef_minorations_possibles_2'],
            "in_marge" => $_POST['in_marge'],

        );


        $product = serialize($result);


        DB::table('devis')->where('id', $id)->update([
            'data_product' => $product,
        ]);

        return redirect()->route('home');
    }

    public function test_search(){

        //dd('ici');
        return view('tarificateurbatiment.page_test_search');
    }

    public function result_test_search(){

        
        if(request()->input('type_product') == 0){
            $devis = 1;
            if(request()->input('product_choice') == 0){
                $devis_id = request()->input('search');
               $devis_search = DB::table('devis')->where('id', $devis_id)->get();
            }elseif(request()->input('product_choice') == 1){
                $devis_courtier = request()->input('search');
                $devis_search = DB::table('devis')->where('affiliate_lastname', $devis_courtier)->get();
            }
        }elseif(request()->input('type_product') == 1){
            $devis = 2;
            if(request()->input('product_choice') == 0){
                $devis_id = request()->input('search');
                $devis_search = DB::table('old_devis')->where('id', $devis_id)->get();
            }elseif(request()->input('product_choice') == 1){
                $devis_courtier = request()->input('search');
                $devis_search = DB::table('old_devis')->where('affiliate_lastname', $devis_courtier)->get();
            }
        }
        //dd($devis_search, $devis);
        return view('tarificateurbatiment.result_search',compact('devis_search', 'devis'));
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

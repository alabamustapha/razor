<?php

namespace App\Http\Controllers;

use App\Models\TarificateurOldDevis;
use Illuminate\Http\Request;
use Session;
use Auth;
use DB;

class TarificateurOldDevisController extends Controller
{

    public function __construct()
    {
        $this->middleware('aff_status_approved');
        $this->middleware('auth');
    }

    public function index(){


        $old_devis = DB::table('old_devis')->orderBy('id', 'desc' )->paginate(10);

        return view('tarificateurbatiment.index', compact('old_devis'));

    }
    public function old_details($id){

        $old_tarif_bat = TarificateurOldDevis::findorfail($id);

        return view('tarificateurbatiment.old_details', compact('old_tarif_bat'));


    }
    public function old_edition_contrat($id){

        // Affiche le formulaire d'edition d'un contrat

        $old_tarif_bat = TarificateurOldDevis::findorfail($id);


        return view('oldtarificateurbatiment.old_edition_contrat', compact('old_tarif_bat'));
    }
    public function old_edition_contrat_post($id){

        $tarif_bat = TarificateurOldDevis::findorfail($id);

        $add_status = request()->input('add_status');

        DB::table('old_devis')->where('id', $id)->update([
            'status' => $tarif_bat->status.$add_status
        ]);


        return redirect()->route('oldeditioncontrat', ['id' => $id]);
    }

    public function old_edition_contrat_post2($id){

        $tarif_bat = TarificateurOldDevis::findorfail($id);

        $add_status = request()->input('add_status');
        $periodicity = request()->input('in_periodicity');

        if (TarificateurOldDevis::search_status($_POST['add_status'], "30-")) {
            (float)$customer_cotisation = 0.00;
            (float)$marge = 0.00;
            (float)$cot = 0.00;
            $clauses = "";

            $product = unserialize($tarif_bat->data_product);

            if (TarificateurOldDevis::search_status($_POST['add_status'], "21-")) {
                $cot = $product['result_pno']['cotisation'];
                $formule = "OPTION PROPRIETAIRE NON OCCUPANT";
                $rc = $product['result_pno']['rc'];
                $clauses = $product['result_pno']['clauses'];
            } else if (TarificateurOldDevis::search_status($_POST['add_status'], "22-")) {
                $cot = $product['result_eco']['cotisation'];
                $formule = "OPTION ECO";
                $rc = $product['result_eco']['rc'];
                $clauses = $product['result_eco']['clauses'];
            } else if (TarificateurOldDevis::search_status($_POST['add_status'], "23-")) {
                $cot = $product['result_confort']['cotisation'];
                $formule = "OPTION CONFORT";
                $rc = $product['result_confort']['rc'];
                $clauses = $product['result_confort']['clauses'];
            } else if (TarificateurOldDevis::search_status($_POST['add_status'], "24-")) {
                $cot = $product['result_prestige']['cotisation'];
                $formule = "OPTION PRESTIGE";
                $rc = $product['result_prestige']['rc'];
                $clauses = $product['result_prestige']['clauses'];
            } else if (TarificateurOldDevis::search_status($_POST['add_status'], "28-")) {
                $cot = $product['result_pne']['cotisation'];
                $formule = "OPTION PNE";
                $rc = $product['result_pne'];
                $clauses = $product['result_pne'];
            } else {
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
        $calcul_customer_amount = TarificateurOldDevis::calcul_customer_amount($cot, $product['in_marge']);
        $calcul_partner_amount = TarificateurOldDevis::calcul_partner_amount($cot);
        $calcul_affiliate_amount =TarificateurOldDevis::calcul_affiliate_amount($cot, $product['in_marge']);


        DB::table('old_devis')->where('id', $id)->update([
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
            'clauses' => TarificateurOldDevis::clean_clauses($clauses),
        ]);

        return redirect()->route('oldeditioncontrat', ['id' => $id]);
    }
}

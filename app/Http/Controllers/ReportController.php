<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TarificateurBatiment;
use DB;
use App\Models\TarificateurOldDevis;

class ReportController extends Controller
{
    public function show(){

        $tarificateur_batiments = TarificateurBatiment::where('tarificateur_amount', '>', 0)->get();
        $tarificateur_batiments_old_devis = TarificateurOldDevis::where('tarificateur_amount', '>', 0)->get();

        // dd($tarificateur_batiments->first()->data_proposant['in_customer_prenom']);
        //  dd($tarificateur_batiments->first()->calculations);
        // $proposant['in_customer_prenom']
        $tarificateur_batiments_records = [$tarificateur_batiments, $tarificateur_batiments_old_devis];


        return view('admin.report', compact(['tarificateur_batiments_records']));
    }
}

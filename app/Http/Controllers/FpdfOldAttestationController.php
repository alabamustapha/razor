<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Input;
use DB;

class FpdfOldAttestationController extends Controller
{
    protected $pdf;

    public function __construct(\App\Models\PdfAttestation $pdf)
    {
        $this->pdf = $pdf;
    }


    ///// Ajouter l'indice de base /////
    /// Gerer le code postal /////
    public function oldattestationpdf(){

        function type_to_label($type_product)
        {
            if ($type_product == 1)
                return "habitation";
            else if ($type_product == 2)
                return "batiment";
            else if ($type_product == 3)
                return "pne";
            else
                return "N/A";
        }
        function display_id_contrat($value)
        {
            if ($value < 10)
                return "PR00000".$value;
            else if ($value < 100)
                return "PR0000".$value;
            else if ($value < 1000)
                return "PR000".$value;
            else if ($value < 10000)
                return "PR00".$value;
            else if ($value < 100000)
                return "PR0".$value;
            else
                return "PR".$value;
        }
        function display_date_from_status($all_status, $status)
        {
            $tmp = explode(";", $all_status);
            for($i = 0; $i < sizeof($tmp) -1; $i++)
            {
                $tmp2 = explode("-", $tmp[$i]);
                if ($tmp2[0] == $status)
                    return date("d/m/Y", $tmp2[1]);
            }
            return "";
        }

        $id_devis = Input::get('id');



        /////// Requete ///////////

        $devis = DB::table('old_devis')->where('id', $id_devis)->get();
        $indice_de_base = DB::table('indices')->where('id','=',1)->get();
        //$test = $devis[0]->affiliate_firstname;
        //$date_an = $devis[0]->date_creation;
        $proposant = unserialize($devis[0]->data_proposant);
        $product = unserialize($devis[0]->data_product);

        new FPDF('P', 'mm', 'A4');

        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->SetFillColor(255,255,255);

//---------------------------------------------------------------------------//
//----------------------------------LE PROPOSANT-----------------------------//
//---------------------------------------------------------------------------//

        $this->pdf->MultiCell(190,10,strtoupper('assurance '.type_to_label($devis[0]->type_product)),0,'C');
        $this->pdf->Ln();
        $this->pdf->Cell(95,5,utf8_decode("Contrat n°".display_id_contrat($devis[0]->id_contrat)." sur devis n°").$devis[0]->id."",0,0,'L',true);
        $this->pdf->Cell(95,5,''.$proposant['in_customer_sigle'].' '.$proposant['in_customer_prenom'].' '.$proposant['in_customer_nom'].'     ',0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(95,5,utf8_decode("Date d'effet ".date("d/m/Y",$devis[0]->date_contract).""),0,0,'L',true);
        $this->pdf->Cell(95,5,''.$proposant['in_customer_adresse'].'     ',0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(190,5,''.$proposant['in_customer_codepostal'].' '.$proposant['in_customer_ville'].'     ',0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(95,5,utf8_decode('par '.$devis[0]->affiliate_lastname.' '. $devis[0]->affiliate_firstname),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(95,5,utf8_decode('pour '.$devis[0]->affiliate_company),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(95,5,''.$devis[0]->affiliate_address,0,0,'L',true);
        $this->pdf->Cell(95,5,utf8_decode("Adresse du risque :"),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(95,5,utf8_decode(''. $devis[0]->affiliate_city.' '. $devis[0]->affiliate_zip),0,0,'L',true);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->Cell(95,5,$proposant['in_risk_adresse'],0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(95,5,utf8_decode('n° ORIAS : '. $devis[0]->affiliate_orias),0,0,'L',true);
        $this->pdf->SetFont('Arial','',9);
        if ($devis[0]->type_product == 1){
            if (($product['in_coef_zone'] + 1) < 10)
                $codepostal_risque = '0'.($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];
            else
                $codepostal_risque = ($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];

            $this->pdf->Cell(95,5,''.$codepostal_risque.' '.$proposant['in_risk_ville'].'',0,0,'R',true);
            $this->pdf->Ln();
        }else if ($devis[0]->type_product == 2){
            if (($product['in_coef_zone'] + 1) < 10)
                $codepostal_risque = '0'.($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];
            else
                $codepostal_risque = ($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];

            $this->pdf->Cell(95,5,$codepostal_risque .' '.$proposant['in_risk_ville'].'',0,0,'R',true);
            $this->pdf->Ln();
        }else if (($devis[0]->type_product == 3)){

            $this->pdf->Cell(95,5,$proposant['in_risk_ville'].'',0,0,'R',true);
            $this->pdf->Ln();
        }
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(45,5,'Tel : '. $devis[0]->affiliate_tel,0,0,'L',true);
        $this->pdf->Ln(10);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(190,5,'Paris, le '.display_date_from_status($devis[0]->status, 30).'     ',0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Ln();

        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->MultiCell(190,5,utf8_decode("Nous soussignés attestons par  la présente que :"),0,false);
        $this->pdf->SetXY(10,$y + 15);
        $this->pdf->Cell(60,5,utf8_decode("   - L'assuré(e) :"),0,0,'L',true);
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(130,5,"".$proposant['in_customer_sigle']." ".$proposant['in_customer_prenom']." ".$proposant['in_customer_nom']."",0,0,'L',true);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->Ln();
        $this->pdf->Cell(60,5,utf8_decode("   - A souscrit :"),0,0,'L',true);
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(130,5,utf8_decode("Contrat assurance ".type_to_label($devis[0]->type_product)." n°".display_id_contrat($devis[0]->id_contrat).""),0,0,'L',true);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->Ln();
        $this->pdf->Cell(60,5,utf8_decode("   - Pour un risque :"),0,0,'L',true);
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(130,5,"".$proposant['in_risk_adresse']." ".$codepostal_risque.' '. $proposant['in_risk_ville']."",0,0,'L',true);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->Ln();
        $this->pdf->Cell(60,5,utf8_decode("   - Auprès compagnie :"),0,0,'L',true);
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(130,5,"CMAM",0,0,'L',true);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->Ln();
        $this->pdf->Cell(60,5,utf8_decode("   - Période :"),0,0,'L',true);
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(130,5,"".date("d/m/Y", $devis[0]->date_contract)." au ".date("d/m/", $devis[0]->date_contract)."".(date("Y", $devis[0]->date_contract) + 1)."",0,0,'L',true);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->Ln();
        $this->pdf->Cell(60,5,"   - Indice FNB de souscription :",0,0,'L',true);
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(130,5,"".$indice_de_base[0]->valeur."",0,0,'L',true);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->Ln();

        $this->pdf->Ln();
        $this->pdf->Ln();
        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->MultiCell(190,5,utf8_decode("Ce contrat garantit les biens immobiliers ainsi que la Responsabilité Civile occupant dans les limites prévues aux conditions générales et particulières dudit contrat.\n\nLa présente attestation ne peut engager la Compagnie en dehors des limites précisées par les clauses et conditions du contrat auquel elle se réfère. Sa validité est subordonnée à l'encaissement effectif de la prime correspondant à la période pour laquelle elle est délivrée.\n\n\nPour servir et valoir ce que de droit."),0,false);
        $this->pdf->Ln(10);

//---------------------------------------------------------------------------//
//---------------------------------SIGNATURE---------------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->Ln(35);
        $this->pdf->Image(storage_path() .'../../public/images/signature.png',135,230,30);
        $this->pdf->Cell(190,1,utf8_decode("                                                                                           Le président"),0,0,'C',true);
        $this->pdf->Ln(10);

//---------------------------------------------------------------------------//
//---------------------------------OUTPUT------------------------------------//
//---------------------------------------------------------------------------//

        $this->pdf->Output();

    }
}

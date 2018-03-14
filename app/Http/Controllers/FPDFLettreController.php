<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Input;
use DB;

class FPDFLettreController extends Controller
{

    protected $pdf;

    public function __construct(\App\Models\PdfLettre $pdf)
    {
        $this->pdf = $pdf;
    }
    function letttrepdf(){


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
        function format_tarif($value)
        {
            return sprintf('%.2f',round($value, 2));
        }

        $id_devis = Input::get('id');

        $devis = DB::table('devis')->where('id', $id_devis)->get();
        $date_an = $devis[0]->date_creation;
        $proposant = unserialize($devis[0]->data_proposant);
        $product = unserialize($devis[0]->data_product);

        new FPDF('P', 'mm', 'A4');

        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Cell(95,5,utf8_decode("Contrat n°".display_id_contrat($devis[0]->id_contrat)." sur devis n°".$devis[0]->id.""),0,0,'L',true);
        $this->pdf->Cell(95,5,utf8_decode(''.$proposant['in_customer_sigle'].' '.$proposant['in_customer_prenom'].' '.$proposant['in_customer_nom'].'     '),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(95,5,"Date d'effet ".date("d/m/Y", $devis[0]->date_contract)."",0,0,'L',true);
        $this->pdf->Cell(95,5,utf8_decode(''.$proposant['in_customer_adresse'].'     '),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(95,5,utf8_decode(strtoupper('assurance '.type_to_label($devis[0]->type_product))),0,0,'L',true);
        $this->pdf->Cell(95,5,''.$proposant['in_customer_codepostal'].' '.$proposant['in_customer_ville'].'     ',0,0,'R',true);
        $this->pdf->Ln();

        if (utf8_decode($proposant['in_risk_occupant']) == 1)
            $occupation = "avec occupation";
        else
            $occupation = "sans occupation";
        $this->pdf->Cell(95,5,utf8_decode(strtoupper($proposant['in_risk_naturerisque'].' '.$occupation)),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Cell(95,5,"Adresse du risque :",0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(95,5,utf8_decode($proposant['in_risk_adresse']),0,0,'L',true);
        $this->pdf->Ln();

        if ($devis[0]->type_product == 1){
            if (($product['in_coef_zone'] + 1) < 10)
                $codepostal_risque = '0'.($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];
            else
                $codepostal_risque = ($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];

            $this->pdf->Cell(95,5,''.$codepostal_risque.' '.$proposant['in_risk_ville'].'',0,0,'L',true);
            $this->pdf->Ln();
        }else if ($devis[0]->type_product == 2){
            if ($product['in_coef_zone'] <= 9){
                $coef_zone = '0'.$proposant['in_risk_codepostal'];
            }
            else{
                $coef_zone = $proposant['in_risk_codepostal'];

            }

            $this->pdf->Cell(95,5,utf8_decode($coef_zone .' '.$proposant['in_risk_ville'].''),0,0,'L',true);
            $this->pdf->Ln();
        }else if ($devis[0]->type_product == 4){
            if ($product['in_coef_zone'] <= 9){
                $coef_zone = '0'.$proposant['in_risk_codepostal'];
            }
            else{
                $coef_zone = $proposant['in_risk_codepostal'];

            }

            $this->pdf->Cell(95,5,utf8_decode($proposant['in_risk_codepostal'] .' '.$proposant['in_risk_ville'].''),0,0,'L',true);
            $this->pdf->Ln();
        }else if (($devis[0]->type_product == 3)){

            $this->pdf->Cell(95,5,$proposant['in_risk_ville'].'',0,0,'L',true);
            $this->pdf->Ln();
        }
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Cell(190,5,'Paris, le '.display_date_from_status($devis[0]->status, 30).'     ',0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Ln();

        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->MultiCell(190,5,utf8_decode("Nous vous remettons sous ce pli votre contrat d'assurance que vous avez bien voulu souscrire auprès de notre société.\n"),0,false);
        $this->pdf->Ln(10);
        $this->pdf->Ln();

        $this->pdf->SetFont('Arial','B',10);

        if ($devis[0]->periodicity == 1)
            $this->pdf->Cell(190,5,utf8_decode('Cotisation annuelle, soit 1 prélévement de '.format_tarif($devis[0]->customer_amount).' '),0,0,'C',true);
        else if ($devis[0]->periodicity == 2)
            $this->pdf->Cell(190,5,utf8_decode('Cotisation semestrielle, soit 2 prélevéments de '.format_tarif($devis[0]->customer_amount / 2).'  pour un total de '.format_tarif($devis[0]->customer_amount).' '),0,0,'C',true);
        else if ($devis[0]->periodicity == 4)
            $this->pdf->Cell(190,5,utf8_decode('Cotisation trimestrielle, soit 4 prélevéments de '.format_tarif($devis[0]->customer_amount / 4).'  pour un total de '.format_tarif($devis[0]->customer_amount).' '),0,0,'C',true);
        else
            $this->pdf->Cell(190,5,utf8_decode('Cotisation mensuelle, soit 12 prélevéments de '.format_tarif($devis[0]->customer_amount / 12).'  pour un total de '.format_tarif($devis[0]->customer_amount).' '),0,0,'C',true);

        $this->pdf->SetFont('Arial','',10);
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Ln();

        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->MultiCell(190,5,utf8_decode("Restant à votre entière disposition pour toute information complémentaire, nous vous prions de croire, cher sociétaire, en l'assurance de nos salutations dévouées.\n"),0,false);
        $this->pdf->Ln(10);

//---------------------------------------------------------------------------//
//---------------------------------SIGNATURE---------------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->Ln(50);
        $this->pdf->Image(storage_path() .'../../public/images/signature.png',135,200,30);
        $this->pdf->Cell(190,5,utf8_decode("                                                                                           Le président"),0,0,'C',true);
        $this->pdf->Ln(10);

//---------------------------------------------------------------------------//
//---------------------------------OUTPUT------------------------------------//
//---------------------------------------------------------------------------//




        $this->pdf->Output();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Codedge\Fpdf\Fpdf\Fpdf;

class PdfAttestation extends Fpdf
{
    public function header(){

        $this->Image(storage_path() .'../../public/images/logotop.png',10,6,22);

        $this->SetXY($this->GetX()+110,$this->GetY()-2);

        $this->SetFont('Arial','',9);
        $this->MultiCell(80,4,"\n \n",0,'R');
        // $this->MultiCell(80,4,"Société nationale de courtage d'assurance\n37, Rue des Mathurins - 75008 Paris\nTel : 0144700382 Web : http://www.residassur.fr",0,'R');
        $this->Ln();
        $this->SetFont('Arial','B',15);
        // Décalage à droite
        $this->Cell(80);
        // Titre
        $this->Cell(30,10,'Attestation d\'assurance',0,0,'C');
        // Saut de ligne
        $this->Ln();
    }
    function Table_entete($data)
    {
        $this->Ln(7);
        $this->SetFont('Arial','B',10);
        $this->SetFillColor(242,129,55);
        $this->Cell(190,5,$data,1,0,'L',true);
        $this->SetFillColor(255,255,255);
        $this->SetFont('Arial','',10);
        $this->Ln();
    }

    public function footer(){
        $this->SetY(-20);
        // Police Arial italique 8
        $this->SetFont('Arial','I',8);
        // Numéro de page
        $this->Cell(0,5,"Page ".$this->PageNo()."/{nb}",0,0,'C');
        $this->SetFont('Arial','',8);
        $this->Ln();
        $this->MultiCell(190,3,utf8_decode("RESIDASSUR est une marque déposée de la Société GROUPE CORIM ASSURANCES SAS au capital de 132 501 euros,\nSociété nationale de courtage d'assurances régie par le Codes des Assurances,\nGarantie Financière et Assurance de Responsabilité Civile conformes aux articlesL 530-1 et L 530-2 du Code des Assurances.\nSiège social : 37 Rue des Mathurins - 75008 Paris - Tel : 0806 079 879  RCS PARIS 794 514 927  n° ORIAS : 13008124  www.orias.fr"),0, 'C', false);
    }
}

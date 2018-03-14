<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Input;
use DB;

class FPDFAutorisationController extends Controller
{
    protected $pdf;

    public function __construct(\App\Models\PdfAutorisation $pdf)
    {
        $this->pdf = $pdf;
    }

    public function autorisationpdf(){


        new FPDF('P', 'mm', 'A4');

        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/MANDAT-SEPA1.png',0,0,210);

        $this->pdf->Output();
    }
}

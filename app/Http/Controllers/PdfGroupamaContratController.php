<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Input;
use DB;

class PdfGroupamaContratController extends Controller
{
    protected $pdf;

    public function __construct(\App\Models\PdfGroupamaContrat $pdf)
    {
        $this->pdf = $pdf;
        
        
    }
    
    public function contrat_groupama_pdf(){
    
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
        function format_tarif($value)
        {
            return sprintf('%.2f',round($value, 2));
        }

        $id_devis = Input::get('id');

        $devis = DB::table('devis')->where('id', $id_devis)->get();
        $indice_de_base = DB::table('indices')->where('id','=',1)->get();

        //$test = $devis[0]->affiliate_firstname;
        $date_an = $devis[0]->date_creation;
        $proposant = unserialize($devis[0]->data_proposant);
        $product = unserialize($devis[0]->data_product);
        $clauses = $devis[0]->clauses;

        new FPDF('P', 'mm', 'A4');
        
        $this->pdf->AliasNbPages();
        
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial','B',15);
        $this->pdf->SetFillColor(255,255,255);

    //---------------------------------------------------------------------------//
    //----------------------------------LE PROPOSANT-----------------------------//
    //---------------------------------------------------------------------------//
        $this->pdf->MultiCell(124,10,utf8_decode("Multirisque Immeuble"),0,0,'C');
        $this->pdf->Ln();

        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(95,5,' par '.$devis[0]->affiliate_lastname.' '. $devis[0]->affiliate_firstname,0,0,'L',true);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(95,5,utf8_decode(''.$proposant['in_customer_sigle'].' '.$proposant['in_customer_prenom'].' '.$proposant['in_customer_nom'].'     '),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(95,5,utf8_decode(' pour '.$devis[0]->affiliate_company),0,0,'L',true);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(95,5,utf8_decode(''.$proposant['in_customer_adresse'].'     '),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(95,5,utf8_decode(' '.$devis[0]->affiliate_address),0,0,'L',true);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(95,5,utf8_decode(''.$proposant['in_customer_codepostal'].' '.$proposant['in_customer_ville'].'     '),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(45,5,utf8_decode(' '. $devis[0]->affiliate_city.' '. $devis[0]->affiliate_zip),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(45,5,utf8_decode(' n?? ORIAS : '. $devis[0]->affiliate_orias),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(45,5,' Tel : '. $devis[0]->affiliate_tel,0,0,'L',true);
        $this->pdf->Ln();
        if (!empty($devis[0]->affiliate_ref)){
            $this->pdf->Cell(80,5,utf8_decode(' R??f??rence affili?? : '.$devis[0]->affiliate_ref),0,0,'L',true);
        }else{

        }

        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(190,5,utf8_decode("Contrat n??".display_id_contrat($devis[0]->id_contrat)." sur devis n??".$devis[0]->id.""),0,0,'R',true);
        $this->pdf->Ln(5);


        $this->pdf->Table_entete(utf8_decode("Conditions particuli??res"));
        $this->pdf->Cell(190,5,utf8_decode("Ce document a ??t?? ??tabli sur la base de vos d??clarations et concr??tise nos engagements r??ciproques."),0,0,'L',true);
        $this->pdf->Ln(3);
        $this->pdf->Table_entete(utf8_decode("Description du risque assur??"));
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Situation du risque :",0,0,'L',true);
        $this->pdf->Cell(95,5,utf8_decode($proposant['in_risk_adresse']),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"",0,0,'L',true);
        if ($product['in_coef_zone'] <= 9){
                $coef_zone = $proposant['in_risk_codepostal'];
            }
            else{
                $coef_zone = $proposant['in_risk_codepostal'];

            }

        $this->pdf->Cell(95,5,''.$coef_zone.' '.$proposant['in_risk_ville'].'',0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,utf8_decode("R??sidence :"),0,0,'L',true);
        $this->pdf->Cell(65,5,utf8_decode($proposant['in_risk_residence']),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Type d'habitation :",0,0,'L',true);
        $this->pdf->Cell(65,5,utf8_decode($proposant['in_risk_naturerisque']),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(45,5,utf8_decode("Surface d??velopp??e en m?? :"),0,0,'L',true);
        $this->pdf->Cell(65,5,$product['in_nombre_surface'],0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,utf8_decode("Ann??e de construction :"),0,0,'L',true);
        if($product['in_coef_annee_construction'] == 0){
            $coef_annee_constructio = "Ant??rieure ?? 1980";
        } else if($product['in_coef_annee_construction'] == 1){
            $coef_annee_constructio = "Post??rieure ?? 1980";
        }
        $this->pdf->Cell(65,5, utf8_decode($coef_annee_constructio), 0,0,'L',true);
        $this->pdf->Ln();
        //---------------------------------------------------------------------------//
        //-----------------------------------Calcul-------------------------------//

          $incendie_repart = 0.3;
          $autre_dommage_repart = 0.55;
          $rc_proprietaire = 0.15;

        
          
          $pj_nette = 50;
          $rc_nette = ($product['in_nombre_surface'] * 0.05) / 10;
          $contribution_fond_attentats_nette = 0;
          
          $pj_taxes = $pj_nette * 0.09;
          $rc_taxes = $rc_nette * 0.09;
          $contribution_fond_attentats_taxes = 5.9;

          $incendie_nette = ((($devis[0]->customer_amount - $pj_nette - $rc_nette - $pj_taxes - $rc_taxes - $contribution_fond_attentats_taxes) * $incendie_repart) / (1.27808));
          $autre_nette = ((($devis[0]->customer_amount - $pj_nette - $rc_nette - $pj_taxes - $rc_taxes - $contribution_fond_attentats_taxes) * $autre_dommage_repart) / (1.27808));
          $rc_proprietaire_nette = ((($devis[0]->customer_amount - $pj_nette - $rc_nette - $pj_taxes - $rc_taxes - $contribution_fond_attentats_taxes) * $rc_proprietaire) / (1.27808));
          $incendie_taxes = $incendie_nette * 0.30;
          $autre_taxes = $autre_nette * 0.09;
          $rc_proprietaire_taxes = $rc_proprietaire_nette * 0.09;


          $total_ht_hors_cat_et_attentats_gareat = $incendie_nette + $autre_nette + $rc_proprietaire_nette + $pj_nette + $rc_nette + $contribution_fond_attentats_nette;
          $catastrophe_naturelles = ($incendie_nette + $autre_nette) * 0.12 ;
          $attentats = ($incendie_nette + $autre_nette) * 0.015;

          $total_ht = $total_ht_hors_cat_et_attentats_gareat + $catastrophe_naturelles + $attentats;




        //---------------------------------------------------------------------------//
        $this->pdf->Table_entete(utf8_decode("El??ments de cotisation"));
        $this->pdf->Ln();
        $this->pdf->Cell(50,5,"Date et heure d'effet :",0,0,'L',true);
        $this->pdf->Cell(60,5,utf8_decode(date("d/m/Y ?? 00:00", $devis[0]->date_contract)),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(50,5,utf8_decode("Ech??ance principale :"),0,0,'L',true);
        $this->pdf->Cell(60,5,date("d/m", $devis[0]->date_contract),0,0,'L',true);
        $this->pdf->Ln();

        $this->pdf->Cell(50,5,"Type de paiement :",0,0,'L',true);
        if ($devis[0]->periodicity == 1)
            $this->pdf->Cell(60,5,"Annuel",0,0,'L',true);
        else if ($devis[0]->periodicity == 2)
            $this->pdf->Cell(60,5,"Semestriel",0,0,'L',true);
        else if ($devis[0]->periodicity == 4)
            $this->pdf->Cell(60,5,"Trimestriel",0,0,'L',true);
        else
            $this->pdf->Cell(60,5,"Mensuel",0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(50,5,"Indice de base FNB :",0,0,'L',true);
        $this->pdf->Cell(60,5,$indice_de_base[0]->valeur,0,0,'L',true);
        $this->pdf->Ln();
        /*
        //-------------------------------------Test HT COMPLET--------------------------------------//
        //-------------------------------------test taxe--------------------------------------//
        $this->pdf->Cell(40,5,"Test pj taxe :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($pj_taxes).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Test rc taxe :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($rc_taxes).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Test inc taxe :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($incendie_taxes).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        //----------------------------------test nette-----------------------------------------//
        $this->pdf->Cell(40,5,"Test inc nette :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($incendie_nette).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Test rc nette :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($rc_nette).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Test autre nette :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($autre_nette).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Test rc propri nette :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($rc_proprietaire_nette).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        //---------------------------------Test resultat hors taxe------------------------------------------//
        $this->pdf->Cell(40,5,"Test catastrophe :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($catastrophe_naturelles).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Test attentats :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($attentats).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Test total ht hors cat :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($total_ht_hors_cat_et_attentats_gareat).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        //---------------------------------------------------------------------------//
        */
        $this->pdf->Cell(40,5,"Cotisation HT annuelle :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($total_ht).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Cotisation TTC annuelle :",0,0,'L',true);
        $this->pdf->Cell(27,5,format_tarif($devis[0]->customer_amount).chr(128),0,0,'R',true);
        $this->pdf->Ln();

        $this->pdf->SetFont('Arial','B',10);

        if ($devis[0]->periodicity == 1)
        {
            $this->pdf->Cell(91,5,utf8_decode('Cotisation TTC ?? percevoir pour la premi??re p??riode :'),0,0,'R',true);
            $this->pdf->Cell(20,5,format_tarif($devis[0]->customer_amount).chr(128),0,0,'R',true);
            $this->pdf->Ln();
            $this->pdf->SetFont('Arial','',10);
            
        }
        else if ($devis[0]->periodicity == 2)
        {
            $this->pdf->Cell(91,5,utf8_decode('Cotisation TTC ?? percevoir pour la premi??re p??riode :'),0,0,'R',true);
            $this->pdf->Cell(20,5,format_tarif(($devis[0]->customer_amount) / 2).chr(128),0,0,'R',true);
            $this->pdf->Ln();
            $this->pdf->SetFont('Arial','',10);
            $this->pdf->Cell(40,5,utf8_decode('Soit 2 r??glements de :'),0,0,'L',true);
            $this->pdf->Cell(27,5,format_tarif(($devis[0]->customer_amount) / 2).chr(128),0,0,'R',true);
            $this->pdf->Ln();
        }
        else if ($devis[0]->periodicity == 4)
        {
            $this->pdf->Ln();
            $this->pdf->Cell(91,5,utf8_decode('Cotisation TTC ?? percevoir pour la premi??re p??riode :'),0,0,'R',true);
            $this->pdf->Cell(20,5,format_tarif(($devis[0]->customer_amount) / 4).chr(128),0,0,'R',true);
            $this->pdf->Ln();
            $this->pdf->SetFont('Arial','',10);
            $this->pdf->Cell(40,5,utf8_decode('Soit 4 r??glements de :'),0,0,'L',true);
            $this->pdf->Cell(27,5,format_tarif(($devis[0]->customer_amount) / 4).chr(128),0,0,'R',true);
            $this->pdf->Ln();
        }
        else
        {
            $this->pdf->Cell(91,5,utf8_decode('Cotisation TTC ?? percevoir pour la premi??re p??riode :'),0,0,'R',true);
            $this->pdf->Cell(20,5,format_tarif(($devis[0]->customer_amount) / 12).chr(128),0,0,'R',true);
            $this->pdf->Ln();
            $this->pdf->SetFont('Arial','',10);
            $this->pdf->Cell(40,5,utf8_decode('Soit 12 r??glements de :'),0,0,'L',true);
            $this->pdf->Cell(27,5,format_tarif(($devis[0]->customer_amount) / 12).chr(128),0,0,'R',true);
            $this->pdf->Ln();
        }
        $this->pdf->Cell(60,5,"Dont frais de gestion et de courtage :",0,0,'L',true);
        $this->pdf->Cell(20,5,format_tarif($devis[0]->affiliate_amount).chr(128),0,0,'R',true);
        $this->pdf->Ln();
        //---------------------------------------------------------------------------//
        //-----------------------------------GARANTIES-------------------------------//
        //---------------------------------------------------------------------------//
        $this->pdf->AddPage();
        $this->pdf->Table_entete("Garanties souscrites");

        $this->pdf->Ln();
        $this->pdf->Cell(115,7,utf8_decode("Libell?? de la garantie"),1,0,'C',true);
        $this->pdf->Cell(25,7,"Statut",1,0,'C',true);
        $this->pdf->Cell(25,7,"Plafond",1,0,'C',true);
        $this->pdf->Cell(25,7,"Franchise",1,0,'C',true);
        $this->pdf->Ln();


        function format_garantie_reverse($value, $seuil = -1)
        {
            if ($value == $seuil)
                return "Garanti";
            else
                return "Exclu";
        }

        $this->pdf->Add_garantie(utf8_decode("GARANTIES DE BASE"),"","","");
        $this->pdf->Add_garantie(utf8_decode("- Incendie - foudre - explosions"),"Garanti","TG et TI (1)",utf8_decode("N??ant"));
        $this->pdf->Add_garantie(utf8_decode("- Risques ??lectriques"),"Garanti","TG et TI (1)","0.50 x indice");
        $this->pdf->Add_garantie(utf8_decode("- Temp??tes - gr??le - poids neige"),"Garanti","TG et TI (1)",utf8_decode("N??ant"));
        $this->pdf->Add_garantie(utf8_decode("- Bris de vitres et glaces"),format_garantie_reverse($product['in_coef_minorations_possibles_2']),"TG et TI (1)",utf8_decode("N??ant"));

        $this->pdf->Add_garantie("GARANTIES FACULTATIVES","","","");
        $this->pdf->Add_garantie(utf8_decode("- D??g??ts des eaux"),format_garantie_reverse($product['in_coef_minorations_possibles_1']),"TG et TI (1)",utf8_decode("N??ant"));
        $this->pdf->Add_garantie("- Vol et vandalisme ",format_garantie_reverse($product['in_coef_minorations_possibles_0']),"TG et TI (1)",utf8_decode("N??ant"));
        $this->pdf->Add_garantie("GARANTIES LEGALES","","","");
        $this->pdf->Add_garantie("- Catastrophes naturelles","Garanti","TG et TI (1)",utf8_decode("franchise l??gale"));
        $this->pdf->Add_garantie("- Attentats","Garanti","TG et TI (1)","0.50 x indice");
        $this->pdf->Add_garantie("TITRE VIII - RESPONSABILITES CIVILES","","","");
        $this->pdf->Add_garantie("- RC Immeuble","Garanti","TG et TI (1)",utf8_decode("N??ant"));
        $this->pdf->Add_garantie(utf8_decode("- D??fense civile et recours"),"Garanti","TG et TI (1)",utf8_decode("N??ant"));
        $this->pdf->Add_garantie("- Protection juridique","Garanti","TG et TI (1)",utf8_decode("N??ant"));

        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->MultiCell(190,5,utf8_decode("
(1) On entend par : 
- TG le tableau des garanties module VITALIA P-1003-06/2009
- TI  l'intercalaire GSA14192017"));

        //---------------------------------------------------------------------------//
        //-----------------------------------DISPOSITIONS----------------------------//
        //---------------------------------------------------------------------------//
        $this->pdf->Table_entete(utf8_decode("Dispositions particuli??res"));
        $this->pdf->Ln();

        $this->pdf->SetFont('Arial','',9);

        $this->pdf->Cell(50,5,utf8_decode("AUTORITE DE CONTR??LE :"),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->MultiCell(183,5,utf8_decode("L'autorit?? charg??e du contr??le de la Soci??t?? est :
Autorit?? de contr??le prudentiel et de r??gulation - 61, rue Taitbout - 75009 PARIS."),0,false);
        $this->pdf->Ln();
        $this->pdf->Cell(50,5,"LE SOUSCRIPTEUR DECLARE :",0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->MultiCell(183,5,
            utf8_decode("- Que les d??clarations qui constituent la base du contrat sont ?? sa connaissance exactes en sachant que toute omission ou fausse d??claration peut entra??ner les sanctions pr??vues aux articles L113-8 (nullit?? du contrat) et L113-9 (r??duction des indemnit??s) du Code des assurances.
- Savoir que, conform??ment ?? la loi INFORMATIQUE et LIBERTES du 06 janvier 1978, le soci??taire a le droit d'acc??s et de rectification pour toutes les informations le concernant sur les fichiers des soci??t??s GROUPAMA RHONE ALPES AUVERGNE et CFDP en s'adressant ?? leur si??ge.
- Outre les exclusions mentionn??es aux dispositions g??n??rales et aux conditions particuli??res de votre contrat, est exclue, toute responsabilit??, r??elle ou pr??tendue, aff??rente ?? des sinistres directement ou indirectement dus ou caus??s par l'amiante et/ou le plomb ou par tout mat??riau contenant de l'amiante et/ ou du plomb sous quelque forme et en quantit?? que ce soit.
- Que les biens a assurer ne se situent pas dans un b??timent de plus de 28 m??tres de hauteur.
- Que le b??timent assur?? n'est ni un chateau ni un b??timent inoccup??.
- Qu'il n'a pas connaissance de faits dommageables survenus avant la r??daction du pr??sent document engageant sa responsabilit?? civile et susceptibles de faire l'objet d'une r??clamation par un tiers. Il n'a aucun litige en cours avec un tiers.
- Qu'il a bien ??t?? inform?? que toute modification intervenant dans son immeuble (en mati??re de capitaux ou d'aggravation) doit faire l'objet d'une d??claration aupr??s de son assureur afin de lui apporter le conseil et les modifications n??cessaires ?? son contrat.
"),0,false);

        $this->pdf->AddPage();
        $this->pdf->Ln(10);
        $this->pdf->MultiCell(183,5,
            utf8_decode("- Que le b??timent est construit ?? plus de 50 % en mat??riaux durs et couvert ?? plus de 90 % en mat??riauxriaux durs tels que d??finis aux conditions g??n??rales de votre contrat.
- Que les b??timents assur??s ou abritant les objets assur??s peuvent renfermer une activit?? professionnelle. Cette activit?? ne peut pas occuper plus du quart du volume du b??timent assur??.
- Que le b??timent assure?? n'est pas class?? monument historique ou r??pertori?? ?? l'inventaire des b??timents de France - Que le risque assur?? est en bon ??tat d'entretien et qu'il s'engage ?? le maintenir dans ce bon ??tat d'entretien.
- Que les biens ?? assurer ne sont pas contigus ou voisins avec des risques aggravant ou n'en abritent pas tels que: discoth??que, travail du bois, plasturgie, lieux de culte ou politique...
- Avoir re??u la fiche d'information sur le fonctionnement de la garantie responsabilit?? civile dans le temps r??f FIRC1103.
- Concernant les garanties des catastrophes technologiques, conform??ment ?? la loi n?? 2003-699 du 30 juillet 2003 et aux articles
L128-1 et suivants du code des assurances, nous garantissons les dommages mat??riels subis par vos biens mobiliers et immobiliers, ?? usage d'habitation, dans les limites pr??vues aux conditions particuli??res de votre contrat.
- Que sauf d??rogation, les locaux assur??s (ou renfermant les objets assur??s sontenti??rement clos, toutes les portes donnant acc??s sur l'ext??rieur poss??dent au moins deux moyens de fermeture (serrure plus verrou, 2 verrous, serrure multipoints), chaque ouverture du sous-sol et du rez-de-chauss??e est prot??g??e par des volets, des persiennes ou des barreaux.
Les locaux ne sont pas occup??s toute l'ann??e. La garantie VOL VANDALISME est accord??e pendant la p??riode d'inhabitation qui n'exc??de pas 6 mois."),0,false);
        $this->pdf->Ln(4);
        $this->pdf->Cell(5,5,"",0,0,'L',true);
        $x=$this->pdf->GetX(30);
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,180,70);
        $this->pdf->Ln(4);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(10,5,"",0,0,'L',false);
        $this->pdf->MultiCell(170,5,utf8_decode("LIMITATION CONTRACTUELLE D'INDEMNITE NON INDEXEE"),0,'C',false);
        $this->pdf->Ln(4);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(10,5,"",0,0,'L',false);
        $this->pdf->MultiCell(170,5,utf8_decode("D'un commun accord entre les parties, il est convenu qu'en cas de sinistre, le montant total des dommages pris en compte dans le calcul de l'indemnit?? due au titre du pr??sent contrat ne pourra
en aucun cas d??passer toutes d??penses et garanties confondues"),0,'C',false);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(10,5,"",0,0,'L',false);
        $this->pdf->MultiCell(170,5,"19.900.000".chr(128),0,'C',false);
        $this->pdf->Ln(3);
        $this->pdf->Cell(10,5,"",0,0,'L',false);
        $this->pdf->MultiCell(170,5,utf8_decode("Cette Limitation Contractuelle d'Indemnit??, s'applique quel que soit le nombre de ba??timents sinistr??s composant le risque*, l'importance du sinistre et son co??t, tant aux garanties de dommages que de responsabilit??s sans d??roger aux autres limitations et/ou sous - limitations pr??vues au titre du pr??sent contrat d'assurance."),0,'C',false);
        $this->pdf->Ln(3);
        $this->pdf->Cell(10,5,"",0,0,'L',false);
        $this->pdf->MultiCell(170,5,utf8_decode("* Ensemble de constructions et leur contenu composant une copropri??t?? ou une propri??t??"),0,'C',false);
        $this->pdf->SetXY($x,$y + 70);
        $this->pdf->Ln(10);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(190,5,utf8_decode("Le pr??sent contrat a ??t?? r??alis?? aupr??s de la soci??t?? GROUPAMA RHONE ALPES AUVERGNE, entreprise r??gie par le code des Assurances et sise 50 Rue de Saint Cyr, 69251 LYON Cedex 09 pour les garanties dommages et aupr??s de la soci??t?? CFDP, Compagnie d'Assurances sp??cialis??e en Protection Juridique, r??gie par le codes des Assurances et sise 1 Place Francisque Regaud, 69002 LYON pour la garantie Protection Juridique."),0,'L',false);
        $this->pdf->Ln(4);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->MultiCell(190,5,utf8_decode("Le pr??sent contrat est reconduit tacitement d'ann??e en ann??e, sauf r??siliation ?? l'??ch??ance annuelle, moyenne pr??avis de 2 mois minimum"),0,'L',false);


        //----------------------------------------------------------------------------------//
        //-----------------------------R??clamation et Litiges------------------------------//
        //--------------------------------------------------------------------------------//

        $this->pdf->AddPage();
        $this->pdf->SetLeftMargin(10,0);
        $this->pdf->Table_entete(utf8_decode("R??clamation et Litiges :"));
        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,190,40);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(24,5,utf8_decode("R??clamation:"),0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(158,5,utf8_decode("Toute r??clamation doit ??tre adress??e en premier lieu par courrier ou par e-mail ?? l'adresse suivante :"),0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(170,5, utf8_decode("Groupe corim assurance - Service r??clamations - 37, rue des Mathurins - 75008 Paris "),0,'C',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(125,5,utf8_decode("Email: reclamations@groupecorim.fr"),0,'C',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(15,5,utf8_decode("Litiges:"),0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(190,5,utf8_decode("Personne ou soci??t?? ?? qui devront ??tre signifi??s les actes judiciaires en cas de proc??dure contentieuse engag??e ?? l'encontre des Assureurs:"),0,false);
        $this->pdf->Cell(170,5,utf8_decode("GROUPE CORIM ASSURANCES - 37, rue des mathurins - 75008 PARIS - www.groupecorim.fr"),0,'C',true);
        $this->pdf->Ln();

        //----------------------------------------------------------------------------------//
        //-----------------------------Informations l??gales------------------------------//
        //--------------------------------------------------------------------------------//

        $this->pdf->Table_entete(utf8_decode("Informations l??gales :"));
        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,190,40);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(185,5,utf8_decode("Toutes omission ou d??claration inexacte vous expose ?? supporter tout ou partie des cons??quences d'un sinistre comme pr??cis?? \n aux articles L.113-8 (nullit?? du contrat) et L.113-9 (r??duction des indemnit??s) du Code des Assurances."),0,'L',false);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(50,5, utf8_decode("Loi << informatique et libert?? >>"),0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(190,5,utf8_decode("Les informations recueillies font l'objet d'un traitement informatique destin?? ?? g??rer vos contrats d'asurance souscrits par notre\n interm??diare. Les destinataires des donn??es sont le courtier souscripteur et la compagnie qui couvrent le risque.\n Conform??ment ?? la loi << informatique et libert??s >> du 6 janvier 1978 modifi??e en 2004, vous b??n??ficiez d'un droit d'acc??s et de \n rectification aux informations qui vous concernent, que vous pouvez exercer en nous adressant votres demande par mail."),0,false);

        //----------------------------------------------------------------------------//
        //---------------------------------SIGNATURE---------------------------------//
        //---------------------------------------------------------------------------//
        $this->pdf->Ln(6);
        $this->pdf->Cell(200,5,utf8_decode("Pour le soci??taire                                          Fait ??                                   , le                                            Pour la soci??t??"),0,0,'L',true);
        $this->pdf->Ln(5);
        $this->pdf->Cell(200,20,$this->pdf->Image(storage_path() .'../../public/images/signature.png',$this->pdf->GetX()+138,$this->pdf->GetY(),30),0,0,'L');

        //----------------------------------------------------------------------------//
        //---------------------------------Autre page---------------------------------//
        //---------------------------------------------------------------------------//
       
        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page1.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page2.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page3.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page4.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page5.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page6.png',0,0,210,310);
        
        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page7.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page8.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page9.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page10.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page11.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page12.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page13.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page14.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page15.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page16.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page17.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page18.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page19.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page20.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page21.png',0,0,210,310);

        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->Image(storage_path() .'../../public/images/page22.png',0,0,210,310);
        
        /////////////// OUTPUT ///////////////
        $this->pdf->Output();
    }
}

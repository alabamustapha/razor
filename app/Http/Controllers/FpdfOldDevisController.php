<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Input;
use DB;

class FpdfOldDevisController extends Controller
{
    protected $pdf;

    public function __construct(\App\Models\Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function olddevisbatpdf(){

        $coef_annee_construction = array(
            "designation" => array ("Antérieure à 1948",
                "Postérieure à 1948"),);

        function format_etat($value)
        {
            if ($value == -1)
                return "Non";
            else
                return "Oui";
        }

        function format_value($value)
        {
            if ($value > 0)
                return "Oui, ".$value."";
            else
                return "Non";
        }

        function clean_clauses($clauses)
        {
            $max = strlen($clauses);
            for($i = 0;$i < $max;$i++)
                $clauses = str_replace(",,", ",", $clauses);
            if (strlen($clauses) > 0 && $clauses[0] == ',')
                $clauses[0] = " ";
            if (strlen($clauses) > 0 && $clauses[strlen($clauses)-1] == ',')
                $clauses[strlen($clauses)-1] = " ";
            return trim(rtrim($clauses));
        }


        function format_tarif($value)
        {
            return sprintf('%.2f',round($value, 2));
        }




        $id_devis = Input::get('id');



        /////// Requete ///////////

        $devis = DB::table('old_devis')->where('id', $id_devis)->get();
        //$test = $devis[0]->affiliate_firstname;
        $date_an = $devis[0]->date_creation;
        $proposant = unserialize($devis[0]->data_proposant);
        $product = unserialize($devis[0]->data_product);

        if($product['in_coef_aggravation_occupation'] == 0){
            $coef_aggravation_occupation = 'Sans aggravation';
        }else if($product['in_coef_aggravation_occupation'] == 1){
            $coef_aggravation_occupation = 'Activité commerciale de 0 à 50 % SD totale';
        }else if($product['in_coef_aggravation_occupation'] == 2){
            $coef_aggravation_occupation = 'agricole et fourrage < 3 tonnes';
        }else if($product['in_coef_aggravation_occupation'] == 3){
            $coef_aggravation_occupation = 'agricole et fourrage > 10 tonnes';
        }else if($product['in_coef_aggravation_occupation'] == 4){
            $coef_aggravation_occupation = 'agricole et fourrage > 3 et < 10 tonnes';
        }else if($product['in_coef_aggravation_occupation'] == 5){
            $coef_aggravation_occupation = 'agricole sans fourrage';
        }else if($product['in_coef_aggravation_occupation'] == 6){
            $coef_aggravation_occupation = 'bouteilles de gaz de 8 à 30 maximum';
        }else if($product['in_coef_aggravation_occupation'] == 7){
            $coef_aggravation_occupation = 'liquides inflammables de 3000 à 8000 litres';
        }

        new FPDF('P', 'mm', 'A4');

        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255,255,255);
        if ($devis[0]->affiliate_lastname!="" && $devis[0]->affiliate_lastname!=null){
            $this->pdf->Ln(5);
            $this->pdf->SetFont('Arial','B',9);
            $this->pdf->Cell(35,5,utf8_decode('DEVIS n°'.$id_devis.' généré le '.date('d-m-Y', strtotime($date_an))),0,0,'L',true);
            $this->pdf->Ln();
            $this->pdf->Ln();
            $this->pdf->SetFont('Arial','',9);
            $this->pdf->Cell(35,5,utf8_decode(' par '.$devis[0]->affiliate_lastname.' '. $devis[0]->affiliate_firstname),0,0,'L',true);
            $this->pdf->Ln();
            $this->pdf->Cell(35,5,utf8_decode(' pour '.$devis[0]->affiliate_company),0,0,'L',true);
            $this->pdf->Ln();
            $this->pdf->Cell(45,5,utf8_decode(' '.$devis[0]->affiliate_address),0,0,'L',true);
            $this->pdf->Ln();
            $this->pdf->Cell(45,5,' '. utf8_decode($devis[0]->affiliate_city).' '. $devis[0]->affiliate_zip,0,0,'L',true);
            $this->pdf->Ln();
            $this->pdf->Cell(45,5,utf8_decode(' n° ORIAS :'. $devis[0]->affiliate_orias),0,0,'L',true);
            $this->pdf->Ln();
            if (!empty($devis[0]->affiliate_ref)){
                $this->pdf->Cell(80,5,utf8_decode('Référence affilié : ').$devis[0]->affiliate_ref,0,0,'L',true);
            }else{

            }


        }else {
            $this->pdf->Ln(40);
            $this->pdf->SetFont('Arial','B',9);
            $this->pdf->Cell(35,5,utf8_decode('DEVIS n°'.$id_devis.' généré le '.date('d-m-Y', strtotime($date_an))),0,0,'L',true);
        }
//---------------------------------------------------------------------------//
//----------------------------------LE PROPOSANT-----------------------------//
//---------------------------------------------------------------------------//




        $this->pdf->Table_entete("Le proposant :");

        $this->pdf->Cell(35,5,"Sigle et Nom :",1,0,'L',true);
        $this->pdf->Cell(60,5,utf8_decode(''.$proposant['in_customer_sigle'].' '.$proposant['in_customer_nom'].''),1,0,'L',true);
        $this->pdf->Cell(35,5,utf8_decode("Prénom :"),1,0,'L',true);
        $this->pdf->Cell(60,5,$proposant['in_customer_prenom'],1,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(35,5,"Date de naissance :",1,0,'L',true);
        $this->pdf->Cell(60,5,$proposant['in_customer_datedenaissance'],1,0,'L',true);
        $this->pdf->Cell(35,5,"Courriel :",1,0,'L',true);
        $this->pdf->Cell(60,5,$proposant['in_customer_courriel'],1,0,'L',true);
        $this->pdf->Ln();
        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,35,14);
        $this->pdf->MultiCell(35,5,"Adresse :\n",0,false);
        $this->pdf->SetXY($x+35,$y);
        $this->pdf->GetX();
        $this->pdf->GetY();
        $this->pdf->Rect($x,$y,190,14);
        $this->pdf->MultiCell(155,5,$proposant['in_customer_adresse'],0,false);
        $this->pdf->SetXY(+155,$y);
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Cell(35,5,"Code postal :",1,0,'LT',true);
        $this->pdf->Cell(60,5,$proposant['in_customer_codepostal'],1,0,'L',true);
        $this->pdf->Cell(35,5,utf8_decode("Téléphone :"),1,0,'L',true);
        $this->pdf->Cell(60,5,$proposant['in_customer_telephone'],1,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(35,5,"Ville :",1,0,'LT',true);
        $this->pdf->Cell(60,5,$proposant['in_customer_ville'],1,0,'L',true);
        $this->pdf->Cell(35,5,"Fax :",1,0,'L',true);
        $this->pdf->Cell(60,5,$proposant['in_customer_fax'],1,0,'L',true);
        $this->pdf->Ln();

//---------------------------------------------------------------------------//
//------------------------CARACTERISTIQUES DU RISQUE-------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->Table_entete(utf8_decode("Caractéristiques du risque :"));

        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,35,14);
        $this->pdf->MultiCell(35,5,"Adresse :\n",0,false);
        $this->pdf->SetXY($x+35,$y);
        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,155,14);
        $this->pdf->MultiCell(155,5,$proposant['in_risk_adresse'],0,false);
        $this->pdf->SetXY($x+155,$y);
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Cell(50,5,"Code postal :",1,0,'LT',true);

        if (($product['in_coef_zone'] + 1) < 10)
            $codepostal_risque = '0'.($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];
        else
            $codepostal_risque = ($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];

        $this->pdf->Cell(45,5, $codepostal_risque,1,0,'L',true);
        $this->pdf->Cell(50,5,"Ville :",1,0,'LT',true);
        $this->pdf->Cell(45,5,$proposant['in_risk_ville'],1,0,'L',true);
        $this->pdf->Ln();

        $this->pdf->Cell(25,5,"Occupant :",1,0,'L',true);
        $this->pdf->Cell(25,5,format_etat($proposant['in_risk_occupant']),1,0,'L',true);
        $this->pdf->Cell(45,5,"Agravation occupation :",1,0,'L',true);
        $this->pdf->Cell(95,5,$coef_aggravation_occupation,1,0,'L',true);
        $this->pdf->Ln();

        $this->pdf->Cell(50,5,utf8_decode("Surface développée (en m²) :"),1,0,'LT',true);
        $this->pdf->Cell(45,5,$product['in_nombre_surface'],1,0,'L',true);
        $this->pdf->Cell(50,5,utf8_decode("Année de construction :"),1,0,'L',true);
        $this->pdf->Cell(45,5,utf8_decode($coef_annee_construction['designation'][$product['in_coef_annee_construction']]),1,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(50,5,utf8_decode("Catégorie de construction :"),1,0,'LT',true);
        $this->pdf->Cell(45,5,utf8_decode("Catégorie 2"),1,0,'L',true);
        //$pdf->Cell(45,5,$coef_categorie_batiment['designation'][$product['in_coef_categorie_batiment']],1,0,'L',true);
        $this->pdf->Cell(50,5,"Nature du risque :",1,0,'L',true);
        $this->pdf->Cell(45,5,utf8_decode($proposant['in_risk_naturerisque']),1,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(50,5,utf8_decode("Sinistres déclarés / 36 mois :"),1,0,'LT',true);
        $this->pdf->Cell(45,5,format_value($product['in_nombre_sinistres']),1,0,'L',true);
        $this->pdf->Cell(50,5,utf8_decode("Type de résidence :"),1,0,'L',true);
        $this->pdf->Cell(45,5,$proposant['in_risk_residence'],1,0,'L',true);
        $this->pdf->Ln();

//---------------------------------------------------------------------------//
//-------------------------SPECIFICITES TECHNIQUES---------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->Table_entete(utf8_decode("Spécificités techniques du bâtiment assuré :"));
        $this->pdf->Cell(65,5,"Construction < 50 % mat durs :",1,0,'LT',true);
        $this->pdf->Cell(30,5,format_etat($product['in_coef_specificites_techniques_0']),1,0,'L',true);
        $this->pdf->Cell(65,5,"Vitres de plus de 3 m2 :",1,0,'LT',true);
        $this->pdf->Cell(30,5,format_etat($product['in_coef_specificites_techniques_2']),1,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(65,5,"Couverture < 90 % mat durs :",1,0,'LT',true);
        $this->pdf->Cell(30,5,format_etat($product['in_coef_specificites_techniques_1']),1,0,'L',true);
        $this->pdf->Cell(65,5,utf8_decode("Ren à recours contre état :"),1,0,'L',true);
        $this->pdf->Cell(30,5,format_etat($product['in_coef_specificites_techniques_4']),1,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(65,5,"Couverture shingle :",1,0,'LT',true);
        $this->pdf->Cell(30,5,format_etat($product['in_coef_specificites_techniques_3']),1,0,'L',true);
        $this->pdf->Cell(65,5,utf8_decode("Ren à recours prop / locataire :"),1,0,'L',true);
        $this->pdf->Cell(30,5,format_etat($product['in_coef_specificites_techniques_5']),1,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(65,5,utf8_decode("Défaut de protection :"),1,0,'LT',true);
        $this->pdf->Cell(30,5,format_etat($product['in_etat_defautprotection']),1,0,'L',true);
        $this->pdf->Cell(65,5,utf8_decode("Doublement limites tempête :"),1,0,'LT',true);
        $this->pdf->Cell(30,5,format_etat($product['in_coef_specificites_techniques_6']),1,0,'L',true);
        $this->pdf->Ln();

//---------------------------------------------------------------------------//
//-----------------------------OPTIONS CHOISIES------------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->Table_entete("Les options que vous avez choisies :");

        $this->pdf->Cell(75,5,"Nombre de baux :",1,0,'LT',true);
//$pdf->Cell(20,5,format_value($product['in_nombre_baux']),1,0,'L',true);
        $this->pdf->Cell(20,5,"Non",1,0,'L',true);
        $this->pdf->Cell(75,5,utf8_decode("Protection juridique étendue :"),1,0,'L',true);
        if ($product['in_nombre_baux'] > 0) { $protection_juridique = "Oui"; } else { $protection_juridique = "Non"; }
        $this->pdf->Cell(20,5,$protection_juridique,1,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(75,5,"Suppression garantie VOL :",1,0,'LT',true);
        $this->pdf->Cell(20,5,format_etat($product['in_coef_minorations_possibles_0']),1,0,'L',true);
        $this->pdf->Cell(75,5,utf8_decode("Suppression de la garantie dégats des eaux :"),1,0,'L',true);
        $this->pdf->Cell(20,5,format_etat($product['in_coef_minorations_possibles_1']),1,0,'L',true);

        $this->pdf->Ln();
        $this->pdf->Cell(75,5,"Suppression de la garantie bris de glace :",1,0,'L',true);
        $this->pdf->Cell(20,5,format_etat($product['in_coef_minorations_possibles_2']),1,0,'L',true);
        $this->pdf->Cell(75,5,utf8_decode("Franchise supplémentaire :"),1,0,'L',true);
        $this->pdf->Cell(20,5,"Non",1,0,'L',true);

        $this->pdf->Ln();

//----------------------------------------------------------------------------------//
//-----------------------------Réclamation et Litiges------------------------------//
//--------------------------------------------------------------------------------//

        $this->pdf->Table_entete(utf8_decode("Réclamation et Litiges :"));
        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,190,45);
        $this->pdf->SetFont('Arial','',10);
//if (!empty($res->affiliate_adress)){
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(24,5,utf8_decode("Réclamation:"),0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->Cell(158,5,utf8_decode("Toute réclamation doit être adressée en premier lieu par courrier ou par e-mail à l'adresse suivante :"),0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(170,5, utf8_decode("Groupe corim assurance - Service réclamations - 37, rue des Mathurins - 75008 Paris "),0,'C',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(125,5,utf8_decode("Email: reclamations@groupecorim.fr"),0,'C',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(15,5,"Litiges:",0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->MultiCell(190,5,utf8_decode("Personne ou société à qui devront être signifiés les actes judiciaires en cas de procédure contentieuse engagée à l'encontre des Assureurs:"),0,false);
        $this->pdf->Cell(170,5,"GROUPE CORIM ASSURANCES - 37, rue des mathurins - 75008 PARIS - www.groupecorim.fr",0,'C',true);

//---------------------------------------------------------------------------//
//-----------------------------------CLAUSES---------------------------------//
//---------------------------------------------------------------------------//

        $this->pdf->AddPage();

// set the source file
        $this->pdf->Image(storage_path() .'../../public/images/trdgnew.png',6,30,200);
// import page 1

        // use the imported page and place it at point 10,10 with a width of 100 mm

        $this->pdf->AddPage();
        $this->pdf->Table_entete("Les clauses applicables au contrat :");
        $this->pdf->SetFont('Arial','',7);
        $this->pdf->Cell(30,5,"PNO :",1,0,'LT',true);
        $this->pdf->Cell(160,5,clean_clauses($product['result_pno']['clauses']),1,0,'L',true);

//---------------------------------------------------------------------------//
//-----------------------------------CLAUSES BIS-----------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->Table_entete(utf8_decode("Clauses et déclarations :"));

        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,190,125);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(190,5,utf8_decode("Le sociétaire déclare :\n- Que les capitaux assurés en INCENDIE portent bien sur la totalité des existants,\n- Que les biens à assurer sont dans un état normal d'entretien et qu'il s'engage à les y maintenir,\n- Qu'il n'a pas été victime de plus d'un sinistre au cours des 36 derniers mois,\n- Qu'il n'a pas été résilié par un autre assureur pour quelque motif que ce soit,\n- Que les biens à assurer ne se situent pas dans un batiment de plus de 28 mètres de hauteur,\n- Que les biens à assurer ne sont pas contigus ou voisins avec des risques aggravants (discothèque, travail du bois, plasturgie, ...),\n- Que les biens assurés ne sont pas situés à plus de 100 mètres de toute habitation,\n- Que le bâtiment assuré n'est ni un château ni un bâtiment inoccupé\n- Que sauf dérogation  définie à la rubrique aggravation VOL :\n- Qu'il n'a pas connaissance de faits dommageables survenus avant la rédaction du présent document,\n engageant sa responsabilité civile et susceptibles de faire l'objet d'une réclamation par un tiers. Il n'a aucun litige en cours avec un tiers,\n- Qu'il a bien été informé que, conformément à la loi informatique et libertés, il dispose d'un droit de rectification de toutes les données le concernant sur les fichiers informatiques de la société,\n- qu'il a bien été informé du caractère obligatoire des questions qui lui ont été posées et qui permettent l'obtention de la présente tarification et la garantie de ses biens, tout manquement à cette obligation peut provoquer l'application des articles L 113-9 (réduction des indemnités) ou L 113-8 (nullité du contrat)du code des assurances,\n- Qu'il a bien été informé que toute modification intervenant dans son habitation (en matière de capitaux ou d'aggravation) doit faire l'objet d'une déclaration auprès de son assureur afin de lui apporter le conseil et les modifications nécessaires à son contrat,\n- Avoir reçu les éléments d'information conformes à l'article L 112-2 du Code des Assurances, un exemplaire du présent document, les conditions générales VITALIA réf : P-1003-06/2009, et le cas échéant, les annexes spécifiques (ANNEXE PJ et Annexe assistance). \n\nCe document vaut projet d'assurance et après accord, proposition pour établissement du contrat."),0,false);
        $this->pdf->SetXY($x,$y + 120);
//---------------------------------------------------------------------------//
//-------------------------------------DUREE---------------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->Table_entete(utf8_decode("Durée du contrat :"));

        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,190,30);
        $this->pdf->MultiCell(190,5,utf8_decode("La durée du contrat est d'un an avec tacite reconduction sauf résiliation moyennant préavis de 2 mois avant l'échéance.\nLa prise de garantie ne sera effective qu'à réception du dossier complet comprenant:\n- la proposition signée\n- le reglement à l'ordre de GROUPE CORIM ASSURANCES\n- le relevé de sinistralité sur les 36 derniers mois si le client était déjà assuré.\nLes garanties prennent effet au plus tôt le lendemain à midi du jour de paiement de la première cotisations."),0,false);
        $this->pdf->SetXY($x,$y + 25);

//---------------------------------------------------------------------------//
//-------------------------------PAVE COMPTABLE------------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->Table_entete("Pavé comptable :");

        $surfaceDeveloppee = $product['in_nombre_surface'];
        if ($product['in_nombre_baux'] > 0 and $surfaceDeveloppee > 0)
        {
            $protection_juridique = $surfaceDeveloppee * 0.13;
            if($surfaceDeveloppee < 2001)
            {
                $protection_juridique = 140;
            }

            $protection_juridique = $protection_juridique + 20;
        }
        else
        {
            $protection_juridique = 0;
        }
        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,190,20);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->MultiCell(190,5,utf8_decode("Le tarif ci-dessous est valable sous réserve de la concordance des déclarations du souscripteur et de la statistique sinistres\n sur les 36 derniers mois datée de moins de 60 jours. La statistique sinistre doit obligatoirement être transmise pour la validation du tarif et la prise de garantie."),0,'L',false);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(47,5,utf8_decode("PNO, Cotisation annuelle TTC :"),0,'L',true);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(22,5,format_tarif(($product['result_pno']['cotisation'] * 0.83 * 1.1 * 1.3) + $protection_juridique)." Euros",0,'L',true);
        $this->pdf->SetXY($x,$y + 20);


//---------------------------------------------------------------------------//
//---------------------------------SIGNATURE---------------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(65,5,"Renseignez la date d'effet :    _ _/_ _/_ _ _ _ ",0,0,'L',true);
        $this->pdf->Cell(150,5,utf8_decode("Fait à                     le              "),0,0,'C',true);
        $this->pdf->Ln(10);
        $this->pdf->Cell(160,5,"Pour RESIDASSUR,                                                                             Le proposant,",0,0,'C',true);
//$pdf->Cell(190,10,"",0,0,'L',$pdf->Image('../img/fr/signature.png',null,10,10));
        $this->pdf->Ln(0);
//$pdf->Cell(190,20,$pdf->Image('../img/fr/signature.png',$pdf->GetX(),$pdf->GetY(),10),0,0,'C',true);
        $this->pdf->Cell(190,20,$this->pdf->Image(storage_path() .'../../public/images/signature.png',$this->pdf->GetX()+50,$this->pdf->GetY(),30),0,0,'L');

        $this->pdf->Output();

    }
}

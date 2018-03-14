<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Input;
use DB;

class FpdfOldContratController extends Controller
{
    protected $pdf;

    public function __construct(\App\Models\PdfContrat $pdf)
    {
        $this->pdf = $pdf;
    }

    public function oldcontratpdf(){

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

        $all_clauses = array(
            "C27" => array("Responsabilité civile gardienne d'enfants ou assistante maternelle agréée","La garantie Responsabilité Civile Familiale est étendue dans le cadre de l'article L132-2 du Code de la famille et de l'aide sociale, à la responsabilité civile qui pourrait incomber à l'assurée en qualité de gardienne d'enfants ou d'assistante maternelle pour les dommages causés aux tiers par le fait des enfants dont elle a la garde à titre onéreux et pour les dommages subis par ces derniers.
Vous déclarez que le nombre d'enfants n'excéde pas trois et que sont exclus les dommages causés aux biens appartenants à un assuré par le fait des enfants gardés et les dommages causés aux parents des enfants gardés."),
            "M10" => array("Responsabilité civile aide bénévole","D'un commun accord entre les parties, il est précisé que la garantie est étendue aux conséquences pécuniaires de la responsabilité civile que l'assuré peut encourir, à raison de dommages corporels résultant d'un accident subi par toute personne lui prêtant une aide spontanée et gratuite pour de travaux d'ordre privé.
La garantie est accordée sur la base du droit commun à concurrence de 100 fois l'indice tous préjudices confondus. Aucune indemnisation n'est due lorsque la conséquence de l'accident entraîne une invalidité inférieure ou égale à 5 %.
"),
            "M15" => array("Responsabilité civile de propriétaire de piscine", "Par dérogation aux Dispositions Générales du contrat la garantie Responsabilité Civile Immeuble est étendue aux dommages corporels, matériels et immatériels consécutifs causés aux tiers par une piscine vous appartenant.
Cette garantie n'est acquise que dans le cas où cette piscine dispose des moyens de protection requis par la législation en vigueur."),
            "C23" => array("Responsabilité civile personne handicapée", "Le sociétaire déclare la présence d'une personne handicapée mentale dans les personnes à assurer."),
            "M14" => array("Responsabilité civile de propriétaire d'étang ou plan d'eau", "Par dérogation aux Dispositions Générales du contrat la garantie Responsabilité Civile Immeuble est étendue aux dommages corporels, matériels et immatériels consécutifs causés aux tiers par les étangs ou plans d'eau vous appartenant dont la superficie globale est inférieure à 1 hectare.
Cette garantie n'est acquise que dans le cas ou cet étang ou plan d'eau est situé dans l'enceinte de la propriété et qu'il est entièrement cloturé."),
            "M09" => array("Responsabilité civile de propriétaire de terrain non bâti", "Par dérogation aux Dispositions Générales du contrat la garantie Responsabilité Civile Immeuble est étendue aux dommages corporels, matériels et immatériels consécutifs causés aux tiers par les terrains non bâtis vous appartenant dont la superficie globale est inférieure à 20 hectares. Cette extension est accordée aux terrains ne comportant ni cours d'eau, ni étange d'une superficie supérieure à 500 m2, ni carrière, ni mur de soutenement.
"),
            "C24" => array("Responsabilité civile chevaux", "Par dérogation aux Dispositions générales du contrat, la garantie Responsabilité Civile Vie Privée est étendue à la responsabilité civile que vous pouvez encourir en raison des dommages corporels, matériels et immatériels consécutifs causés aux tiers du fait des chevaux qui sont sous votre garde ou qui vous appartiennent."),
            "C29" => array("Responsabilité civile chiens dangereux", "Par dérogation aux Dispositions Générales du contrat, la garantie responsabilité civile vie privée est étendue à la responsabilité civile que vous pouvez encourir en raison des dommages corporels, matériels et immatériels consécutifs causés aux tiers du fait des chiens de catégorie 1 ou 2 tels que définis à l'article 211-1 du Code Rural, designés aux présentes Conditions Particulières, qui sont sous votre garde ou qui vous appartiennent.
La garantie est étendue aux membres de votre famille vivant habituellement à votre foyer dans la limite de 230 000 Euros par sinistre en cas :
- de decès et pour le seul préjudice économique subi par les ayants droits de la victime,
- d'incapacité permanente supérieure à 10%,
Nom du ou des chiens garantis :
Race du ou des chiens garantis :
N° de tatouage du ou des chiens garantis :
Date de naissance du ou des chiens garantis :"),
            "M06" => array("Spécificité technique doublement des garanties tempêtes","Par dérogation au tableau récapitulatif des garanties, les postes suivants sont doublés pour la garantie tempête.
 - Volets et persiennes
 - Murs de clôture et portails
 - Arbres et arbustes dans la propriété
 - Antennes de télévision
 - Mobilier déposé à l'extérieur des locaux
 - Privation de jouissance ou perte de loyers"),
            "M07" => array("Extension véranda","En présence d'une véranda, la garantie VOL :
- ne s'applique pas sur le mobilier déposé dans celle-ci,
- ne s'exerce dans le batiment que si les ouvertures de celui-ci, communiquant intérieurement avec la véranda, sont équipées des moyens de protection décrits dans les dispositions contractuelles de la garantie VOL.
Par dérogations aux dispositions générales, la garantie BRIS DES GLACES est accordée sur la véranda à concurrence du montant indiqué aux présentes conditions particulières."),
            "C15" => array("Extension véranda","En présence d'une véranda, la garantie VOL :
- ne s'applique pas sur le mobilier déposé dans celle-ci,
- ne s'exerce dans le batiment que si les ouvertures de celui-ci, communiquant intérieurement avec la véranda, sont équipées des moyens de protection décrits dans les dispositions contractuelles de la garantie VOL.
Par dérogations aux dispositions générales, la garantie BRIS DES GLACES est accordée sur la véranda à concurrence du montant indiqué aux présentes conditions particulières."),
            "C1115" => array("Extension panneaux solaires ou photovoltaiques", "Vous déclarez que le risque comporte une installation de panneaux solaires ou photovoltaiques installés en conformité avec les normes en vigueur. La garantie est étendue aux dommages résultant d'évènements contre lesquels vous avez choisi de vous assurer, à concurrence du capital mentionné aux présentes conditions particulières, restent toujours exclus : Le gel des installations, les dommages électriques et la responsabilité civile FOURNISSEUR de courant électrique."),
            "M05" => array("Spécificité technique renonciation recours locataire / propriétaire", "Dans le cas d'un location, l'assuré ayant renoncé dans le bail au recours qu'il pourrait être fondé à exercer contre le propriétaire par application des articles 1719 et 1721 du Code Civil, nous renonçons au recours que, comme subrogés dans les droits du locataire, nous sommes fondés à exercer contre le propriétaire du ou des bâtiments renfermant les objets assurés et dont la responsabilité se trouverait engagée (malveillance excepté) dans la réalisation de dommages matériels, de frais ou de pertes garantis. Cette renonciation vise uniquement les événements garantis au titre des garanties incendie, explosion, foudre et événements divers et dégâts des eaux. Cette renonciation ne peut bénéficier à un quelconque assureur.
Dans le cas d'un propriétaire, l'assuré ayant renoncé dans le bail au recours qu'il pourrait être fondé à exercer contre le   le locataire ou l'occupant par application des articles 1302, 1732, 1733, 1734 et 1735 du Code Civil, nous renonçons au recours que, comme subrogés dans les droits du propriétaire nous sommes fondés à exercer contre le locataire ou l'occupant dont la responsabilité se trouverait engagée (malveillance exceptée) dans la réalisation de dommages matériels, de frais ou de pertes garantis.Cette renonciation vise uniquement les événements garantis au titre des garanties incendie, explosion, foudre et événements divers et dégâts de eaux. Cette renonciation ne peut bénéficier à un quelconque assureur."),
            "C18" => array("Extension résidence secondaire et innocupation > 90 jours", "Le risque assuré est inoccupé pendant plus de 90 jours dans l'année. De ce fait, vous vous engagez durant les périodes inhabitées, à compter du 1er jour de celles-ci à interrompre le courant électrique au niveau du dijoncteur principal et à interrompre le circulation d'eau au niveau de la vanne principale de distribution. Durant les périodes d'hiver, les conduites et appareils à effet d'eau seront vidangés. Les espéces, valeurs et bijoux sont exclus à compter du 1er jour d'inhabitation.
Pour que la garantie VOL s'exerce, les ouvertures donnant sur l'extérieur ou les dépendances doivent être au minimum protégées comme suit, portes pleines et comportant trois points d'ancrage ou deux verrous de sureté, autres ouvertures avec barreaux métalliques scellés ou volets bois pleins avec barre intérieure métallique anti-effraction.
Si la garantie VOL est souscrite et que les moyens de protection énoncés précédemment sont respectés, la garantie est accordée au delà de 90 jours d'inhabitation par an."),
            "C19" => array("Extension résidence secondaire et innocupation > 90 jours", "Le risque assuré est inoccupé pendant plus de 90 jours dans l'année. De ce fait, vous vous engagez durant les périodes inhabitées, à compter du 1er jour de celles-ci à interrompre le courant électrique au niveau du dijoncteur principal et à interrompre le circulation d'eau au niveau de la vanne principale de distribution. Durant les périodes d'hiver, les conduites et appareils à effet d'eau seront vidangés. Les espéces, valeurs et bijoux sont exclus à compter du 1er jour d'inhabitation.
Pour que la garantie VOL s'exerce, les ouvertures donnant sur l'extérieur ou les dépendances doivent être au minimum protégées comme suit, portes pleines et comportant trois points d'ancrage ou deux verrous de sureté, autres ouvertures avec barreaux métalliques scellés ou volets bois pleins avec barre intérieure métallique anti-effraction.
Si la garantie VOL est souscrite et que les moyens de protection énoncés précédemment sont respectés, la garantie est accordée au delà de 90 jours d'inhabitation par an."),
            "C02" => array("Spécificité technique construction < 50% matériaux durs", "La construction du bâtiment est réalisée avec plus de 50 % de matériaux légers (bois, paille, ...)."),
            "C03" => array("Spécificité technique couverture < 90% matériaux durs", "La couverture du bâtiment est réalisée avec plus de 10 % de matériaux légers (PVC, translucide, ...)."),
            "C28" => array("Spécificité technique couverture shingle", "La couverture du bâtiment assuré est réalisée en bardeaux d'asphalte communément appelés shingle."),
            "C08" => array("Aggravation agricole et fourrage < 3 tonnes", "- que le risque assuré contient du fourrage sans excèder 3 tonnes au total."),
            "C09" => array("Aggravation agricole et fourrage > 3 et < 10 tonnes", "- que le risque assuré contient du fourrage sans excèder 10 tonnes au total."),
            "C10" => array("Aggravation agricole et fourrage > 10 tonnes", "- que le risque assuré contient du fourrage dont la quantité totale peut excèder 10 tonnes."),
            "C07" => array("Aggravation agricole sans fourrage", "- que le risque assuré des matériels agricoles mais pas du tout de fourrage."),
            "C11" => array("Aggravation bouteilles de gaz de 8 à 30 maximum", "- que le risque assuré peut contenir de 8 à 3bouteilles de gaz butane de 13 KG chacune."),
            "C12" => array("Aggravation liquides inflammables de 3000 à 8000 litres", "- que le risque assuré peut contenir du fioul pour une quantité supérieure à 3000 litres sans excèder 8000 litres. Il est alors précisé que les citernes sont placés dans un endroit muni de parois de rétention."),
            "C14" => array("Extension vitres > 3 m2", "- que le bâtiment assuré comporte au moins une vitre dont la surface excède 3 m2."),
            "C20" => array("Extension vol système d'alarme agréé", "Le sociétaire déclare que les biens garantis sont protégés par un système d'alarme agréé ou certifié NFA2P. En cas d'absence d'un tel dispositif lors de la survenance d'un sinistre, la Société se réserve le droit d'appliquer une règle proportionnelle (en cas de présence de moyens mécaniques de protection des ouvertures tels que définis aux conditions générales) ou une déchéance des droits à indemnisation (en cas d'absence des moyens de protection mécaniques précédemment cités)."),
            "C04" => array("Aggravation activité commerciale de 0 à 50 % SD totale", "Il est précisé que l'activité professionnelle pratiquée dans les locaux assurés consiste en : occupe une surface de :      m2.")

        );

        $id_devis = Input::get('id');

        $devis = DB::table('old_devis')->where('id', $id_devis)->get();
        $indice_de_base = DB::table('indices')->where('id','=',1)->get();

        //$test = $devis[0]->affiliate_firstname;
        $date_an = $devis[0]->date_creation;
        $proposant = unserialize($devis[0]->data_proposant);
        $product = unserialize($devis[0]->data_product);
        $clauses = $devis[0]->clauses;
        new FPDF('P', 'mm', 'A4');

        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->SetFillColor(255,255,255);

//---------------------------------------------------------------------------//
//----------------------------------LE PROPOSANT-----------------------------//
//---------------------------------------------------------------------------//

        $this->pdf->MultiCell(190,10,utf8_decode(strtoupper('assurance '.type_to_label($devis[0]->type_product))),0,'C');
        $this->pdf->Ln();

        /////////////// Code test /////////////
        if (!preg_match('/PNO/',$devis[0]->formule))
        {
            if ($devis[0]->type_product == 1)
                $this->pdf->Cell(95,5,$devis[0]->formule." ".strtoupper($coef_qualite_occupant['designation'][$product['in_coef_qualite_occupant']]),0,0,'L',true);
            else{
                //If (!empty($res->affiliate_lastname)){
                //  $pdf->Cell(95,5,'Par'.' '.$res->affiliate_lastname .' '. $res->affiliate_firstname.''. ' pour ' .''. $res->affiliate_company ,0,0,'L',true);
                $this->pdf->SetFont('Arial','B',9);
                $this->pdf->Cell(95,5,utf8_decode(' par '.$devis[0]->affiliate_lastname.' '. $devis[0]->affiliate_firstname),0,0,'L',true);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->Cell(95,5,utf8_encode(''.$proposant['in_customer_sigle'].' '.$proposant['in_customer_prenom'].' '.$proposant['in_customer_nom'].'     '),0,0,'R',true);
                $this->pdf->Ln();
                $this->pdf->SetFont('Arial','B',9);
                $this->pdf->Cell(95,5,utf8_decode(' pour '.$devis[0]->affiliate_company),0,0,'L',true);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->Cell(95,5,utf8_decode(''.$proposant['in_customer_adresse'].'     '),0,0,'R',true);
                $this->pdf->Ln();
                $this->pdf->SetFont('Arial','B',9);
                $this->pdf->Cell(95,5,utf8_decode(' '.$devis[0]->affiliate_address),0,0,'L',true);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->Cell(95,5,''.$proposant['in_customer_codepostal'].' '.$proposant['in_customer_ville'].'     ',0,0,'R',true);
                $this->pdf->Ln();
                $this->pdf->SetFont('Arial','B',9);
                $this->pdf->Cell(45,5,utf8_decode(' '. $devis[0]->affiliate_city.' '. $devis[0]->affiliate_zip),0,0,'L',true);
                $this->pdf->Ln();
                $this->pdf->Cell(45,5,utf8_decode(' n° ORIAS : '. $devis[0]->affiliate_orias),0,0,'L',true);
                $this->pdf->Ln();
                $this->pdf->Cell(45,5,' Tel : '. $devis[0]->affiliate_tel,0,0,'L',true);
                $this->pdf->Ln();
                if (!empty($res->affiliate_ref)){
                    $this->pdf->Cell(80,5,utf8_decode('Référence affilié : '.$devis[0]->affiliate_ref),0,0,'L',true);
                }else{

                }
            }//else {
            //$pdf->Cell(95,5,' ',0,0,'L',true);
            // }
            $this->pdf->Ln();
            $this->pdf->SetFont('Arial','',9);
            $this->pdf->MultiCell(190,5,utf8_decode("Contrat n°".display_id_contrat($devis[0]->id_contrat)." sur devis n°".$devis[0]->id.""),0,0,'R',true);
            $this->pdf->Ln(5);
        } else {

            $this->pdf->Cell(95,5,$devis[0]->formule,0,0,'L',true);
            $this->pdf->Ln();

        }

        $this->pdf->Table_entete(utf8_decode("Conditions particulières"));
        $this->pdf->Cell(190,5,utf8_decode("Ce document a été établi sur la base de vos déclarations et concrétise nos engagements réciproques."),0,0,'L',true);
        $this->pdf->Ln(3);
        $this->pdf->Table_entete(utf8_decode("Description du risque assuré"));
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"Situation du risque :",0,0,'L',true);
        $this->pdf->Cell(95,5,$proposant['in_risk_adresse'],0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,"",0,0,'L',true);
        if ($devis[0]->type_product == 1){
            if (($product['in_coef_zone'] + 1) < 10)
                $codepostal_risque = '0'.($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];
            else
                $codepostal_risque = ($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];

            $this->pdf->Cell(95,5,''.$codepostal_risque.' '.$proposant['in_risk_ville'].'',0,0,'L',true);
            $this->pdf->Ln();
        }else if ($devis[0]->type_product == 2){

            if (($product['in_coef_zone'] + 1) < 10)
                $codepostal_risque = '0'.($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];
            else
                $codepostal_risque = ($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];

            $this->pdf->Cell(95,5,''.$codepostal_risque.' '.$proposant['in_risk_ville'].'',0,0,'L',true);
            $this->pdf->Ln();
        }else if (($devis[0]->type_product == 3)){

            $this->pdf->Cell(95,5,$proposant['in_risk_ville'].'',0,0,'L',true);
            $this->pdf->Ln();

        }

        if ($devis[0]->type_product == 1)
        {
            $this->pdf->Cell(40,5,"Qualité de l'assuré :",0,0,'L',true);
            $this->pdf->Cell(65,5,$coef_qualite_occupant['designation'][$product['in_coef_qualite_occupant']],0,0,'L',true);
        }
        $this->pdf->Cell(40,5,"Aggravation :",0,0,'L',true);
        $this->pdf->Cell(65,5,utf8_decode("voir conventions spéciales"),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(40,5,utf8_decode("Résidence :"),0,0,'L',true);
        $this->pdf->Cell(65,5,$proposant['in_risk_residence'],0,0,'L',true);

        if ($devis[0]->type_product == 1)
        {
            $this->pdf->Cell(40,5,"Nombre de pièces :",0,0,'L',true);
            $this->pdf->Cell(65,5,$product['in_nombre_pieces'],0,0,'L',true);
        }
        $this->pdf->Ln();

        $this->pdf->Cell(40,5,"Type d'habitation :",0,0,'L',true);
        $this->pdf->Cell(65,5,$proposant['in_risk_naturerisque'],0,0,'L',true);

        $this->pdf->Ln();

        if ($devis[0]->type_product == 1)
        {
            $this->pdf->Cell(40,5,utf8_decode("Dépendances :"),0,0,'L',true);
            $this->pdf->Cell(65,5,$product['in_nombre_dependances']." m2",0,0,'L',true);

        } else if ($devis[0]->type_product == 2){

            $this->pdf->Cell(40,5,utf8_decode("Surface dèveloppée :"),0,0,'L',true);
            $this->pdf->Cell(65,5,$product['in_nombre_surface']." m2",0,0,'L',true);
        } else if ($devis[0]->type_product == 3){

            $surface_in_nombre = $product['in_nombre_surface_habi'] + $product['in_nombre_surface_bur'] + $product['in_nombre_surface_comm'] + $product['in_nombre_surface_gar'] + $product['in_nombre_surface_indu'] + $product['in_nombre_surface_vide'] + $product['in_nombre_surface_pis'];

            $this->pdf->Cell(40,5,"Surface dèveloppée :",0,0,'L',true);
            $this->pdf->Cell(65,5, $surface_in_nombre." m2",0,0,'L',true);
        }
        $this->pdf->Ln();

        if ($devis[0]->type_product == 1)
        {
            if (preg_match('/ECO/',$devis[0]->formule))
            {
                $this->pdf->Cell(40,5,"Capital mobilier :",0,0,'L',true);
                $this->pdf->Cell(65,5,format_tarif($product['result_eco']['mobilier']). " à",0,0,'L',true);
                $this->pdf->Cell(40,5,"Dont objet précieux :",0,0,'L',true);
                $this->pdf->Cell(65,5,"0 %",0,0,'L',true);
            }
            else if (preg_match('/CONFORT/',$devis[0]->formule))
            {
                $this->pdf->Cell(40,5,"Capital mobilier :",0,0,'L',true);
                $this->pdf->Cell(65,5,format_tarif($product['result_confort']['mobilier']). " à",0,0,'L',true);
                $this->pdf->Cell(40,5,"Dont objet précieux :",0,0,'L',true);
                $this->pdf->Cell(65,5,"15 %",0,0,'L',true);
            }
            else if (preg_match('/PRESTIGE/',$devis[0]->formule))
            {
                $this->pdf->Cell(35,5,"Capital mobilier :",0,0,'L',true);
                $this->pdf->Cell(64,5,format_tarif($product['result_prestige']['mobilier']). " à",0,0,'L',true);
                $this->pdf->Cell(40,5,"Dont objet précieux :",0,0,'L',true);
                if ($product['in_coef_specificites_techniques_4'] > -1)
                    $this->pdf->Cell(70,5,"45 %",0,0,'L',true);
                else
                    $this->pdf->Cell(70,5,"25 %",0,0,'L',true);
            }
            else if (preg_match('/PNO/',$devis[0]->formule))
            {
                $this->pdf->Cell(40,5,"Capital mobilier :",0,0,'L',true);
                $this->pdf->Cell(65,5,format_tarif(0). " à",0,0,'L',true);
                $this->pdf->Cell(40,5,"Dont objet précieux :",0,0,'L',true);
                $this->pdf->Cell(65,5,"0 %",0,0,'L',true);
            }
            else {}
        } else if($devis[0]->type_product == 2) {
            //$pdf->Cell(35,5,"Nombre de baux :",0,0,'L',true);
            //$pdf->Cell(70,5,$product['in_nombre_baux'],0,0,'L',true);
            $this->pdf->Cell(40,5,utf8_decode("Année de construction :"),0,0,'L',true);
            if($product['in_coef_annee_construction'] == 0){
                $coef_annee_constructio = "Antérieure à 1948";
            } else if($product['in_coef_annee_construction'] == 1){
                $coef_annee_constructio = "Postérieure à 1948";
            }
            $this->pdf->Cell(65,5, utf8_decode($coef_annee_constructio), 0,0,'L',true);
            $this->pdf->Ln();
            $this->pdf->Cell(40,5,utf8_decode("Catégorie :"),0,0,'L',true);
            $this->pdf->Cell(65,5,utf8_decode("Catégorie 2"),0,0,'L',true);
            $this->pdf->Ln(5);
        }else if ($devis[0]->type_product == 3) {

            $this->pdf->Cell(40, 5, "", 0, 0, 'L', true);
            $this->pdf->Cell(65, 5, '', 0, 0, 'L', true);
            $this->pdf->Ln();
            $this->pdf->Cell(40, 5, "", 0, 0, 'L', true);
            $this->pdf->Cell(65, 5, '', 0, 0, 'L', true);
        }
//---------------------------------------------------------------------------//
//------------------------------------CALCULS--------------------------------//
//---------------------------------------------------------------------------//


        $frais_et_accessoires_ht = ($devis[0]->customer_amount *0.4);

        $cotisation_fonds_garantie = 4.30;

        $cotisation_risques_technologiques_ht = 2.75;
        $cotisation_risques_technologiques_taxe = $cotisation_risques_technologiques_ht * 0.09;

        $cotisation_incendie_ht = ($devis[0]->customer_amount * 0.60 - $devis[0]->customer_amount_rc - $cotisation_fonds_garantie - $cotisation_risques_technologiques_ht - $cotisation_risques_technologiques_taxe) * 0.3 / 1.3;
        $cotisation_incendie_taxe = $cotisation_incendie_ht * 0.3;

        $solde_taxe_9_ht = ($devis[0]->customer_amount*0.60 - $devis[0]->customer_amount_rc - $cotisation_fonds_garantie - $cotisation_risques_technologiques_ht - $cotisation_risques_technologiques_taxe - $cotisation_incendie_ht - $cotisation_incendie_taxe) / 1.09;
        $solde_taxe_9_taxe = $solde_taxe_9_ht * 0.09;

        $calcul_ht_9_hors_incendie_attentats_cn = (($cotisation_incendie_ht + $solde_taxe_9_ht) - $cotisation_incendie_ht * 1.139) / 1.107;
        $sortie_RC_non_soumise_attentats_cn = $calcul_ht_9_hors_incendie_attentats_cn * 0.77;

        $cotisation_attentats_ht = ($cotisation_incendie_ht + $sortie_RC_non_soumise_attentats_cn) * 0.017;
        $cotisation_attentats_taxe = $cotisation_attentats_ht * 0.09;

        $cotisation_cn_ht = ($cotisation_incendie_ht + $cotisation_attentats_ht + $sortie_RC_non_soumise_attentats_cn) * 0.12;
        $cotisation_cn_taxe = $cotisation_cn_ht * 0.09;


        $repartition_tgn_ht = $calcul_ht_9_hors_incendie_attentats_cn * 0.07;
        $repartition_tgn_taxe = $repartition_tgn_ht * 0.09;

        $repartition_dommageselectriques_ht = $calcul_ht_9_hors_incendie_attentats_cn * 0.21;
        $repartition_dommageselectriques_taxe = $repartition_dommageselectriques_ht * 0.09;

        $repartition_brisdeglaces_ht = $calcul_ht_9_hors_incendie_attentats_cn * 0.07;
        $repartition_brisdeglaces_taxe = $repartition_brisdeglaces_ht * 0.09;

        $repartition_vol_ht = $calcul_ht_9_hors_incendie_attentats_cn * 0.19;
        $repartition_vol_taxe = $repartition_vol_ht * 0.09;

        if ($devis[0]->formule == "OPTION PROPRIETAIRE NON OCCUPANT")
            $repartition_rc_ht = $calcul_ht_9_hors_incendie_attentats_cn * 0.05;
        else
            $repartition_rc_ht = $calcul_ht_9_hors_incendie_attentats_cn * 0.21;
        $repartition_rc_taxe = $repartition_rc_ht * 0.09;

        $repartition_dr_ht = $calcul_ht_9_hors_incendie_attentats_cn * 0.02;
        $repartition_dr_taxe = $repartition_dr_ht * 0.09;

        if ($devis[0]->formule == "OPTION PROPRIETAIRE NON OCCUPANT")
            $repartition_degatsdeseaux_ht =  $calcul_ht_9_hors_incendie_attentats_cn * 0.39 + ($devis[0]->customer_amount_rc / 1.09);
        else
            $repartition_degatsdeseaux_ht =  $calcul_ht_9_hors_incendie_attentats_cn * 0.23 + ($devis[0]->customer_amount_rc / 1.09);

        $repartition_degatsdeseaux_taxe = $repartition_degatsdeseaux_ht * 0.09;

        $cotisation_ht_annuelle = $cotisation_risques_technologiques_ht + $cotisation_incendie_ht + $cotisation_attentats_ht + $cotisation_cn_ht + $repartition_tgn_ht + $repartition_dommageselectriques_ht + $repartition_brisdeglaces_ht + $repartition_vol_ht + $repartition_rc_ht + $repartition_dr_ht + $repartition_degatsdeseaux_ht;
        $taxes_annuelles = $cotisation_risques_technologiques_taxe + $cotisation_incendie_taxe + $cotisation_attentats_taxe + $cotisation_cn_taxe + $repartition_tgn_taxe + $repartition_dommageselectriques_taxe + $repartition_brisdeglaces_taxe + $repartition_vol_taxe + $repartition_rc_taxe + $repartition_dr_taxe + $repartition_degatsdeseaux_taxe;

//---------------------------------------------------------------------------//
//----------------------------------COTISATION-------------------------------//
//---------------------------------------------------------------------------//
        if ($devis[0]->type_product == 1)
        {
            $protection_juridique = 0;
        } else if ($devis[0]->type_product == 2){
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
            ///////// Cotisation annuelle Taxe Annuelle ////////////
            $protection_juridique_sans_taxes = $protection_juridique -20 ;
            $protection_juridique_taxes = $protection_juridique_sans_taxes * 0.134 ;
            $protection_juridique_ht = $protection_juridique_sans_taxes - $protection_juridique_taxes ;

        }else if ($devis[0]->type_product == 3) {

            $surface_in_nombre_pj = $product['in_nombre_surface_habi'] + $product['in_nombre_surface_bur'] + $product['in_nombre_surface_comm'] + $product['in_nombre_surface_gar'] + $product['in_nombre_surface_indu'] + $product['in_nombre_surface_vide'] + $product['in_nombre_surface_pis'];

            if ($surface_in_nombre_pj < 1101) {
                $protection_juridique = $surface_in_nombre_pj + 90;
            } else if ($surface_in_nombre_pj > 1101){
                $protection_juridique = $surface_in_nombre_pj * 0.9;

            }
            /*$protection_juridique_sans_taxes = $protection_juridique - 20;
            $protection_juridique_ht = ($protection_juridique_sans_taxes / 112.50) * 100;
            $protection_juridique_taxes = $protection_juridique_sans_taxes - $protection_juridique_ht;*/
        }

        $this->pdf->Table_entete(utf8_decode("Eléments de cotisation"));
        $this->pdf->Ln();

        $this->pdf->Cell(50,5,"Date et heure d'effet :",0,0,'L',true);
        $this->pdf->Cell(60,5,utf8_decode(date("d/m/Y à 00:00", $devis[0]->date_contract)),0,0,'L',true);
        $this->pdf->Cell(40,5,"Cotisation annuelle HT :",0,0,'R',true);
        $this->pdf->Cell(40,5,format_tarif($cotisation_ht_annuelle + $frais_et_accessoires_ht).chr(128),0,0,'R',true);
        $this->pdf->Ln();

        $this->pdf->Cell(50,5,utf8_decode("Echéance principale :"),0,0,'L',true);
        $this->pdf->Cell(60,5,date("d/m", $devis[0]->date_contract),0,0,'L',true);
        $this->pdf->Cell(40,5,"Taxes annuelles :",0,0,'R',true);
        $this->pdf->Cell(40,5,format_tarif($taxes_annuelles).chr(128),0,0,'R',true);
//$pdf->Cell(40,5,"Frais et accessoires HT :",0,0,'R',true);
//$pdf->Cell(40,5,format_tarif($frais_et_accessoires_ht)." ?",0,0,'R',true);
        $this->pdf->Ln();

        $this->pdf->Cell(50,5,"Type de paiement :",0,0,'L',true);
        if ($devis[0]->periodicity == 1)
            $this->pdf->Cell(60,5,"Annuel",0,0,'L',true);
        else if ($devis[0]->periodicity == 2)
            $this->pdf->Cell(60,5,"Semestriel",0,0,'L',true);
        else if ($res->periodicity == 4)
            $this->pdf->Cell(60,5,"Trimestriel",0,0,'L',true);
        else
            $this->pdf->Cell(60,5,"Mensuel",0,0,'L',true);
        $this->pdf->Cell(40,5,"Cotisation TTC annuelle :",0,0,'R',true);
        $this->pdf->Cell(40,5,format_tarif($devis[0]->customer_amount).chr(128),0,0,'R',true);
        $this->pdf->Ln();

        $this->pdf->Cell(50,5,"Indice de base FNB :",0,0,'L',true);
        $this->pdf->Cell(60,5,$indice_de_base[0]->valeur,0,0,'L',true);
        $this->pdf->Cell(40,5,"Dont catastrophes naturelles :",0,0,'R',true);
        $this->pdf->Cell(40,5,format_tarif($cotisation_cn_ht + $cotisation_cn_taxe).chr(128),0,0,'R',true);
        $this->pdf->Ln();

        $this->pdf->Cell(50,5,"",0,0,'L',true);
        $this->pdf->Cell(60,5,"",0,0,'L',true);
        $this->pdf->Cell(40,5,"Dont attentats corporels :",0,0,'R',true);
        $this->pdf->Cell(40,5,format_tarif($cotisation_fonds_garantie).chr(128),0,0,'R',true);



        $this->pdf->Ln(10);

        $this->pdf->Cell(50,5,"",0,0,'L',true);
        $this->pdf->Cell(40,5,"",0,0,'L',true);




//$pdf->Cell(40,5,"",0,0,'R',true);

        /*$pdf->Ln();*/

        $this->pdf->SetFont('Arial','B',10);

        if ($devis[0]->periodicity == 1)
        {
            $this->pdf->Cell(60,5,utf8_decode('Cotisation TTC à percevoir pour la première période :'),0,0,'R',true);
            $this->pdf->Cell(40,5,format_tarif($devis[0]->customer_amount + $protection_juridique).chr(128),0,0,'R',true);
            $this->pdf->Ln();
            $this->pdf->SetFont('Arial','',10);
            // $pdf->Cell(150,5,'Soit 1 pr?l?vement de :',0,0,'R',true);
            // $pdf->Cell(40,5,format_tarif($res->customer_amount).' ?',0,0,'R',true);
        }
        else if ($devis[0]->periodicity == 2)
        {
            $this->pdf->Cell(60,5,utf8_decode('Cotisation TTC à percevoir pour la première période :'),0,0,'R',true);
            $this->pdf->Cell(40,5,format_tarif(($devis[0]->customer_amount  + $protection_juridique) / 2).chr(128),0,0,'R',true);
            $this->pdf->Ln();
            $this->pdf->SetFont('Arial','',10);
            $this->pdf->Cell(150,5,utf8_decode('Soit 2 règlements de :'),0,0,'R',true);
            $this->pdf->Cell(40,5,format_tarif(($devis[0]->customer_amount  + $protection_juridique) / 2).chr(128),0,0,'R',true);
        }
        else if ($devis[0]->periodicity == 4)
        {
            $this->pdf->Ln();
            $this->pdf->Cell(60,5,utf8_decode('Cotisation TTC à percevoir pour la première période :'),0,0,'R',true);
            $this->pdf->Cell(40,5,format_tarif(($devis[0]->customer_amount  + $protection_juridique) / 4).chr(128),0,0,'R',true);
            $this->pdf->Ln();
            $this->pdf->SetFont('Arial','',10);
            $this->pdf->Cell(150,5,utf8_decode('Soit 4 règlements de :'),0,0,'R',true);
            $this->pdf->Cell(40,5,format_tarif(($devis[0]->customer_amount  + $protection_juridique) / 4).chr(128),0,0,'R',true);
        }
        else
        {
            $this->pdf->Cell(60,5,utf8_decode('Cotisation TTC à percevoir pour la première période :'),0,0,'R',true);
            $this->pdf->Cell(40,5,format_tarif(($devis[0]->customer_amount  + $protection_juridique) / 12).chr(128),0,0,'R',true);
            $this->pdf->Ln();
            $this->pdf->SetFont('Arial','',10);
            $this->pdf->Cell(150,5,utf8_decode('Soit 12 règlements de :',0),0,'R',true);
            $this->pdf->Cell(40,5,format_tarif(($devis[0]->customer_amount  + $protection_juridique) / 12).chr(128),0,0,'R',true);
        }


        $this->pdf->Cell(50,5,"",0,0,'L',true);
        $this->pdf->Cell(60,5,"",0,0,'L',true);
        $this->pdf->Cell(40,5,"Dont protection juridique :",0,0,'R',true);
        $this->pdf->Cell(40,5,format_tarif($protection_juridique).chr(128),0,0,'R',true);

//---------------------------------------------------------------------------//
//-----------------------------------GARANTIES-------------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->AddPage();
        $this->pdf->Table_entete("Garanties souscrites");

        $this->pdf->Ln();
        $this->pdf->Cell(115,7,utf8_decode("Libellé de la garantie"),1,0,'C',true);
        $this->pdf->Cell(25,7,"Statut",1,0,'C',true);
        $this->pdf->Cell(25,7,"Plafond",1,0,'C',true);
        $this->pdf->Cell(25,7,"Franchise",1,0,'C',true);
        $this->pdf->Ln();

        function format_garantie($value, $seuil = -1)
        {
            if ($value == $seuil)
                return "Exclu";
            else
                return "Garanti";
        }

        function format_garantie_reverse($value, $seuil = -1)
        {
            if ($value == $seuil)
                return "Garanti";
            else
                return "Exclu";
        }

// TJS GARANTIE
        $this->pdf->Add_garantie(utf8_decode("TITRE V - GARANTIES DE BASE"),"","","");
        $this->pdf->Add_garantie(utf8_decode("- Incendie - foudre - explosions (article 23)"),"Garanti","CG et TG (1)","0.50 x indice");
        $this->pdf->Add_garantie(utf8_decode("- Risques électriques (article 24)"),"Garanti","CG et TG (1)","0.50 x indice");
        $this->pdf->Add_garantie(utf8_decode("- Tempètes - grêle - poids neige (article 25)"),"Garanti","CG et TG (1)","0.50 x indice");
        $this->pdf->Add_garantie(utf8_decode("- Bris de vitres et glaces (article 26)"),"Garanti","CG et TG (1)","0.50 x indice");

// GARANTIE VARIABLE

        If ($devis[0]->type_product == 1){
            $this->pdf->Add_garantie("TITRE VI - GARANTIES FACULTATIVES","","","");
            $this->pdf->Add_garantie("- Dégâts des eaux (article 28)",format_garantie_reverse($product['in_coef_minorations_possibles_1']),"CG et TG (1)","0.50 x indice");
            $this->pdf->Add_garantie("- Vol et vandalisme (article 29)",format_garantie_reverse($product['in_coef_minorations_possibles_0']),"CG et TG (1)","0.50 x indice");
        } else if ($devis[0]->type_product == 2){

            $this->pdf->Add_garantie("TITRE VI - GARANTIES FACULTATIVES","","","");
            $this->pdf->Add_garantie(utf8_decode("- Dégâts des eaux (article 28)"),format_garantie_reverse($product['in_coef_minorations_possibles_1']),"CG et TG (1)","0.50 x indice");
            $this->pdf->Add_garantie("- Vol et vandalisme (article 29)",format_garantie_reverse($product['in_coef_minorations_possibles_0']),"CG et TG (1)","0.50 x indice");
        } else if ($devis[0]->type_product == 3){

            $this->pdf->Add_garantie("TITRE VI - GARANTIES FACULTATIVES","","","");
            $this->pdf->Add_garantie(utf8_decode("- Dégâts des eaux (article 28)"),"Garanti","CG et TG (1)","0.50 x indice");
            $this->pdf->Add_garantie(utf8_decode("- Vol et vandalisme (article 29)"),"Garanti","CG et TG (1)","0.50 x indice");
        }
// TJS GARANTIE
        $this->pdf->Add_garantie("TITRE VII - GARANTIES LEGALES","","","");
        $this->pdf->Add_garantie("- Catastrophes naturelles (article 34)","Garanti","CG et TG (1)",utf8_decode("franchise légale"));
        $this->pdf->Add_garantie("- Attentats (article 35)","Garanti","CG et TG (1)","0.50 x indice");

        $this->pdf->Add_garantie("TITRE VIII - RESPONSABILITES CIVILES","","","");
        // $pdf->Add_garantie("- RC Familiale (article 38)","Garanti","CG et TG (1)","0.50 x indice");
        $this->pdf->Add_garantie("- RC Immeuble (article 39)","Garanti","CG et TG (1)","0.50 x indice");
        $this->pdf->Add_garantie(utf8_decode("- Défense civile et recours (article 40)"),"Garanti","CG et TG (1)","0.50 x indice");


        if ($devis[0]->type_product == 1)
        {
            $this->pdf->Add_garantie("TITRE IX - RISQUES DIVERS","","","");
            $this->pdf->Add_garantie("- Protection juridique étendue (article 44)",format_garantie($product['in_etat_protectionjuridique'],0),"CG et TG (1)","néant");
            $this->pdf->Add_garantie("- Assistance au domicile (article 45)","Garanti","CG et TG (1)","néant");
            $this->pdf->Add_garantie("- Catastrophes technologiques suivant clause","Garanti","CG et TG (1)","néant");

            $this->pdf->Add_garantie("EXTENSIONS DE GARANTIES","","","");
            $this->pdf->Add_garantie("- Dommages à la piscine",format_garantie(-1),"","");
            $this->pdf->Add_garantie("- Dépendances",format_garantie($product['in_nombre_dependances'],0),"","");
            $this->pdf->Add_garantie("- Véranda",format_garantie($product['in_coef_brisdeglaces_veranda'], 0),"","");
            $this->pdf->Add_garantie("- Panneaux solaires ou photovoltaiques",format_garantie($product['in_nombre_panneaux'], 0),"","");
            $this->pdf->Add_garantie("- Assitance maternelle ou gardienne d'enfants",format_garantie($product['in_coef_extensions_RC_2']),"","");
            $this->pdf->Add_garantie("- RC chien si plus d'un animal",format_garantie($product['in_nombre_chienssansdanger'],0),"","");
            $this->pdf->Add_garantie("- RC chien dangeureux (loi du 6/01/1999)",format_garantie($product['in_nombre_chiensavecdanger'], 0),"","");
            $this->pdf->Add_garantie("- Responsabilité civile cheval, poney, âne",format_garantie($product['in_nombre_chevaux'], 0),"","");
            $this->pdf->Add_garantie("- Responsabilité civile piscine",format_garantie($product['in_coef_extensions_RC_1']),"","");
            $this->pdf->Add_garantie("- RC plan d'eau de moins de 1 Ha",format_garantie($product['in_coef_extensions_RC_4']),"","");
            $this->pdf->Add_garantie("- Responsabilité civile terrains non bâtis",format_garantie($product['in_nombre_terrains'],0),"","");
            $this->pdf->Add_garantie("- Aide bénèvole",format_garantie($product['in_coef_extensions_RC_0']),"","");
            $this->pdf->Add_garantie("- RC personne handicapée mentale",format_garantie($product['in_coef_extensions_RC_3']),"","");
        }

        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->MultiCell(190,5,utf8_decode("
(1) On entend par : 
- TG le tableau des garanties module VITALIA P-1003-06/2009
- CG  les conditions générales du contrat modèle VITALIA P-1003-06/2009"));

//---------------------------------------------------------------------------//
//-----------------------------------DISPOSITIONS----------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->Table_entete(utf8_decode("Dispositions particulières"));
        $this->pdf->Ln();

        $this->pdf->SetFont('Arial','',9);

        $this->pdf->Cell(50,5,utf8_decode("AUTORITE DE CONTRÔLE :"),0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->MultiCell(183,5,utf8_decode("L'autorité chargée du contrôle de la CMAM est :
Autorité de contrôle prudentiel - 61, rue Taitbout - 75009 PARIS."),0,false);
        $this->pdf->Ln();

        $this->pdf->Cell(50,5,"LE SOUSCRIPTEUR DECLARE :",0,0,'L',true);
        $this->pdf->Ln();
        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->MultiCell(183,5,
            utf8_decode("- Que les déclarations qui constituent la base du contrat sont à sa connaissance exactes en sachant que toute omission ou fausse déclaration peut entraïner les sanctions prévues aux articles L113-8 (nullité du contrat) et L113-9 (réduction des indemnités) du Code des assurances.
- Savoir que, conformément à la loi INFORMATIQUE et LIBERTES du 06 janvier 1978, le sociétaire a le droit d'accés et de rectification pour toutes les informations le concernant sur les fichiers des sociétés CAISSE MEUSIENNE D'ASSURANCES MUTUELLES et CFDP en s'adressant à leur siège.
- Outre les exclusions mentionnées aux dispositions générales et aux conditions particulières de votre contrat, est exclue, toute responsabilité, réelle ou prétendue, afférente à des sinistres directement ou indirectement dus ou causés par l'amiante et/ou le plomb ou par tout matériau contenant de l'amiante et/ ou du plomb sous quelque forme et en quantité que ce soit."),0,false);

        $select_clauses = explode(",",$clauses);

        $this->pdf->Display_clause($all_clauses, $select_clauses, "C27");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "M10");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C24");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C29");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C23");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "M09");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "M14");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "M15");

        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->MultiCell(183,5,
            utf8_decode("- Que les biens a assurer ne se situent pas dans un bâtiment de plus de 28 mètres de hauteur.
- Que le bâtiment assuré n'est ni un chateau ni un bâtiment inoccupé.
- Qu'il n'a pas connaissance de faits dommageables survenus avant la rédaction du présent document engageant sa responsabilité civile et susceptibles de faire l'objet d'une réclamation par un tiers. Il n'a aucun litige en cours avec un tiers.
- Qu'il a bien été informé que toute modification intervenant dans son habitation (en matière de capitaux ou d'aggravation) doit faire l'objet d'une déclaration auprès de son assureur afin de lui apporter le conseil et les modifications nécessaires à son contrat."),0,false);

        $this->pdf->Ln(7);
        $this->pdf->MultiCell(183,5,utf8_decode("
- Qu'il a bien été informé que toute modification intervenant dans son habitation (en matière de capitaux ou d'aggravation) doit faire l'objet d'une déclaration auprès de son assureur afin de lui apporter le conseil et les modifications nécessaires à son contrat."),0,false);
        $this->pdf->Display_clause($all_clauses, $select_clauses, "M06");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "M07"); $this->pdf->Display_clause($all_clauses, $select_clauses, "C15");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C1115");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "M05");

        $this->pdf->Display_clause($all_clauses, $select_clauses, "C18", $proposant['in_risk_residence'] == "Résidence secondaire"); $this->pdf->Display_clause($all_clauses, $select_clauses, "C19", $proposant['in_risk_residence'] == "Résidence secondaire");

        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->MultiCell(183,5,
            utf8_decode("- Que le bâtiment est construit à plus de 50 % en matèriaux durs et couvert à plus de 90 % en matèriaux durs tels que définis aux conditions générales de votre contrat."),0,false);

        $this->pdf->Display_clause($all_clauses, $select_clauses, "C02");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C03");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C28");

        /*
        - Que l'ann?e de construction du b?timent est ant?rieure ? 1948
        - Que l'ann?e de construction du b?timent est post?rieure ? 1948
        */

        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->Ln(5);
        $this->pdf->MultiCell(183,5,
            utf8_decode("- Que les bâtiments assurés ou abritant les objets assurés peuvent renfermer une activité professionnelle définie sous le chapitre aggravation. Cette activité peut occuper plus du quart du volume du bâtiment assuré, mais pas plus de la moitié de ce dernier.
- Que le bâtiment assuré n'est pas classé monument historique ou répertorié à l'inventaire des batiments de France
- Que le risque assuré n'est pas situé à plus de 100 mêtres de toute habitation.
- Que le risque assuré n'a pas été résilié par le précèdent assureur.
- Que les biens à assurer ne sont pas contigus ou voisins avec des risques aggravant 
 (discothèque, travail du bois, plasturgie, ...).
- Avoir reçu la fiche d'information sur le fonctionnement de la garantie responsabilité civile dans le temps réf FIRC1103.
- Que le risque assuré est en bon état d'entretien et qu'il s'engage à le maintenir dans ce bon état
d'entretien.
- Concernant les garanties des catastrophes technologiques, conformément à la loi n° 2003-699 du 30 juillet 2003 et aux articles L128-1 et suivants du code des assurances, nous garantissons les dommages matèriels subis par vos biens mobiliers et immobiliers, à usage d'habitation, dans les limites prévues aux conditions particulières de votre contrat.
- Que le risque assuré ne renferme pas de fourrage."),0,false);


        $this->pdf->Display_clause($all_clauses, $select_clauses, "C08");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C09");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C10");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C07");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C11");
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C12");
        $this->pdf->SetLeftMargin(5,0);
        $this->pdf->Display_clause($all_clauses, $select_clauses, "C04");

        /*

         Les autres garanties ?dict?es aux dispositions g?n?rales r?f?rence VITALIA P-1003-06/2009 ne
        peuvent ?tre souscrites pour un propri?taire non occupant.
        */

        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->MultiCell(183,5,utf8_decode("- Que sauf dérogation définie à la rubrique aggravation VOL, les locaux assurés (ou renfermant les objets assurés sont entièrement clos, toutes les portes donnant accés sur l'extèrieur possèdent au moins deux moyens de fermeture (serrure plus verrou, 2 verrous, serrure multipoints), chaque ouverture du sous-sol et du rez-de-chaussée est protégée par des volets, des persiennes ou des barreaux, les locaux à assurer ne sont pas inoccupés plus de 90 jours par an et ne sont pas à usage de résidence secondaire."),0,false);

        $this->pdf->Display_clause($all_clauses, $select_clauses, "C20");

        $this->pdf->Cell(7,5,"",0,0,'L',true);
//$pdf->MultiCell(183,5,"(1) on entend par :
//	- TG le tableau des garanties modèle VITALIA P-1003-06/2009
//	- CG les Conditions générales du contrat modèle VITALIA P-1003-06/2009",0,false);

        $this->pdf->Display_clause($all_clauses, $select_clauses, "C14");

        function isset_clause($select_clauses, $clause)
        {
            $ret = 0;
            for ($i=0;$i<sizeof($select_clauses);$i++)
            {
                if ($select_clauses[$i] == $clause)
                    $ret = 1;
            }
            return $ret;
        }

        $this->pdf->SetFont('Arial','',9);

        if (preg_match('/ECO/',$devis[0]->formule))
        {
            if (isset_clause($select_clauses, "R06"))
                $this->pdf->MultiCell(183,5,"Par dérogation au tableau récapitulatif des garanties dans la formule ECO, le capital garanti en mobilier est ramené à 3,50 fois l'indice par pièce principale assurée avec un maximum de 70 fois l'indice pour l'ensemble du bien assuré.",0,false);
            else if (isset_clause($select_clauses, "M02"))
                $this->pdf->MultiCell(183,5,"Par dérogation au tableau récapitulatif des garanties dans la formule ECO, le capital garanti en mobilier est porté à 10,50 fois l'indice par pièce principale assurée avec un maximum de 70 fois l'indice pour l'ensemble du bien assuré.",0,false);
            else if (isset_clause($select_clauses, "M03"))
                $this->pdf->MultiCell(183,5,"Par dérogation au tableau récapitulatif des garanties dans la formule ECO, le capital garanti en mobilier est porté à 14 fois l'indice par pièce principale assurée avec un maximum de 70 fois l'indice pour l'ensemble du bien assuré.",0,false);
            else
                $this->pdf->MultiCell(183,5,"Le contenu assuré en mobilier est défini au tableau récapitulatif des garanties dans la formule ECO, soit un montant égal à 7 fois l'indice par pièce principale assurée avec un maximum de 70 fois l'indice pour l'ensemble du bien assuré.",0,false);

        } elseif (preg_match('/CONFORT/',$devis[0]->formule))
        {
            if (isset_clause($select_clauses, "R06"))
                $this->pdf->MultiCell(183,5,"Par dérogation au tableau récapitulatif des garanties dans la formule CONFORT, le capital garanti en mobilier est ramené à 6 fois l'indice par pièce principale assurée avec un maximum de 60 fois l'indice pour l'ensemble du bien assuré.",0,false);
            else if (isset_clause($select_clauses, "M02"))
                $this->pdf->MultiCell(183,5,"Par dérogation au tableau récapitulatif des garanties dans la formule CONFORT, le capital garanti en mobilier est porté à 18 fois l'indice par pièce principale assurée avec un maximum de 180 fois l'indice pour l'ensemble du bien assuré.",0,false);
            else if (isset_clause($select_clauses, "M03"))
                $this->pdf->MultiCell(183,5,"Par dérogation au tableau récapitulatif des garanties dans la formule CONFORT, le capital garanti en mobilier est porté à 24 fois l'indice par pièce principale assurée avec un maximum de 240 fois l'indice pour l'ensemble du bien assuré.",0,false);
            else
                $this->pdf->MultiCell(183,5,"Le contenu assuré en mobilier est défini au tableau récapitulatif des garanties dans la formule CONFORT soit un montant égal à 12 fois l'indice par pièce principale assurée avec un maximum de 120 fois l'indice pour l'ensemble du bien assuré.",0,false);

        } elseif (preg_match('/PRESTIGE/',$devis[0]->formule))
        {
            if (isset_clause($select_clauses, "R06"))
                $this->pdf->MultiCell(183,5,"Par dérogation au tableau récapitulatif des garanties dans la formule PRESTIGE, le capital garanti en mobilier est ramené à 10 fois l'indice par pièce principale assurée avec un maximum de 100 fois l'indice pour l'ensemble du bien assuré.",0,false);
            else if (isset_clause($select_clauses, "M02"))
                $this->pdf->MultiCell(183,5,"Par dérogation au tableau récapitulatif des garanties dans la formule PRESTIGE, le capital garanti en mobilier est porté à 30 fois l'indice par pièce principale assurée avec un maximum de 300 fois l'indice pour l'ensemble du bien assuré.",0,false);
            else if (isset_clause($select_clauses, "M03"))
                $this->pdf->MultiCell(183,5,"Par dérogation au tableau récapitulatif des garanties dans la formule PRESTIGE, le capital garanti en mobilier est porté à 40 fois l'indice par pièce principale assurée avec un maximum de 400 fois l'indice pour l'ensemble du bien assuré.",0,false);
            else
                $this->pdf->MultiCell(183,5,"Le contenu assuré en mobilier est dèfini au tableau récapitulatif des garanties dans la formule PRESTIGE soit un montant égal à 20 fois l'indice par pièce principale assurée avec un maximum de 200 fois l'indice pour l'ensemble du bien assuré.",0,false);
        } elseif (preg_match('/PNO/',$devis[0]->formule))
        {
            $this->pdf->MultiCell(183,5,"Les autres garanties édictées aux dispositions générales réfèrence VITALIA P-1003-06/2009 ne peuvent être souscrites pour un propriètaire non occupant.",0,false);
        } else {}
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->Cell(183,5,utf8_decode("								- Particularité batiment à usage locatif :"),0,0,'L',true);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Ln();
        $this->pdf->Cell(7,5,"",0,0,'L',true);

        $this->pdf->MultiCell(183,5,utf8_decode("L'assuré a déclaré que le bâtiment garanti est loué, moyennant un (des) bail (baux) locatif(s) écrit sans renonciation à recours contre l'occupant et ses assureurs. Il est convenu qu'au cas où un sinistre surviendrait dans les locaux loués et qu'aucun bail locatif ne serait applicable, l'assuré conserverait à sa charge une franchise équivalant à 50 % du montant du sinistre.
Les locaux ne sont pas occupés toute l'année. La garantie VOL VANDALISME est accordée pendant la période d'inhabitation qui n'excède pas 6 mois.
"),0,false);

        $this->pdf->Ln(1);
        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->MultiCell(183,5,utf8_decode("Le présent contrat a été réalisé auprès de la société CMAM (Caisse Meusienne d'Assurances Mutuelles), société d'Assurance Mutuelle à cotisations variables contre l'incendie et les risques divers, régie par le code des Assurances et sise 22, rue du Docteur NEVE BP40056, 55001 BAR LE DUC Cedex pour les garanties dommages et auprès de la société CFDP, Compagnie d'Assurances spécialisée en Protection Juridique, régie par le codes des Assurances et sise 1 Place Francisque Regaud, 69002 LYON pour la garantie Protection Juridique."),0,false);

        $this->pdf->Ln(1);
        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->MultiCell(183,5,utf8_decode("Le présent contrat est reconduit tacitement d'année en année, sauf résiliation à l'échéance annuelle, moyennant préavis de 2 mois minimum."),0,false);

        $this->pdf->Ln(1);
        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->MultiCell(183,5,utf8_decode("Vous pouvez également, conformément à la loi 2014-344, à l'expiration d'un délai d'un an à compter de la première souscription, résilier votre contrat sans pénalité. La résiliation prend effet un mois après que nous en aurons reçu notification par votre nouvel assureur en cas de contrat automobile ou de contrat habitation locataire, par vous-même dans les autres cas."),0,false);

        $this->pdf->Ln(0);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(7,5,"",0,0,'L',true);
        $this->pdf->Cell(183,5,utf8_decode("Cette faculté n'est accessible qu'aux seules personnes physiques et en dehors de toute activité professionnelle."),0,0,'L',true);
        $this->pdf->Ln();

//----------------------------------------------------------------------------------//
//-----------------------------Réclamation et Litiges------------------------------//
//--------------------------------------------------------------------------------//

        $this->pdf->AddPage();
        $this->pdf->SetLeftMargin(10,0);
        $this->pdf->Table_entete(utf8_decode("Réclamation et Litiges :"));
        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,190,40);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(24,5,utf8_decode("Réclamation:"),0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(158,5,utf8_decode("Toute réclamation doit être adressée en premier lieu par courrier ou par e-mail à l'adresse suivante :"),0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(170,5, utf8_decode("Groupe corim assurance - Service réclamations - 37, rue des Mathurins - 75008 Paris "),0,'C',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(125,5,utf8_decode("Email: reclamations@groupecorim.fr"),0,'C',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(15,5,utf8_decode("Litiges:"),0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(190,5,utf8_decode("Personne ou société à qui devront être signifiés les actes judiciaires en cas de procédure contentieuse engagée à l'encontre des Assureurs:"),0,false);
        $this->pdf->Cell(170,5,utf8_decode("GROUPE CORIM ASSURANCES - 37, rue des mathurins - 75008 PARIS - www.groupecorim.fr"),0,'C',true);
        $this->pdf->Ln();

//----------------------------------------------------------------------------------//
//-----------------------------Informations légales------------------------------//
//--------------------------------------------------------------------------------//

        $this->pdf->Table_entete(utf8_decode("Informations légales :"));
        $x=$this->pdf->GetX();
        $y=$this->pdf->GetY();
        $this->pdf->Rect($x,$y,190,40);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(185,5,utf8_decode("Toutes omission ou déclaration inexacte vous expose à supporter tout ou partie des conséquences d'un sinistre comme précisé \n aux articles L.113-8 (nullité du contrat) et L.113-9 (réduction des indemnités) du Code des Assurances."),0,'L',false);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(50,5, utf8_decode("Loi << informatique et liberté >>"),0,'L',true);
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(190,5,utf8_decode("Les informations recueillies font l'objet d'un traitement informatique destiné à gérer vos contrats d'asurance souscrits par notre\n intermédiare. Les destinataires des données sont le courtier souscripteur et la compagnie qui couvrent le risque.\n Conformément à la loi << informatique et libertés >> du 6 janvier 1978 modifiée en 2004, vous bénéficiez d'un droit d'accés et de \n rectification aux informations qui vous concernent, que vous pouvez exercer en nous adressant votres demande par mail."),0,false);
        /*
       - Que le risque assur? est en bon ?tat d'entretien et qu'il s'engage ? le maintenir dans ce bon ?tat d'entretien.
       - Que les b?timents assur?s ou abritant les objets assur?s peuvent renfermer une activit? professionnelle d?finie sous le chapitre aggravation. Cette activit? peut occuper plus du quart du volume du b?timent assur?, mais pas plus de la moiti? de ce dernier.
       - Que le b?timent assur? n'est pas class? monument historique ou r?pertori? ? l'inventaire des b?timents de France.
       - Que le b?timent assur? n'est pas situ? ? plus de 100 m?tres de toute habitation.
       - Que le risque assur? n'a pas ?t? r?sili? par le pr?c?dent assureur.
       - Que le risque assur? ne renferme pas de fourrage.
       - Que le b?timent est construit ? plus de 50 % en mat?riaux durs et couvert ? plus de 90 % en mat?riaux durs tels que d?finis aux conditions g?n?rales de votre contrat.
       - Qu'il n'a pas ?t? victime au cours des 24 derniers mois d'un ou plusieurs sinistres de dommages aux biens ou de responsabilit? entrant dans le champ des garanties du pr?sent contrat.
       - Que les biens ? assurer ne se situent pas dans un b?timent de plus de 28 m?tres de hauteur.
       - Que le risque assur? ne renferme pas ou n'est pas contigu avec une activit? industrielle ou de travail du bois ou de transformation du plastique ou encore avec une discoth?que, une bo?te de nuit, un dancing, un cabaret ou un bowling.
       - Que le b?timent assur? n'est ni un ch?teau ni un b?timent inoccup?.
              - Que sauf d?rogation d?finie ? la rubrique aggravation VOL :
              - Les locaux assur?s (ou renfermant les objets assur?s) sont enti?rement clos,
              - Toutes les portes donnant acc?s sur l'ext?rieur poss?dent au moins deux moyens de fermeture (serrure plus
                verrou, 2 verrous, serrure multipoints),
              - Chaque ouverture du sous-sol et du rez-de-chauss?e est prot?g?e par des volets, des persiennes ou des
                barreaux.
              - Les locaux ? assurer ne sont pas inoccup?s plus de 90 jours par an et ne sont pas ? usage de r?sidence
                secondaire.
       - Qu'il n'a pas connaissance de faits dommageables survenus avant la r?daction du pr?sent document engageant sa responsabilit? civile et susceptibles de faire l'objet d'un r?clamation par un tiers. Il n'a aucun litige en cours avec un tiers.
       - Que les d?clarations qui constituent la base du contrat sont ? sa connaissance exactes en sachant que toute omission ou fausse d?claration peut entra?ner les sanctions pr?vues aux articles L113-8 (nullit? du contrat) et L113-9 (r?duction des indemnit?s) du Code des assurances.
       - Savoir que, conform?ment ? la loi INFORMATIQUE et LIBERTES du 06 janvier 1978, le soci?taire a le droit d'acc?s et de rectification pour toutes les informations le concernant sur le fichier de la soci?t? CAISSE MEUSIENNE D'ASSURANCES MUTUELLES en s'adressant ? son si?ge.
       - Qu'il a bien ?t? inform? que toutes modification intervenant dans son habitation (en mati?re de capitaux ou d'aggravation) doit faire l'objet d'une d?claration aupr?s de son assureur afin de lui apporter le conseil et les modifications n?cessaires ? son contrat.
       - Avoir re?u les pi?ces qui composent le contrat ? savoir : les dispositions g?n?rales VITALIA mod?le P-1003-06/2009, le cas ?ch?ant les annexes sp?cifiques (annexe PJ et annexe Assistance), les statuts de la soci?t? et un devis pr?alable ? l'?laboration du pr?sent contrat.


       */



//---------------------------------SIGNATURE---------------------------------//
//---------------------------------------------------------------------------//
        $this->pdf->Ln(6);
        $this->pdf->Cell(200,5,utf8_decode("Pour le sociètaire                                          Fait à                                   , le                                            Pour la société"),0,0,'L',true);
        $this->pdf->Ln(5);
        $this->pdf->Cell(200,20,$this->pdf->Image(storage_path() .'../../public/images/signature.png',$this->pdf->GetX()+138,$this->pdf->GetY(),30),0,0,'L');

        if ($devis[0]->type_product == 1)
        {
        } else if ($devis[0]->type_product == 2) {
            if ($product['in_nombre_baux'] > 0) {
                $this->pdf->AddPage();

                //$pdf->SetFont('Arial','I',8);
                //$pdf->Cell(95,5,"(Option Protection Juridique)",0,0,'L',false);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->Cell(190,5,''.$proposant['in_customer_sigle'].' '.$proposant['in_customer_prenom'].' '.$proposant['in_customer_nom'].'     ',0,0,'R',true);


                $this->pdf->Ln();
                $this->pdf->Cell(60,5,utf8_decode("Contrat n°".str_replace("PR","PJ",display_id_contrat($devis[0]->id_contrat))." sur devis n°".$devis[0]->id.""),0,0,'L',true);
                $this->pdf->SetFont('Arial','B',10);
                $this->pdf->Cell(70,5,"(Option Protection Juridique)",0,0,'C',false);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->Cell(60,5,''.$proposant['in_customer_adresse'].'     ',0,0,'R',true);


                $this->pdf->Ln();
                $this->pdf->Cell(95,5,strtoupper('ASSURANCE PROTECTION JURIDIQUE'),0,0,'L',true);
                $this->pdf->Cell(95,5,''.$proposant['in_customer_codepostal'].' '.$proposant['in_customer_ville'].'     ',0,0,'R',true);
                $this->pdf->Ln();

                $this->pdf->Table_entete_green(utf8_decode("Conditions particuliéres"));
                $this->pdf->Ln();

                $this->pdf->Cell(190,5,utf8_decode("Ce document a été établi sur la base de vos déclarations et concrétise nos engagements réciproques."),0,0,'L',true);
                $this->pdf->Ln();

                $this->pdf->Table_entete_green("Le souscripteur");
                $this->pdf->Ln();

                $this->pdf->Cell(40,5,"Situation du risque :",0,0,'L',true);
                $this->pdf->Cell(95,5,$proposant['in_risk_adresse'],0,0,'L',true);
                $this->pdf->Ln();
                $this->pdf->Cell(40,5,"",0,0,'L',true);
                if (($product['in_coef_zone'] + 1) < 10)
                    $codepostal_risque = '0'.($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];
                else
                    $codepostal_risque = ($product['in_coef_zone'] + 1).$proposant['in_risk_codepostal'];

                $this->pdf->Cell(95,5,''.$codepostal_risque.' '.$proposant['in_risk_ville'].'',0,0,'L',true);
                $this->pdf->Ln();

                $this->pdf->Cell(35,5,utf8_decode("Surface développée :"),0,0,'L',true);
                $this->pdf->Cell(70,5,$product['in_nombre_surface']." m2",0,0,'L',true);
                $this->pdf->Ln();

                $this->pdf->Table_entete_green(utf8_decode("Eléments de cotisation"));
                $this->pdf->Ln();

                $this->pdf->Cell(50,5,"Date et heure d'effet :",0,0,'L',true);
                $this->pdf->Cell(60,5,utf8_decode(date("d/m/Y à 00:00", $devis[0]->date_contract)),0,0,'L',true);
                $this->pdf->Cell(40,5,"Cotisation annuel HT :",0,0,'R',true);
                $this->pdf->Cell(40,5, format_tarif($protection_juridique_ht).chr(128),0,0,'R',true);
                $this->pdf->Ln();

                $this->pdf->Cell(50,5,utf8_decode("Echéance principale :"),0,0,'L',true);
                $this->pdf->Cell(60,5,date("d/m", $devis[0]->date_contract),0,0,'L',true);
                $this->pdf->Cell(40,5,"Frais et accessoires HT :",0,0,'R',true);
                $this->pdf->Cell(40,5,format_tarif("20").chr(128),0,0,'R',true);
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
                $this->pdf->Cell(40,5,"Taxes annuelles :",0,0,'R',true);
                $this->pdf->Cell(40,5, format_tarif($protection_juridique_taxes) .chr(128),0,0,'R',true);
                $this->pdf->Ln();

                $this->pdf->Cell(50,5,"Indice IRL :",0,0,'L',true);
                $this->pdf->Cell(60,5,"",0,0,'L',true);
                $this->pdf->Cell(40,5,"Cotisation TTC annuelle :",0,0,'R',true);
                $this->pdf->Cell(40,5, format_tarif($protection_juridique_sans_taxes + 20).chr(128),0,0,'R',true);
                $this->pdf->Ln();

                $this->pdf->Table_entete_green("Garanties souscrites");
                $this->pdf->Ln();

                $this->pdf->MultiCell(190,5,utf8_decode("Le syndicat des copropriètaires, représenté par son syndic, bénéficie d'une garanrie de Protection Juridique, telle que définie aux conditions générales, Ref: ALSINA CG Copro 2015 V01-2015"),0,false);
                $this->pdf->MultiCell(190,5,utf8_decode("LES MONTANTS CONTRACTUELS DE PRISE EN CHARGE:\nPlafond maximum de prise en charge par litige: 19 452 ").chr(128) .utf8_decode(" TTC \nDont plafond pour démarches amiables: 650 ").chr(128)."\nDont plafond pour expertises judiciaires: 5 261 ".chr(128)."\nSeuil d'intervention: 541 ".chr(128)."\nFranchise: 0 ".chr(128)."",1,'L',false);

                $this->pdf->Table_entete_green(utf8_decode("Dispositions particulières"));
                $this->pdf->Ln();

                $this->pdf->MultiCell(190,5,utf8_decode("L'autorité chargée du contrôle de la CFDP est : Autorité de contrôle prudentiel - 61, rue Taitbout - 75009 PARIS. Le présent contrat a été réalisé auprès de la société CFDP, Compagnie d'Assurances spécialisée en Protection Juridique, sise 1 Place Francisque Régaud - 69002 LYON.\nLe présent contrat est reconduit tacitement d'année en année, sauf résiliation à l'échéance annuelle, moyennant préavis de 2 mois minimum."),0,false);
                $this->pdf->Ln();

                $this->pdf->Cell(200,5,utf8_decode("Pour le souscripteur                                          Fait à                                   , le                                            Pour la société"),0,0,'L',true);
                $this->pdf->Ln(4);
                $this->pdf->Cell(200,20,$this->pdf->Image(storage_path() .'../../public/images/signature.png',$this->pdf->GetX()+138,$this->pdf->GetY(),30),0,0,'L');
            }
        }

//---------------------------------------------------------------------------//
//---------------------------------OUTPUT------------------------------------//
//---------------------------------------------------------------------------//

        $this->pdf->Output();
    }
}

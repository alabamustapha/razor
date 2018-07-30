<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarificateurBatiment extends Model
{
    public $table = "devis";
    
    protected $fillable = [
        'id_contrat', 'affiliate_users', 'status', 'type_product', 'data_product', 'data_proposant', 'custumer_nom', 'tarificateur_amount', 'costumer_amount', 'partner_amount', 'affiliate_amount', 'costumer_amount_rc', 'periodicity', 'formule', 'clause', 'affiliate_lastname', 'affiliate_firstname', 'affiliate_company', 'affiliate_address', 'affiliate_city', 'affiliate_zip', 'affilaite_email', 'affiliate_orias', 'affiliate_tel', 'affiliate_ref'
    ];

    public static function display_select($tab, $name, $multiple = 0, $value = 0)
    {

        $ret = '<select name="'.$name.'" style="width:190px;" class="form-control"';
        if ($multiple)
            $ret .= 'multiple="multiple" size="'.sizeof($tab['designation']).'"';
        $ret .= '>';
        for ($i = 0; $i < sizeof($tab['designation']); $i++)
        {
            $ret .= '<option value="'.$i.'"';
            if ($i == $value) { $ret .= ' selected'; }
            $ret .= '>'.$tab['designation'][$i].'</option>';
        }
        $ret .= '</select>';

        return $ret;
    }

    public static function display_select1($tab, $name, $value, $multiple = 0)
    {

        $ret = '<select name="'.$name.'" style="width:190px;" class="form-control"';
        if ($multiple)
            $ret .= 'multiple="multiple" size="'.sizeof($tab['designation']).'"';
        $ret .= '>';
        for ($i = 0; $i < sizeof($tab['designation']); $i++)
        {
            $ret .= '<option value="'.$i.'"';
            if ($i == $value) { $ret .= ' selected'; }
            $ret .= '>'.$tab['designation'][$i].'</option>';
        }
        $ret .= '</select>';

        return $ret;
    }

    public static function display_radio($tab, $name, $valuetab = 0){

        $ret = '';
        for ($i = 0; $i < sizeof($tab['designation']); $i++)
        {
            $ret .= '<input type="radio" name="'.$name.'_'.$i.'" id="'.$name.'_'.$i.'_yes" value="'.$i.'"';
            if ($valuetab[$i])
                $ret .= ' checked';
            $ret .= '> Oui <input type="radio" name="'.$name.'_'.$i.'" id="'.$name.'_'.$i.'_no" value="-1"';
            if (!$valuetab[$i])
                $ret .= ' checked> Non &nbsp;&nbsp;&nbsp;';
            $ret .= $tab['designation'][$i].'<br>';
        }
        return $ret;
    }

    public static function display_radio1($tab, $name, $valuetab){

        $ret = '';
        for ($i = 0; $i < sizeof($tab['designation']); $i++)
        {
            $ret .= '<input type="radio" name="'.$name.'_'.$i.'" id="'.$name.'_'.$i.'_yes" value="'.$i.'"';
            if ($valuetab[$i])
                $ret .= ' checked';
            $ret .= '> Oui <input type="radio" name="'.$name.'_'.$i.'" id="'.$name.'_'.$i.'_no" value="-1"';
            if (!$valuetab[$i])
                $ret .= ' checked> Non &nbsp;&nbsp;&nbsp;';
            $ret .= $tab['designation'][$i].'<br>';
        }
        return $ret;
    }

    function status_to_label($id_status)
    {
        $status = array(
            100	=>	"Devis généré",
            10	=>	"En attente de retour du devis",
            11	=>	"Pas de retour du client sur devis",
            20	=>	"Retour du client sur devis",
            21	=>	"Choix formule PNO",
            22	=>	"Choix formule ECO",
            23	=>	"Choix formule CONFORT",
            24	=>	"Choix formule PRESTIGE",
            25	=>	"Choix date d'effet",
            26	=>	"Choix périodicité",
            27	=>	"Devis accepté",
            28  =>  "Choix formule PNE",
            30	=>	"Contrat généré",
            31	=>	"Devis refus cause prix",
            32	=>	"Devis refus cause clauses",
            33	=>	"Devis refus cause délais",
            34	=>	"Devis refus cause nouveau devis",
            35	=>	"Devis annulé",
            50	=>	"Lettre d'envoi générée",
            60	=>	"Attestation d'assurance générée",
            70	=>	"Autorisation de prélévement générée"
        );



        return $status[$id_status];
    }

    public static function display_last_status($all_status)
    {
        $home = New self;
        $tmp = explode(";", $all_status);
        //$tmp2 = explode("-", $tmp[sizeof($tmp) - 2]);
        $tmp2 = explode("-", $tmp[sizeof($tmp) - 2]);

        return $home->status_to_label($tmp2[0])." ".date("d/m/Y H:i", $tmp2[1]);
        //return \App\Models\Home::status_to_label($tmp2[0]);
    }

    public static function type_to_label($type_product)
    {
        if ($type_product == 1)
            return "habitation";
        else if ($type_product == 2)
            return "batiment";
        else if ($type_product == 3)
            return "pne";
        else if ($type_product == 4)
            return "batiment";
        else
            return "N/A";
    }
    public static function format_tarif($value)
    {
        return sprintf('%.2f',round($value, 2));
    }

    public static function search_status($all_status, $status)
    {
        if (preg_match("/".$status."/i", $all_status))
            return 1;
        else
            return 0;
    }

    public static function display_all_status($all_status)
    {
        $home = New self;
        $ret = "<ul>";
        $tmp = explode(";", $all_status);
        for($i = 0; $i < sizeof($tmp) -1; $i++)
        {
            $tmp2 = explode("-", $tmp[$i]);
            $ret .= "<li>".$home->status_to_label($tmp2[0])." le ".date("d/m/Y à H:i", $tmp2[1])."</li>";
        }
        $ret .= "</ul>";

        return $ret;
    }

    public static function status_to_label1($id_status)
    {
        $status = array(
            100	=>	"Devis généré",
            10	=>	"En attente de retour du devis",
            11	=>	"Pas de retour du client sur devis",
            20	=>	"Retour du client sur devis",
            21	=>	"Choix formule PNO",
            22	=>	"Choix formule ECO",
            23	=>	"Choix formule CONFORT",
            24	=>	"Choix formule PRESTIGE",
            25	=>	"Choix date d'effet",
            26	=>	"Choix périodicité",
            27	=>	"Devis accepté",
            28  =>  "Choix formule PNE",
            30	=>	"Contrat généré",
            31	=>	"Devis refus cause prix",
            32	=>	"Devis refus cause clauses",
            33	=>	"Devis refus cause délais",
            34	=>	"Devis refus cause nouveau devis",
            35	=>	"Devis annulé",
            50	=>	"Lettre d'envoi générée",
            60	=>	"Attestation d'assurance générée",
            70	=>	"Autorisation de prélévement générée"
        );



        return $status[$id_status];
    }
    public static function display_id_contrat($value)
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
    public static function calcul_customer_amount($value, $marge)
    {
        return ($value * 0.83 * 1.1 * $marge);
    }

    public static function calcul_partner_amount($value)
    {
        return ($value * 0.73);
    }

    public static function calcul_affiliate_amount($value, $marge)
    {
        return ($value * 0.83 * 1.1 * ($marge - 1));
    }

    public static function calcul_customer_amount_groupama($value, $marge)
    {
        return ($value * $marge);
    }

    public static function calcul_partner_amount_groupama($value)
    {
        return ($value * 0.73);
    }

    public static function calcul_affiliate_amount_groupama($value, $marge)
    {
        return ($value * ($marge - 1));
    }

    public static function clean_clauses($clauses)
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

    public function user()
    {
        return $this->belongsTo('Laravel\Models\User');
    }

    public function getDataProposantAttribute($value)
    {
        return unserialize($value);
    }
    public function getDataProductAttribute($value)
    {
        // return unserialize($value);
        return $value;
    }

    public function getCalculationsAttribute()
    {
        $calculations = [];

        $calculations['frais_et_accessoires_ht'] = ($this->customer_amount * 0.4);

        $calculations['cotisation_fonds_garantie'] = 3.30;

        $calculations['cotisation_risques_technologiques_ht'] = 2.75;

        $calculations['cotisation_risques_technologiques_taxe'] = $calculations['cotisation_risques_technologiques_ht'] * 0.09;

        $calculations['cotisation_incendie_ht'] = ($this->customer_amount * 0.6 - $this->customer_amount_rc - $calculations['cotisation_fonds_garantie'] - $calculations['cotisation_risques_technologiques_ht'] - $calculations['cotisation_risques_technologiques_taxe']) * 0.3 / 1.3;

        $calculations['cotisation_incendie_taxe'] = $calculations['cotisation_incendie_ht'] * 0.3;

        $calculations['solde_taxe_9_ht'] = ($this->customer_amount * 0.6 - $this->customer_amount_rc - $calculations['cotisation_fonds_garantie'] - $calculations['cotisation_risques_technologiques_ht'] - $calculations['cotisation_risques_technologiques_taxe'] - $calculations['cotisation_incendie_ht'] - $calculations['cotisation_incendie_taxe']) / 1.09;

        $calculations['solde_taxe_9_taxe'] = $calculations['solde_taxe_9_ht'] * 0.09;

        $calculations['calcul_ht_9_hors_incendie_attentats_cn'] = (($calculations['cotisation_incendie_ht'] + $calculations['solde_taxe_9_ht']) - $calculations['cotisation_incendie_ht'] * 1.139) / 1.107;

        $calculations['sortie_RC_non_soumise_attentats_cn'] = $calculations['calcul_ht_9_hors_incendie_attentats_cn'] * 0.77;

        $calculations['cotisation_attentats_ht'] = ($calculations['cotisation_incendie_ht'] + $calculations['sortie_RC_non_soumise_attentats_cn']) * 0.017;

        $calculations['cotisation_attentats_taxe'] = $calculations['cotisation_attentats_ht'] * 0.09;

        $calculations['cotisation_cn_ht'] = ($calculations['cotisation_incendie_ht'] + $calculations['cotisation_attentats_ht'] + $calculations['sortie_RC_non_soumise_attentats_cn']) * 0.12;

        $calculations['cotisation_cn_taxe'] = $calculations['cotisation_cn_ht'] * 0.09;

        $calculations['repartition_tgn_ht'] = $calculations['calcul_ht_9_hors_incendie_attentats_cn'] * 0.07;

        $calculations['repartition_tgn_taxe'] = $calculations['repartition_tgn_ht'] * 0.09;

        $calculations['repartition_dommageselectriques_ht'] = $calculations['calcul_ht_9_hors_incendie_attentats_cn'] * 0.21;

        $calculations['repartition_dommageselectriques_taxe'] = $calculations['repartition_dommageselectriques_ht'] * 0.09;

        $calculations['repartition_brisdeglaces_ht'] = $calculations['calcul_ht_9_hors_incendie_attentats_cn'] * 0.07;

        $calculations['repartition_brisdeglaces_taxe'] = $calculations['repartition_brisdeglaces_ht'] * 0.09;

        $calculations['repartition_vol_ht'] = $calculations['calcul_ht_9_hors_incendie_attentats_cn'] * 0.19;

        $calculations['repartition_vol_taxe'] = $calculations['repartition_vol_ht'] * 0.09;

        if ($this->formule == "OPTION PROPRIETAIRE NON OCCUPANT")
            $calculations['repartition_rc_ht'] = $calculations['calcul_ht_9_hors_incendie_attentats_cn'] * 0.05;
        else
            $calculations['repartition_rc_ht'] = $calculations['calcul_ht_9_hors_incendie_attentats_cn'] * 0.21;

        $calculations['repartition_rc_taxe'] = $calculations['repartition_rc_ht'] * 0.09;

        $calculations['repartition_dr_ht'] = $calculations['calcul_ht_9_hors_incendie_attentats_cn'] * 0.02;

        $calculations['repartition_dr_taxe'] = $calculations['repartition_dr_ht'] * 0.09;

        if ($this->formule == "OPTION PROPRIETAIRE NON OCCUPANT")
            $calculations['repartition_degatsdeseaux_ht'] = $calculations['calcul_ht_9_hors_incendie_attentats_cn'] * 0.39 + ($this->customer_amount_rc / 1.09);
        else
            $calculations['repartition_degatsdeseaux_ht'] = $calculations['calcul_ht_9_hors_incendie_attentats_cn'] * 0.23 + ($this->customer_amount_rc / 1.09);

        $calculations['repartition_degatsdeseaux_taxe'] = $calculations['repartition_degatsdeseaux_ht'] * 0.09;

        $calculations['cotisation_ht_annuelle'] = $calculations['cotisation_risques_technologiques_ht'] + $calculations['cotisation_incendie_ht'] + $calculations['cotisation_attentats_ht'] + $calculations['cotisation_cn_ht'] + $calculations['repartition_tgn_ht'] + $calculations['repartition_dommageselectriques_ht'] + $calculations['repartition_brisdeglaces_ht'] + $calculations['repartition_vol_ht'] + $calculations['repartition_rc_ht'] + $calculations['repartition_dr_ht'] + $calculations['repartition_degatsdeseaux_ht'];

        $calculations['taxes_annuelles'] = $calculations['cotisation_risques_technologiques_taxe'] + $calculations['cotisation_incendie_taxe'] + $calculations['cotisation_attentats_taxe'] + $calculations['cotisation_cn_taxe'] + $calculations['repartition_tgn_taxe'] + $calculations['repartition_dommageselectriques_taxe'] + $calculations['repartition_brisdeglaces_taxe'] + $calculations['repartition_vol_taxe'] + $calculations['repartition_rc_taxe'] + $calculations['repartition_dr_taxe'] + $calculations['repartition_degatsdeseaux_taxe'];
        

        return $calculations; 
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarificateurGroupama extends Model
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
}

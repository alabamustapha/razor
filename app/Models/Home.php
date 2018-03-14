<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
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
}

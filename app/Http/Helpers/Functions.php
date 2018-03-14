<?php

function format_tarif($data){
    return sprintf('%.2f', round($data, 2));
}

function display_id_contrat($value){
    if ($value < 10)
        return "PR00000" . $value;
    else if ($value < 100)
        return "PR0000" . $value;
    else if ($value < 1000)
        return "PR000" . $value;
    else if ($value < 10000)
        return "PR00" . $value;
    else if ($value < 100000)
        return "PR0" . $value;
    else
        return "PR" . $value;
}

function type_to_label($type_product){
    if ($type_product == 1)
        return "habitation";
    else if ($type_product == 2)
        return "batiment";
    else if ($type_product == 3)
        return "pne";
    else
        return "N/A";
}

function calculation($res){

    $calculations = [];


    $calculations['frais_et_accessoires_ht'] = ($res->customer_amount * 0.4);

    $calculations['cotisation_fonds_garantie'] = 3.30;

    $calculations['cotisation_risques_technologiques_ht'] = 2.75;
    
    $calculations['cotisation_risques_technologiques_taxe'] = $cotisation_risques_technologiques_ht * 0.09;

    $calculations['cotisation_incendie_ht'] = ($res->customer_amount * 0.6 - $res->customer_amount_rc - $cotisation_fonds_garantie - $cotisation_risques_technologiques_ht - $cotisation_risques_technologiques_taxe) * 0.3 / 1.3;
    
    $calculations['cotisation_incendie_taxe'] = $cotisation_incendie_ht * 0.3;

    $calculations['solde_taxe_9_ht'] = ($res->customer_amount * 0.6 - $res->customer_amount_rc - $cotisation_fonds_garantie - $cotisation_risques_technologiques_ht - $cotisation_risques_technologiques_taxe - $cotisation_incendie_ht - $cotisation_incendie_taxe) / 1.09;
    
    $calculations['solde_taxe_9_taxe'] = $solde_taxe_9_ht * 0.09;

    $calculations['calcul_ht_9_hors_incendie_attentats_cn'] = (($cotisation_incendie_ht + $solde_taxe_9_ht) - $cotisation_incendie_ht * 1.139) / 1.107;
    
    $calculations['sortie_RC_non_soumise_attentats_cn'] = $calcul_ht_9_hors_incendie_attentats_cn * 0.77;

    $calculations['cotisation_attentats_ht'] = ($cotisation_incendie_ht + $sortie_RC_non_soumise_attentats_cn) * 0.017;
    
    $calculations['cotisation_attentats_taxe'] = $cotisation_attentats_ht * 0.09;

    $calculations['cotisation_cn_ht'] = ($cotisation_incendie_ht + $cotisation_attentats_ht + $sortie_RC_non_soumise_attentats_cn) * 0.12;
    
    $calculations['cotisation_cn_taxe'] = $cotisation_cn_ht * 0.09;

    $calculations['repartition_tgn_ht'] = $calcul_ht_9_hors_incendie_attentats_cn * 0.07;
    
    $calculations['repartition_tgn_taxe'] = $repartition_tgn_ht * 0.09;

    $calculations['repartition_dommageselectriques_ht'] = $calcul_ht_9_hors_incendie_attentats_cn * 0.21;
    
    $calculations['repartition_dommageselectriques_taxe'] = $repartition_dommageselectriques_ht * 0.09;

    $calculations['repartition_brisdeglaces_ht'] = $calcul_ht_9_hors_incendie_attentats_cn * 0.07;
    
    $calculations['repartition_brisdeglaces_taxe'] = $repartition_brisdeglaces_ht * 0.09;

    $calculations['repartition_vol_ht'] = $calcul_ht_9_hors_incendie_attentats_cn * 0.19;
    
    $calculations['repartition_vol_taxe'] = $repartition_vol_ht * 0.09;

    if ($res->formule == "OPTION PROPRIETAIRE NON OCCUPANT")
        $calculations['repartition_rc_ht'] = $calcul_ht_9_hors_incendie_attentats_cn * 0.05;
    else
        $calculations['repartition_rc_ht'] = $calcul_ht_9_hors_incendie_attentats_cn * 0.21;
    
    $calculations['repartition_rc_taxe'] = $repartition_rc_ht * 0.09;

    $calculations['repartition_dr_ht'] = $calcul_ht_9_hors_incendie_attentats_cn * 0.02;
    
    $calculations['repartition_dr_taxe'] = $repartition_dr_ht * 0.09;

    if ($res->formule == "OPTION PROPRIETAIRE NON OCCUPANT")
        $calculations['repartition_degatsdeseaux_ht'] = $calcul_ht_9_hors_incendie_attentats_cn * 0.39 + ($res->customer_amount_rc / 1.09);
    else
        $calculations['repartition_degatsdeseaux_ht'] = $calcul_ht_9_hors_incendie_attentats_cn * 0.23 + ($res->customer_amount_rc / 1.09);

    $calculations['repartition_degatsdeseaux_taxe'] = $repartition_degatsdeseaux_ht * 0.09;

    $calculations['cotisation_ht_annuelle'] = $cotisation_risques_technologiques_ht + $cotisation_incendie_ht + $cotisation_attentats_ht + $cotisation_cn_ht + $repartition_tgn_ht + $repartition_dommageselectriques_ht + $repartition_brisdeglaces_ht + $repartition_vol_ht + $repartition_rc_ht + $repartition_dr_ht + $repartition_degatsdeseaux_ht;
    
    $calculations['taxes_annuelles'] = $cotisation_risques_technologiques_taxe + $cotisation_incendie_taxe + $cotisation_attentats_taxe + $cotisation_cn_taxe + $repartition_tgn_taxe + $repartition_dommageselectriques_taxe + $repartition_brisdeglaces_taxe + $repartition_vol_taxe + $repartition_rc_taxe + $repartition_dr_taxe + $repartition_degatsdeseaux_taxe;

    return $calculations; 
}

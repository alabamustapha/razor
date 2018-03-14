<?

session_start();

function calcul_cotisation_annuelle($formule)
{
    require "vitalia_batiment.php";
    $DEBUG = 0;

    // Clauses
    $clauses = ",";

    // Warning
    $warnings = array();

    //---------------------------------TARIF DE BASE----------------------------//
    /*$coef_tarif_base = 1;
    if ($_POST['in_coef_categorie_batiment'] == "A")
    {
        $min_cotisation = 186;
        if ($_POST['in_nombre_surface'] < 300)
            $coef_tarif_base = 1.02;
        else if ($_POST['in_nombre_surface'] < 1500)
            $coef_tarif_base = 1;
        else if ($_POST['in_nombre_surface'] < 3000)
            $coef_tarif_base = 0.97;
        else
            $coef_tarif_base = 0.9;
    } else {
    */
    $min_cotisation = 144;

    if ($_POST['in_nombre_surface'] < 300)
        $coef_tarif_base = 0.78;
    else if ($_POST['in_nombre_surface'] < 1500)
        $coef_tarif_base = 0.77;
    else if ($_POST['in_nombre_surface'] < 3000)
        $coef_tarif_base = 0.76;
    else
        $coef_tarif_base = 0.75;


    $total_base = $coef_tarif_base * $_POST['in_nombre_surface'];

    //---------------------------------COEF MULTIPLE----------------------------//
    if ($coef_zone['coefficient'][$_POST['in_coef_zone']] == 1.5)
    {
        $clauses .= "C21,";
    } else if ($coef_zone['coefficient'][$_POST['in_coef_zone']] == 1.2)
    {
        $clauses .= "C22,";
    } else {}

    $coef_nombre_sinistres= 1.05;
    if ($_POST['in_nombre_sinistres'] < 3)
    {
        $coef_nombre_sinistres = 1;
    } else if ($_POST['in_nombre_sinistres'] > 3)
    {
        $coef_nombre_sinistres = -1;
        $warnings[] = '"Nombre de sinistres trop élevé"';
    } else {}

    $coef_multiple = $coef_aggravation_occupation['coefficient'][$_POST['in_coef_aggravation_occupation']] *
        $coef_annee_construction['coefficient'][$_POST['in_coef_annee_construction']] *
        $coef_zone['coefficient'][$_POST['in_coef_zone']] *
        $coef_nombre_sinistres *
        $coef_antecedents['coefficient'][$_POST['in_coef_antecedents']];

    $clauses .= $coef_aggravation_occupation['clause'][$_POST['in_coef_aggravation_occupation']] .",".
        $coef_annee_construction['clause'][$_POST['in_coef_annee_construction']] .",";

    if ($coef_antecedents['coefficient'][$_POST['in_coef_antecedents']] == -1)
    {
        $warnings[] = '"Antecedents de resiliation"';
    }

    //----------------------------------COEF SIMPLE-----------------------------//
    $coef_defautprotection = 1;
    if ($_POST['in_etat_defautprotection'] > 0)
    {
        $clauses .= "C16,";
        if ($coef_zone['coefficient'][$_POST['in_coef_zone']] == 1.5)
        {
            $coef_defautprotection = -1;
            $warnings[] = '"Defaut de protection" et "Departement en zone de coefficient 1.5" selectionnes';
        }
        else if ($coef_zone['coefficient'][$_POST['in_coef_zone']] == 1.2)
            $coef_defautprotection = 1.25;
        else
            $coef_defautprotection = 1.15;
    }

    $coef_simple = 1 * $coef_defautprotection;
    if ($_POST['in_coef_specificites_techniques_0'] > -1)
    {
        $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][$_POST['in_coef_specificites_techniques_0']];
        $clauses .= $coef_specificites_techniques['clause'][$_POST['in_coef_specificites_techniques_0']].",";
    }
    if ($_POST['in_coef_specificites_techniques_1'] > -1)
    {
        $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][$_POST['in_coef_specificites_techniques_1']];
        $clauses .= $coef_specificites_techniques['clause'][$_POST['in_coef_specificites_techniques_1']].",";
    }
    if ($_POST['in_coef_specificites_techniques_2'] > -1)
    {
        $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][$_POST['in_coef_specificites_techniques_2']];
        $clauses .= $coef_specificites_techniques['clause'][$_POST['in_coef_specificites_techniques_2']].",";
    }
    if ($_POST['in_coef_specificites_techniques_3'] > -1)
    {
        $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][$_POST['in_coef_specificites_techniques_3']];
        $clauses .= $coef_specificites_techniques['clause'][$_POST['in_coef_specificites_techniques_3']].",";
    }
    if ($_POST['in_coef_specificites_techniques_4'] > -1)
    {
        $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][$_POST['in_coef_specificites_techniques_4']];
        $clauses .= $coef_specificites_techniques['clause'][$_POST['in_coef_specificites_techniques_4']].",";
    }
    if ($_POST['in_coef_specificites_techniques_5'] > -1)
    {
        $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][$_POST['in_coef_specificites_techniques_5']];
        $clauses .= $coef_specificites_techniques['clause'][$_POST['in_coef_specificites_techniques_5']].",";
    }
    if ($_POST['in_coef_specificites_techniques_6'] > -1)
    {
        $coef_simple = $coef_simple * $coef_specificites_techniques['coefficient'][$_POST['in_coef_specificites_techniques_6']];
        $clauses .= $coef_specificites_techniques['clause'][$_POST['in_coef_specificites_techniques_6']].",";
    }
    if ($_POST['in_coef_minorations_possibles_0'] > -1)
    {
        $coef_simple = $coef_simple * $coef_minorations_possibles['coefficient'][$_POST['in_coef_minorations_possibles_0']];
        $clauses .= $coef_minorations_possibles['clause'][$_POST['in_coef_minorations_possibles_0']].",";
    }
    if ($_POST['in_coef_minorations_possibles_1'] > -1)
    {
        $coef_simple = $coef_simple * $coef_minorations_possibles['coefficient'][$_POST['in_coef_minorations_possibles_1']];
        $clauses .= $coef_minorations_possibles['clause'][$_POST['in_coef_minorations_possibles_1']].",";
    }
    if ($_POST['in_coef_minorations_possibles_2'] > -1)
    {
        $coef_simple = $coef_simple * $coef_minorations_possibles['coefficient'][$_POST['in_coef_minorations_possibles_2']];
        $clauses .= $coef_minorations_possibles['clause'][$_POST['in_coef_minorations_possibles_2']].",";
    }

    // if ($_POST['in_coef_minorations_possibles_3'] > -1)
    // {
    //	$coef_simple = $coef_simple * $coef_minorations_possibles['coefficient'][$_POST['in_coef_minorations_possibles_3']];
    //	$clauses .= $coef_minorations_possibles['clause'][$_POST['in_coef_minorations_possibles_3']].",";
    // }

    //----------------------------------Protection juridique étendu-----------------------------//

    if ($_POST['in_protection_juridique_etendu'] > -1)
    {
        $coef_simple_protection =  $protection_juridique_etendu['coefficient'][$_POST['in_coef_minorations_possibles_2']];

    }



    //----------------------------------CALCUL CMT-----------------------------//

    if (( $coef_zone['designation'][$_POST['in_coef_zone']] == 25 ) || ($coef_zone['designation'][$_POST['in_coef_zone']] == 88) || ($coef_zone['designation'][$_POST['in_coef_zone']] == 95)){
        $CMT_total = 1;
    }else{
        $CMT_total = 1.10;
    }

    $CMT = $CMT_total;

    //----------------------------------CALCUL COTI-----------------------------//

    // TMP A VARIABILISER


    $total_corrige_coef = ($total_base * $coef_multiple * $coef_simple * $CMT * 0.85) + $coef_simple_protection;	// total corrigé coef = total base X coef global retenu X CMT

    $tarif_retenu = max($total_corrige_coef, $min_cotisation);

    //----------------------------------PROTECTION JURIDIQUE--------------------//
    $surfaceDeveloppee = $_POST['in_nombre_surface'];
    if ($_POST['in_nombre_baux'] > 0 and $surfaceDeveloppee > 0)
    {
        $protection_juridique = $surfaceDeveloppee * 0.13;
        if($protection_juridique < 135)
        {
            $protection_juridique = 135;
        }

        $protection_juridique = $protection_juridique + 20;
    }
    else
    {
        $protection_juridique = 0;
    }

    //$cotisation_total_annuelle = $tarif_retenu + $protection_juridique + $forfait_CP_et_fds_de_garantie;
    $cotisation_total_annuelle = $tarif_retenu + $forfait_CP_et_fds_de_garantie;

    $result = array("juridique" => $protection_juridique, "cotisation" => $cotisation_total_annuelle, "clauses" => $clauses, "warnings" => $warnings, "rc" => 0.00);

    return $result;
}

$result_pno = calcul_cotisation_annuelle(FORMULE_PNO);

if (sizeof($result_pno['warnings']) == 0)
{
    echo '<u>Tarifs :</u><center><table class="tarificateur">';
    echo '<tr><td>PNO : </td><td>'.round((($result_pno['cotisation'] * 0.83 * 1.1 * $_POST['in_marge'])) + $result_pno['juridique'], 2).'</td><td> euros</td></tr>';
    echo '</table></center>';

    echo '<br><u>Clauses :</u><center><table class="tarificateur">';
    echo '<tr><td>PNO : </td><td>'.clean_clauses($result_pno['clauses']).'</td></tr>';
    echo '</table></center>';

    echo '<br><div class="form_field"><a href="espaceprofessionnels.html">Annuler</a> - <a href="espaceprofessionnels-devisbatiment-s2.html">Aller &agrave; l\'&eacute;tape 2</a></div>';
} else {
    for ($i=0;$i<sizeof($result_pno['warnings']);$i++)
        echo $result_pno['warnings'][$i]."<br>";
}

$_SESSION['assurance_batiment'] = array("in_nombre_sinistres" => $_POST['in_nombre_sinistres'],
    "in_nombre_surface" => $_POST['in_nombre_surface'],
    "in_coef_zone" => $_POST['in_coef_zone'],
    "in_coef_aggravation_occupation" => $_POST['in_coef_aggravation_occupation'],
    //"in_coef_categorie_batiment" => $_POST['in_coef_categorie_batiment'],
    "in_coef_annee_construction" => $_POST['in_coef_annee_construction'],
    "in_coef_antecedents" => $_POST['in_coef_antecedents'],
    "in_coef_specificites_techniques_0" => $_POST['in_coef_specificites_techniques_0'],
    "in_coef_specificites_techniques_1" => $_POST['in_coef_specificites_techniques_1'],
    "in_coef_specificites_techniques_2" => $_POST['in_coef_specificites_techniques_2'],
    "in_coef_specificites_techniques_3" => $_POST['in_coef_specificites_techniques_3'],
    "in_coef_specificites_techniques_4" => $_POST['in_coef_specificites_techniques_4'],
    "in_coef_specificites_techniques_5" => $_POST['in_coef_specificites_techniques_5'],
    "in_coef_specificites_techniques_6" => $_POST['in_coef_specificites_techniques_6'],
    "in_etat_defautprotection" => $_POST['in_etat_defautprotection'],
    "in_nombre_baux" => $_POST['in_nombre_baux'],
    "in_coef_minorations_possibles_0" => $_POST['in_coef_minorations_possibles_0'],
    "in_coef_minorations_possibles_1" => $_POST['in_coef_minorations_possibles_1'],
    "in_coef_minorations_possibles_2" => $_POST['in_coef_minorations_possibles_2'],
    "in_protection_juridique_etendu" => $_POST['in_protection_juridique_etendu'],
    "result_pno" => $result_pno,
    "in_marge" => $_POST['in_marge']
);
?>

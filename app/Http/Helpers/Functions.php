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


function activia_professions(){
    return [
        "Sans pneumatiques (ou < 30 x l'indice)",
        "Avec pneumatiques",
        "Avec distribution de carburant",
        "Accessoires de jardin (dallage, piscine, abris, salons, avec pose)",
        "Agences",
        "Alimentation générale (fruits, légumes, primeurs, œufs,",
        "Animaux d'agrément (commerce)",
        "Antiquités (vente)",
        "Architecte - décorateur",
        "Armurerie (commerce avec réparation)",
        "Armurerie (commerce sans réparation)",
        "Bateaux avec ou sans réparation",
        "Bazar, gadgets, souvenirs",
        "Bijouterie sans fabrication",
        "Bijouterie fantaisie",
        "Biscuits (commerce et fabrique)",
        "Boucherie (capacité maxi chambres froides = 60 m3)",
        "Boulangerie",
        "Brasserie",
        "Bricolage (magasin)",
        "Brocante (sans chiffons)",
        "Bureaux",
        "Cabinet radiesthésie",
        "Cabinet relaxation",
        "Cabinet thérapie",
        "Cadeau de luxe (commerce)",
        "Café Bars à l'exclusion des bars de nuit",
        "Cafés thé (commerce sans torréfaction)",
        "Camping (articles de) avec location de matériel",
        "Camping (articles de) sans location de matériel",
        "Carrelage avec ou sans pose",
        "Carrossier, tolier automobile",
        "Centre équestre",
        "Centre de remise en forme",
        "Chapeaux (atelier et commerce de)",
        "Charbon, gaz, combustible (jusqu'à 50 bteilles de gaz)",
        "Charcuterie (capacité maxi chambres froides : 60 m3)",
        "Charpente métallique",
        "Charpente bois",
        "Chaussures (commerce)",
        "Chauffage avec ou sans pose",
        "Cheminées (commerce avec ou sans pose)",
        "Chirurgiens dentiste",
        "Chocolaterie, confiserie (commerce et fabrique)",
        "Clés minute",
        "Coiffeur F avec bijoux fantaisie",
        "Coiffeur F ou mixte sans bijoux fantaisie",
        "Coiffeur H",
        "Confiseur",
        "Cordonnier",
        "Coupes et médailles (commerce)",
        "Coutellerie (commerce)",
        "Couture",
        "Couverture zinguerie",
        "Creperie",
        "Cristaux, faience, verrerie, vaisselle (commerce)",
        "Cuir (travail du) sans tannage et avec colle à froid",
        "Cuir (commerce et depots) vêtements et articles en",
        "Cuisines aménagées (commerce avec pose)",
        "Cuisines aménagées (commerce sans pose)",
        "Cyber café",
        "Cyber espace",
        "Cycles et motocycles avec atelier de réparation",
        "Cycles sans moteur (commerce et réparation)",
        "Débits de tabac",
        "Décorateur",
        "Dentiste",
        "Dépôt de marchandises (carreleur, platier, macon)",
        "Diététique herboristerie, produits naturels (commerce)",
        "Disquaire sans vidéocassettes",
        "Droguerie (jusqu'à 50 bteilles de gaz)",
        "Ebeniste sans outillage mécanique autre que portatif",
        "Ebeniste avec outillage mecanique",
        "Ecole de danse",
        "Editeur sans imprimerie (manuscrits et livres anciens à",
        "Electricite avec pose",
        "Electricite sans pose",
        "Electromenager (commerce sans TV, radio, HIFI)",
        "Electromenager, radio, télévision, HIFI (commerce avec installation et/ou atelier de réparation)",
        "Electromenager, télévision, HIFI (sans installation)",
        "Electronique (commerce d'appareils) sans atelier",
        "Electronique (commerce d'appareils) avec atelier",
        "Encadreur",
        "Epicerie",
        "Estampe, lithographie (commerce)",
        "Exploitant de salle de sports",
        "Ferronnerie",
        "Films (loueurs et distributeurs) sans projection, ni fabrication, ni prise de vues",
        "Fleuriste (sans exploitation agricole), plantes, fleurs naturelles ou artificielles, préparations",
        "Forains",
        "Fourniture pour dessins et peinture",
        "Fourreurs",
        "Friterie            LCI sur batiment + contenu",
        "Fromagerie (chambres frigorifiques maxi 60 m3) (commerce)",
        "Funéraires (commerce d'articles)",
        "Galerie d'art et marchand de peinture ou d'art",
        "Garagiste réparateur avec pneus < 30 x l'indice",
        "Garagiste réparateur",
        "Garagiste réparateur avec distribution de carburant",
        "Gardiennage de caravanes ou bateaux",
        "Gardiennage de véhicules automobiles",
        "Glacier",
        "Grainetier (vente au détail)",
        "Horlogerie (commerce et réparation)",
        "Horticulteurs et maraichers",
        "Hotel jusqu'à 2 ** NN et moins de 30 chambres",
        "Hotel au-delà de 2 ** NN et/ou de 30 chambres",
        "Imprimerie, typographie, offest, reprographie",
        "Informatique (commerce de détail)",
        "Institut de beauté, esthéticienne, manucure",
        "Instrument de précision (commerce)",
        "Instruments et appareils médicaux (commerce et réparation)",
        "Jardinerie",
        "Jeux vidéo (commerce)",
        "Joaillerie, orfèvrerie avec travail métaux précieux",
        "Joaillerie, orfèvrerie sans travail métaux précieux",
        "Jouets (commerce sans jeux vidéo)",
        "Journaux",
        "Kinésithérapeute",
        "Laboratoire d'analyses médicales",
        "Laboratoire de développement de films",
        "Laine (commerce)",
        "Lambris, parquets (commerce avec pose)",
        "Lambris, parquets (commerce sans pose)",
        "Laverie",
        "Librairie",
        "Linge de maison (commerce)",
        "Lingerie fine, corsets, gaines, ceintures (commerce)",
        "Literie (commerce)",
        "Luminaires, lustrerie (commerce avec pose)",
        "Luminaires (commerce sans pose)",
        "Lunettes (marchand de)",
        "Machines à coudre, à tricoter (commerce)",
        "Manucure",
        "Maroquinerie, sellerie (commerce)",
        "Marbrerie, taille de pierres",
        "Mareyeur (capacité maxi chambres froides = 60 m3)",
        "Médecin",
        "Menuiserie métallique",
        "Menuiserie bois, plastique",
        "Mercerie",
        "Métaux (travail des)",
        "Meubles et machines de bureaux (commerce de)",
        "Meubles (commerce sans TMB)",
        "Miroiterie, glaces (commerce avec pose)",
        "Miroiterie, glaces (commerce sans pose)",
        "Modèles réduits",
        "Moquettes, tapis maxi 5 x l'indice, revetements de sol avec pose",
        "Moquettes, tapis maxi 5 x l'indice, revetements de sol",
        "sans pose",
        "Nettoyage (entreprise de)",
        "Objets pieux (commerce et dépôt)",
        "Optique, accoustique (commerce et réparation sans",
        "photo, cinéma",
        "Papeterie",
        "Papiers peints, peinture, décoration (commerce)",
        "Parapharmacie",
        "Parfumerie",
        "Pâtisserie (capacité maxi chambres froides = 60 m3)",
        "Paysagiste",
        "Pêche (commerce d'articles de)",
        "Pédicure, podologue",
        "Peinture en bâtiment",
        "Pépiniériste",
        "Pharmacie",
        "Photographe avec exclusion des clichés",
        "Platrerie (entrepôt de matériel de)",
        "Pizzéria",
        "Plomberie",
        "Poissonnerie (capacité maxi chambres froides = 60 m3)",
        "Poterie, céramique (atelier avec four électrique exclusivement)",
        "Pressing avec ou sans teinturerie",
        "Primeurs (grossiste)",
        "Prothésiste dentaire",
        "Quincaillerie (jusqu'à 50 bouteilles de gaz)",
        "Radiologue",
        "Reliure, brochure",
        "Restaurateur de meubles",
        "Repassage",
        "Restaurant sans chambre ni piste de danse",
        "Restaurant avec piste de danse occasionnelle ( moins de 10 bals par an) clubs et discothèques exclus",
        "Restauration à emporter",
        "Rideaux, voilages et tissus (commerce)",
        "Salaisons, conserves (capacité maxi chambres froides = 60 m3)",
        "Salle de gymnastique",
        "Salon de thé",
        "Sanitaire (commerce d'appareils avec pose)",
        "Sanitaire (commerce d'appareils sans pose)",
        "Savons, bougies, essences aromatiques (commerce)",
        "Sculpteur, tourneur sur bois",
        "Serrurerie avec ou sans pose",
        "Solderie",
        "Sports (commerce d'articles de) avec location de matériel",
        "Sports (commerce d'articles de ) sans location de matériel",
        "Station de lavage automobile en libre service",
        "Station service (sans essais de véhicules)",
        "Studio d'enregistrement",
        "Supérette",
        "Surgelés (commerce)",
        "Tapis (commerce)",
        "Tapissier, garnisseur de sièges, ensemblier",
        "Téléphonie (commerce)",
        "Toilettage d'animaux",
        "Torréfaction",
        "Traiteur (capacité maxi chambres froides = 60 m3)",
        "Trocante - dépôt-vente",
        "Vannerie (commerce et atelier)",
        "Vétérinaire",
        "Vêtements (commerce de)",
        "Vêtements (atelier)",
        "Vidéocassettes (commerce)",
        "Vins et spiritueux - cave (sans embouteillage)",
        "Voyages (articles de)"
    ];
}

function tarnom(){
    
    return  [
        1 => ["c" => '900', "d" => '2', "e" => '2', "f" => '4', "g" => '3', "h" => '1', "i" => '2', "j" => '45', "k" => '3', "l" => '1'],
        2 => ["c" => '600', "d" => '4', "e" => '4', "f" => '5', "g" => '3', "h" => '1', "i" => '3', "j" => '40', "k" => '4', "l" => '2'],
        3 => ["c" => '500', "d" => '5', "e" => '5', "f" => '5', "g" => '3', "h" => '1', "i" => '3', "j" => '40', "k" => '5', "l" => '2'],
        4 => ["c" => '900', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => 'R', "l" => '2'],
        5 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => 'R', "k" => 'R', "l" => 'R'],
        6 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '2', "h" => '2', "i" => '1', "j" => '25', "k" => '2', "l" => '1'],
        7 => ["c" => '900', "d" => '1', "e" => '1', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => '1', "l" => '1'],
        8 => ["c" => '600', "d" => '3', "e" => '3', "f" => 'R', "g" => '3', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        9 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => 'R', "k" => 'R', "l" => 'R'],
        10 => ["c" => '600', "d" => '3', "e" => '4', "f" => '5', "g" => '3', "h" => '2', "i" => '3', "j" => '45', "k" => '3', "l" => '1'],
        11 => ["c" => '900', "d" => '2', "e" => '3', "f" => '5', "g" => '3', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        12 => ["c" => '900', "d" => '2', "e" => '3', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '40', "k" => '2', "l" => '1'],
        13 => ["c" => '900', "d" => '3', "e" => '3', "f" => '3', "g" => '2', "h" => '2', "i" => '2', "j" => '35', "k" => '1', "l" => '1'],
        14 => ["c" => '900', "d" => '2', "e" => '2', "f" => 'R', "g" => '2', "h" => '1', "i" => '1', "j" => '40', "k" => '2', "l" => '1'],
        15 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '2', "h" => '1', "i" => '1', "j" => '45', "k" => '1', "l" => '1'],
        16 => ["c" => '900', "d" => '5', "e" => '5', "f" => '2', "g" => '1', "h" => '2', "i" => '3', "j" => '35', "k" => '1', "l" => '1'],
        17 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '30', "k" => '2', "l" => '1'],
        18 => ["c" => '900', "d" => '2', "e" => '3', "f" => '1', "g" => '1', "h" => '2', "i" => '3', "j" => '50', "k" => '2', "l" => '1'],
        19 => ["c" => '900', "d" => '2', "e" => '3', "f" => '3', "g" => '2', "h" => '1', "i" => '2', "j" => '50', "k" => '3', "l" => '2'],
        20 => ["c" => '900', "d" => '3', "e" => '3', "f" => '3', "g" => '2', "h" => '1', "i" => '2', "j" => '45', "k" => '3', "l" => '1'],
        21 => ["c" => '600', "d" => '3', "e" => '3', "f" => 'R', "g" => '3', "h" => '2', "i" => '3', "j" => '45', "k" => '1', "l" => '1'],
        22 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => 'R', "k" => 'R', "l" => 'R'],
        23 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '50', "k" => 'R', "l" => 'R'],
        24 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '40', "k" => 'R', "l" => '1'],
        25 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '50', "k" => 'R', "l" => '1'],
        26 => ["c" => '900', "d" => '2', "e" => '3', "f" => '5', "g" => '2', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        27 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '2', "h" => '1', "i" => '2', "j" => '50', "k" => '3', "l" => '1'],
        28 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        29 => ["c" => '900', "d" => '3', "e" => '3', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '3', "l" => '1'],
        30 => ["c" => '900', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '40', "k" => '1', "l" => '1'],
        31 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => 'R', "l" => 'R'],
        32 => ["c" => '600', "d" => '3', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '60', "k" => 'R', "l" => 'R'],
        33 => ["c" => '900', "d" => '3', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '3', "j" => '70', "k" => 'R', "l" => '1'],
        34 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => 'R', "l" => '1'],
        35 => ["c" => '900', "d" => '2', "e" => '2', "f" => '1', "g" => '1', "h" => '2', "i" => '3', "j" => '45', "k" => '1', "l" => '1'],
        36 => ["c" => '500', "d" => '4', "e" => '5', "f" => '2', "g" => '1', "h" => '1', "i" => '3', "j" => '30', "k" => '2', "l" => '1'],
        37 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '35', "k" => '3', "l" => '1'],
        38 => ["c" => '900', "d" => '2', "e" => '3', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => 'R', "l" => 'R'],
        39 => ["c" => '900', "d" => '4', "e" => '5', "f" => '1', "g" => '1', "h" => '1', "i" => '3', "j" => '40', "k" => 'R', "l" => 'R'],
        40 => ["c" => '900', "d" => '2', "e" => '3', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        41 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => 'R', "l" => 'R'],
        42 => ["c" => '900', "d" => '2', "e" => '3', "f" => '1', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => 'R', "l" => 'R'],
        43 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '60', "k" => 'R', "l" => 'R'],
        44 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '2', "h" => '2', "i" => '2', "j" => '35', "k" => '2', "l" => '1'],
        45 => ["c" => '900', "d" => '1', "e" => '1', "f" => '2', "g" => '1', "h" => '2', "i" => '1', "j" => '75', "k" => '1', "l" => '1'],
        46 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '2', "h" => '1', "i" => '1', "j" => '70', "k" => '4', "l" => '1'],
        47 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => '4', "l" => '1'],
        48 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => '3', "l" => '1'],
        49 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '40', "k" => '2', "l" => '1'],
        50 => ["c" => '500', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '60', "k" => '1', "l" => '1'],
        51 => ["c" => '900', "d" => '1', "e" => '1', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => '1', "l" => '1'],
        52 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => '2', "l" => '1'],
        53 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '2', "i" => '2', "j" => '65', "k" => '1', "l" => '1'],
        54 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => 'R', "l" => 'R'],
        55 => ["c" => '900', "d" => '3', "e" => '4', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '60', "k" => '3', "l" => '1'],
        56 => ["c" => '900', "d" => '1', "e" => '1', "f" => '4', "g" => '1', "h" => '1', "i" => '1', "j" => '50', "k" => '1', "l" => '1'],
        57 => ["c" => '600', "d" => '2', "e" => '3', "f" => '4', "g" => '2', "h" => '1', "i" => '2', "j" => '25', "k" => '2', "l" => '1'],
        58 => ["c" => '600', "d" => '1', "e" => '2', "f" => '5', "g" => '3', "h" => '1', "i" => '1', "j" => '40', "k" => '1', "l" => '1'],
        59 => ["c" => '900', "d" => '3', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '45', "k" => 'R', "l" => 'R'],
        60 => ["c" => '900', "d" => '3', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '45', "k" => '2', "l" => '2'],
        61 => ["c" => '900', "d" => '3', "e" => '4', "f" => '3', "g" => '2', "h" => '1', "i" => '1', "j" => '60', "k" => '2', "l" => '1'],
        62 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '1', "h" => '1', "i" => '1', "j" => '60', "k" => '1', "l" => '1'],
        63 => ["c" => '500', "d" => '3', "e" => '4', "f" => '4', "g" => '2', "h" => '1', "i" => '3', "j" => '30', "k" => '4', "l" => '2'],
        64 => ["c" => '900', "d" => '2', "e" => '3', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '3', "l" => '2'],
        65 => ["c" => '900', "d" => '1', "e" => '2', "f" => '4', "g" => '3', "h" => '2', "i" => '1', "j" => '35', "k" => '1', "l" => '1'],
        66 => ["c" => '900', "d" => '2', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '40', "k" => '2', "l" => '1'],
        67 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '50', "k" => 'R', "l" => 'R'],
        68 => ["c" => '900', "d" => '1', "e" => '1', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '40', "k" => 'R', "l" => 'R'],
        69 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '2', "i" => '1', "j" => '45', "k" => 'R', "l" => 'R'],
        70 => ["c" => '900', "d" => '1', "e" => '2', "f" => '4', "g" => '2', "h" => '1', "i" => '1', "j" => '45', "k" => '1', "l" => '1'],
        71 => ["c" => '900', "d" => '3', "e" => '4', "f" => '3', "g" => '2', "h" => '2', "i" => '3', "j" => '35', "k" => '2', "l" => '1'],
        72 => ["c" => '500', "d" => '3', "e" => '4', "f" => '1', "g" => '1', "h" => '2', "i" => '3', "j" => '50', "k" => '3', "l" => '1'],
        73 => ["c" => '500', "d" => '4', "e" => '5', "f" => '1', "g" => '1', "h" => '2', "i" => '3', "j" => '50', "k" => '3', "l" => '1'],
        74 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => 'R', "l" => '1'],
        75 => ["c" => '600', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '30', "k" => '1', "l" => '1'],
        76 => ["c" => '600', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => 'R', "l" => 'R'],
        77 => ["c" => '900', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '35', "k" => '2', "l" => '2'],
        78 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '45', "k" => '3', "l" => '1'],
        79 => ["c" => '600', "d" => '3', "e" => '4', "f" => '4', "g" => '2', "h" => '2', "i" => '3', "j" => '45', "k" => '4', "l" => '2'],
        80 => ["c" => '900', "d" => '2', "e" => '2', "f" => '4', "g" => '2', "h" => '2', "i" => '2', "j" => '35', "k" => '2', "l" => '1'],
        81 => ["c" => '900', "d" => '2', "e" => '2', "f" => '3', "g" => '1', "h" => '2', "i" => '2', "j" => '30', "k" => '3', "l" => '1'],
        82 => ["c" => '600', "d" => '3', "e" => '3', "f" => '4', "g" => '1', "h" => '2', "i" => '3', "j" => '35', "k" => '4', "l" => '2'],
        83 => ["c" => '900', "d" => '2', "e" => '3', "f" => '1', "g" => '1', "h" => '2', "i" => '2', "j" => '45', "k" => '2', "l" => '1'],
        84 => ["c" => '900', "d" => '2', "e" => '2', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '30', "k" => '1', "l" => '1'],
        85 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '1', "h" => '2', "i" => '1', "j" => '45', "k" => '1', "l" => '1'],
        86 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '2', "h" => '2', "i" => '2', "j" => '45', "k" => '3', "l" => '1'],
        87 => ["c" => '900', "d" => '3', "e" => '3', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '35', "k" => 'R', "l" => 'R'],
        88 => ["c" => '500', "d" => '2', "e" => '2', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '30', "k" => '2', "l" => '1'],
        89 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => '1', "l" => '1'],
        90 => ["c" => 'R	R', "d" => 'R', "e" => 'R', "f" => 'R', "g" => 'R', "h" => 'R', "i" => 'R', "j" => 'R', "k" => 'R', "l" => 'R'],
        91 => ["c" => '900', "d" => '2', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        92 => ["c" => '500', "d" => '2', "e" => '3', "f" => 'R', "g" => '2', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        93 => ["c" => '200', "d" => '4', "e" => '5', "f" => '3', "g" => '1', "h" => '2', "i" => '3', "j" => '50', "k" => '3', "l" => '1'],
        94 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '35', "k" => '2', "l" => '1'],
        95 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '40', "k" => '2', "l" => '1'],
        96 => ["c" => '900', "d" => 'R', "e" => 'R', "f" => 'R', "g" => 'R', "h" => 'R', "i" => 'R', "j" => 'R	', "k" => 'R', "l" => 'R'],
        97 => ["c" => '900', "d" => '2', "e" => '3', "f" => '3', "g" => '2', "h" => '1', "i" => '2', "j" => '40', "k" => 'R', "l" => 'R'],
        98 => ["c" => '600', "d" => '3', "e" => '4', "f" => '3', "g" => '2', "h" => '1', "i" => '2', "j" => '40', "k" => 'R', "l" => 'R'],
        99 => ["c" => '500', "d" => '4', "e" => '5', "f" => '3', "g" => '2', "h" => '1', "i" => '1', "j" => '45', "k" => 'R', "l" => 'R'],
        100 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => 'R', "l" => '1'],
        101 => ["c" => '900', "d" => '2', "e" => '2', "f" => '4', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => 'R', "l" => '1'],
        102 => ["c" => '900', "d" => '2', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '60', "k" => '2', "l" => '2'],
        103 => ["c" => '900', "d" => '2', "e" => '2', "f" => '1', "g" => '1', "h" => '2', "i" => '1', "j" => '45', "k" => '2', "l" => '1'],
        104 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '2', "h" => '2', "i" => '1', "j" => '35', "k" => '1', "l" => '1'],
        105 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '2', "i" => '1', "j" => '40', "k" => '2', "l" => '1'],
        106 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '3', "i" => '1', "j" => '60', "k" => 'R', "l" => '2'],
        107 => ["c" => '900', "d" => 'R', "e" => 'R', "f" => 'R', "g" => 'R', "h" => 'R', "i" => 'R', "j" => 'R', "k" => 'R', "l" => 'R'],
        108 => ["c" => '900', "d" => '3', "e" => '3', "f" => '1', "g" => '1', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        109 => ["c" => '900', "d" => '2', "e" => '3', "f" => '5', "g" => '2', "h" => '2', "i" => '3', "j" => '45', "k" => '1', "l" => '1'],
        110 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => 'R', "l" => '1'],
        111 => ["c" => '900', "d" => '1', "e" => '1', "f" => '2', "g" => '1', "h" => '2', "i" => '1', "j" => '45', "k" => '1', "l" => '1'],
        112 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '2', "i" => '1', "j" => '45', "k" => 'R', "l" => '1'],
        113 => ["c" => '900', "d" => '2', "e" => '2', "f" => '3', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => '1', "l" => '1'],
        114 => ["c" => '500', "d" => '2', "e" => '3', "f" => '4', "g" => '2', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        115 => ["c" => '600', "d" => '2', "e" => '4', "f" => 'R', "g" => '3', "h" => '1', "i" => '1', "j" => '45', "k" => '2', "l" => '1'],
        116 => ["c" => '600', "d" => '2', "e" => '3', "f" => 'R', "g" => '3', "h" => '1', "i" => '1', "j" => '45', "k" => '1', "l" => '1'],
        117 => ["c" => '500', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '35', "k" => '1', "l" => '1'],
        118 => ["c" => '500', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '2', "i" => '1', "j" => '35', "k" => '1', "l" => '1'],
        119 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => 'R', "l" => 'R'],
        120 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '2', "i" => '1', "j" => '40', "k" => 'R', "l" => 'R'],
        121 => ["c" => '900', "d" => '4', "e" => '5', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '60', "k" => '1', "l" => '1'],
        122 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        123 => ["c" => '600', "d" => '4', "e" => '5', "f" => '1', "g" => '1', "h" => '1', "i" => '3', "j" => '45', "k" => 'R', "l" => '1'],
        124 => ["c" => '600', "d" => '4', "e" => '4', "f" => '1', "g" => '1', "h" => '1', "i" => '2', "j" => '35', "k" => '1', "l" => '1'],
        125 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => '3', "l" => '1'],
        126 => ["c" => '900', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '1', "j" => '40', "k" => '1', "l" => '1'],
        127 => ["c" => '900', "d" => '2', "e" => '3', "f" => '3', "g" => '1', "h" => '2', "i" => '2', "j" => '40', "k" => '1', "l" => '1'],
        128 => ["c" => '900', "d" => '2', "e" => '3', "f" => '4', "g" => '2', "h" => '1', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        129 => ["c" => '900', "d" => '4', "e" => '4', "f" => '2', "g" => '1', "h" => '2', "i" => '3', "j" => '45', "k" => '1', "l" => '1'],
        130 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => 'R', "l" => '1'],
        131 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        132 => ["c" => '600', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '40', "k" => 'R', "l" => 'R'],
        133 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '35', "k" => '2', "l" => '1'],
        134 => ["c" => '900', "d" => '1', "e" => '1', "f" => '3', "g" => '1', "h" => '1', "i" => '1', "j" => '75', "k" => 'R', "l" => 'R'],
        135 => ["c" => '500', "d" => '2', "e" => '3', "f" => '4', "g" => '2', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        136 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '40', "k" => '3', "l" => '2'],
        137 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '35', "k" => '2', "l" => '1'],
        138 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '50', "k" => 'R', "l" => 'R'],
        139 => ["c" => '600', "d" => '2', "e" => '3', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '40', "k" => 'R', "l" => 'R'],
        140 => ["c" => '500', "d" => '4', "e" => '4', "f" => '1', "g" => '1', "h" => '2', "i" => '3', "j" => '40', "k" => 'R', "l" => 'R'],
        141 => ["c" => '500', "d" => '2', "e" => '2', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '35', "k" => '1', "l" => '1'],
        142 => ["c" => '900', "d" => '2', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '40', "k" => '3', "l" => '2'],
        143 => ["c" => '600', "d" => '2', "e" => '2', "f" => '3', "g" => '1', "h" => '2', "i" => '2', "j" => '40', "k" => '2', "l" => '1'],
        144 => ["c" => '600', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '45', "k" => '2', "l" => '1'],
        145 => ["c" => '500', "d" => '2', "e" => '3', "f" => '1', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '3', "l" => '1'],
        146 => ["c" => '500', "d" => '2', "e" => '3', "f" => '1', "g" => '1', "h" => '1', "i" => '2', "j" => '35', "k" => '1', "l" => '1'],
        147 => ["c" => '900', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        148 => ["c" => '500', "d" => '3', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '40', "k" => '3', "l" => '2'],
        149 => ["c" => '500', "d" => '3', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '35', "k" => '1', "l" => '1'],
        150 => ["c" => '500', "d" => '3', "e" => '3', "f" => '1', "g" => '1', "h" => '1', "i" => '3', "j" => '70', "k" => '5', "l" => 'R'],
        151 => ["c" => '600', "d" => '2', "e" => '3', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '20', "k" => '1', "l" => '1'],
        152 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => 'R', "l" => '1'],
        153 => ["c" => '600', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        154 => ["c" => '600', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        155 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '1', "h" => '2', "i" => '1', "j" => '35', "k" => 'R', "l" => '1'],
        156 => ["c" => '900', "d" => '2', "e" => '3', "f" => '4', "g" => '2', "h" => '1', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        157 => ["c" => '900', "d" => '2', "e" => '3', "f" => '1', "g" => '1', "h" => '1', "i" => '2', "j" => '60', "k" => '1', "l" => '1'],
        158 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '50', "k" => 'R', "l" => 'R'],
        159 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '40', "k" => '1', "l" => '1'],
        160 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '50', "k" => 'R', "l" => 'R'],
        161 => ["c" => '900', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '4', "l" => '2'],
        162 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => '1', "l" => '1'],
        163 => ["c" => '900', "d" => '1', "e" => '3', "f" => '4', "g" => '1', "h" => '2', "i" => '1', "j" => '35', "k" => 'R', "l" => 'R'],
        164 => ["c" => '900', "d" => '3', "e" => '3', "f" => '4', "g" => '2', "h" => '2', "i" => '1', "j" => '60', "k" => '1', "l" => '1'],
        165 => ["c" => '900', "d" => '2', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => 'R', "l" => 'R'],
        166 => ["c" => '900', "d" => '3', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '3', "j" => '50', "k" => '3', "l" => '1'],
        167 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => 'R', "l" => 'R'],
        168 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '35', "k" => '2', "l" => '1'],
        169 => ["c" => '900', "d" => '3', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '3', "j" => '60', "k" => '1', "l" => '1'],
        170 => ["c" => '900', "d" => '3', "e" => '4', "f" => '2', "g" => '2', "h" => '1', "i" => '3', "j" => '70', "k" => '4', "l" => '2'],
        171 => ["c" => '900', "d" => '2', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '3', "j" => '30', "k" => '1', "l" => '1'],
        172 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '50', "k" => 'R', "l" => 'R'],
        173 => ["c" => '900', "d" => '2', "e" => '3', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '35', "k" => '1', "l" => '1'],
        174 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '3', "j" => '50', "k" => 'R', "l" => 'R'],
        175 => ["c" => '900', "d" => '3', "e" => '4', "f" => '2', "g" => '1', "h" => '2', "i" => '3', "j" => '45', "k" => '1', "l" => '1'],
        176 => ["c" => '900', "d" => '4', "e" => '4', "f" => '1', "g" => '1', "h" => '2', "i" => '3', "j" => '60', "k" => '3', "l" => '1'],
        177 => ["c" => '900', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '70', "k" => '3', "l" => '1'],
        178 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '50', "k" => '3', "l" => '1'],
        179 => ["c" => '600', "d" => '3', "e" => '3', "f" => '3', "g" => '1', "h" => '2', "i" => '2', "j" => '60', "k" => '4', "l" => '2'],
        180 => ["c" => '900', "d" => '3', "e" => '3', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '60', "k" => '3', "l" => '1'],
        181 => ["c" => '900', "d" => '3', "e" => '3', "f" => '3', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        182 => ["c" => '900', "d" => '1', "e" => '1', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '35', "k" => '2', "l" => '1'],
        183 => ["c" => '900', "d" => '1', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => 'R', "l" => '1'],
        184 => ["c" => '900', "d" => '2', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '2', "j" => '50', "k" => '1', "l" => '1'],
        185 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => 'R', "l" => 'R'],
        186 => ["c" => '900', "d" => '1', "e" => '2', "f" => '3', "g" => '1', "h" => '1', "i" => '1', "j" => '35', "k" => '1', "l" => '2'],
        187 => ["c" => '900', "d" => '4', "e" => '4', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        188 => ["c" => '900', "d" => '4', "e" => '5', "f" => '1', "g" => '1', "h" => '2', "i" => '4', "j" => '60', "k" => '1', "l" => '1'],
        189 => ["c" => '900', "d" => '1', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '45', "k" => '2', "l" => '2'],
        190 => ["c" => '900', "d" => 'R', "e" => 'R', "f" => 'R', "g" => 'R', "h" => 'R', "i" => 'R', "j" => 'R	', "k" => 'R', "l" => 'R'],
        191 => ["c" => '900', "d" => '2', "e" => '3', "f" => '4', "g" => '1', "h" => '1', "i" => '3', "j" => '45', "k" => '3', "l" => '1'],
        192 => ["c" => '900', "d" => '2', "e" => '3', "f" => '4', "g" => '1', "h" => '1', "i" => '3', "j" => '45', "k" => '1', "l" => '1'],
        193 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => '3', "l" => '2'],
        194 => ["c" => '900', "d" => '4', "e" => '5', "f" => 'R', "g" => '2', "h" => '1', "i" => '1', "j" => '10', "k" => 'R', "l" => '2'],
        195 => ["c" => '900', "d" => '2', "e" => '3', "f" => '4', "g" => '1', "h" => '2', "i" => '2', "j" => '60', "k" => '1', "l" => '1'],
        196 => ["c" => '900', "d" => '2', "e" => '2', "f" => '3', "g" => '1', "h" => '2', "i" => '2', "j" => '30', "k" => '1', "l" => '1'],
        197 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        198 => ["c" => '600', "d" => '2', "e" => '2', "f" => '4', "g" => '1', "h" => '3', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        199 => ["c" => '900', "d" => '3', "e" => '3', "f" => '2', "g" => '1', "h" => '2', "i" => '2', "j" => '40', "k" => '2', "l" => '1'],
        200 => ["c" => '900', "d" => '3', "e" => '3', "f" => '5', "g" => '2', "h" => '2', "i" => '3', "j" => '45', "k" => '1', "l" => '1'],
        201 => ["c" => '900', "d" => '1', "e" => '1', "f" => '2', "g" => '1', "h" => '1', "i" => '1', "j" => '70', "k" => '1', "l" => '1'],
        202 => ["c" => '900', "d" => '2', "e" => '3', "f" => '2', "g" => '1', "h" => '1', "i" => '3', "j" => '35', "k" => '1', "l" => '1'],
        203 => ["c" => '900', "d" => '2', "e" => '2', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '35', "k" => '4', "l" => '1'],
        204 => ["c" => '900', "d" => 'R', "e" => 'R', "f" => 'R', "g" => 'R', "h" => 'R', "i" => 'R', "j" => 'R	', "k" => 'R', "l" => 'R'],
        205 => ["c" => '500', "d" => '3', "e" => '4', "f" => '1', "g" => '1', "h" => '1', "i" => '2', "j" => '60', "k" => '1', "l" => '1'],
        206 => ["c" => '900', "d" => '1', "e" => '1', "f" => '1', "g" => '1', "h" => '1', "i" => '1', "j" => '50', "k" => 'R', "l" => '1'],
        207 => ["c" => '900', "d" => '1', "e" => '2', "f" => '5', "g" => '2', "h" => '2', "i" => '2', "j" => '45', "k" => '1', "l" => '1'],
        208 => ["c" => '900', "d" => '2', "e" => '3', "f" => '5', "g" => '1', "h" => '2', "i" => '3', "j" => '45', "k" => '1', "l" => '1'],
        209 => ["c" => '600', "d" => '2', "e" => '3', "f" => '4', "g" => '1', "h" => '2', "i" => '2', "j" => '35', "k" => '1', "l" => '1'],
        210 => ["c" => '900', "d" => '2', "e" => '2', "f" => '4', "g" => '1', "h" => '1', "i" => '2', "j" => '40', "k" => '1', "l" => '1'],
        211 => ["c" => '900', "d" => '2', "e" => '2', "f" => '2', "g" => '1', "h" => '1', "i" => '2', "j" => '35', "k" => '2', "l" => '1'],
        ];
}

function classe_de_rique_pour_contole($proffesion_ref){
  return  [
        'inc_vv' => tarnom()[$proffesion_ref]['d'],
        'inc_contenu' => tarnom()[$proffesion_ref]['e'],
        'vol' => tarnom()[$proffesion_ref]['f'],
        'bg' => tarnom()[$proffesion_ref]['g'],
        'dde' => tarnom()[$proffesion_ref]['h'],
        'pe' => tarnom()[$proffesion_ref]['i'],
        'taux_mb' => tarnom()[$proffesion_ref]['j'],
        'rc' => tarnom()[$proffesion_ref]['k'],
        'pj' => tarnom()[$proffesion_ref]['l']
  ];

}

function tar_inc_vv(){
  return  [
        1 => ['b' => 0.34, 'c'=> 0.24, 'd'=> 0.32, 'e'=> 0.00, 'f'=> 0.60, 'g'=> 0.60, 'h'=> 0.60, 'i'=> 0.75, 'j'=> 2.50, 'k'=> 0.60],
        2 => ['b' => 0.44, 'c'=> 0.29, 'd'=> 0.37, 'e'=> 0.00, 'f'=> 0.75, 'g'=> 0.75, 'h'=> 0.75, 'i'=> 0.90, 'j'=> 2.60, 'k'=> 0.75],
        3 => ['b' => 0.57, 'c'=> 0.45, 'd'=> 0.53, 'e'=> 0.00, 'f'=> 0.90, 'g'=> 0.90, 'h'=> 0.90, 'i'=> 1.20, 'j'=> 2.60, 'k'=> 0.90],
        4 => ['b' => 0.69, 'c'=> 0.52, 'd'=> 0.59, 'e'=> 0.00, 'f'=> 1.20, 'g'=> 1.20, 'h'=> 1.20, 'i'=> 1.60, 'j'=> 3.50, 'k'=> 1.20],
        5 => ['b' => 0.86, 'c'=> 0.57, 'd'=> 0.72, 'e'=> 0.00, 'f'=> 1.60, 'g'=> 1.60, 'h'=> 1.60, 'i'=> 1.60, 'j'=> 4.50, 'k'=> 1.60]
  ];

}

function tar_vol(){
    return [
        ['a' => 11, 'b' => 1, 'c' => 1, 'd' => 1, 'e' => 1.13, 'f' => 4.50, 'g' => 11.00, 'h' => 15.00, 'i' => 15.00, 'j' => 10.00, 'k' => 9.00, 'l' => 3.25, 'm' => 3.25, 'n' => 3.25, 'o' => 13.00, 'p' => 20.00, 'q' => 36.00, 'r' => 16.00],
        ['a' => 12, 'b' => 2, 'c' => 1, 'd' => 2, 'e' => 0.67, 'f' => 3.78, 'g' => 10.00, 'h' => 14.00, 'i' => 14.00, 'j' => 7.00, 'k' => 8.00, 'l' => 3.00, 'm' => 3.00, 'n' => 3.00, 'o' => 11.00, 'p' => 15.00, 'q' => 27.00, 'r' => 13.00],
        ['a' => 13, 'b' => 3, 'c' => 1, 'd' => 3, 'e' => 0.31, 'f' => 3.16, 'g' => 9.00, 'h' => 13.00, 'i' => 13.00, 'j' => 6.00, 'k' => 7.00, 'l' => 2.70, 'm' => 2.70, 'n' => 2.70, 'o' => 10.00, 'p' => 12.00, 'q' => 23.00, 'r' => 9.00],
        ['a' => 21, 'b' => 4, 'c' => 2, 'd' => 1, 'e' => 1.35, 'f' => 5.95, 'g' => 13.00, 'h' => 22.00, 'i' => 22.00, 'j' => 10.00, 'k' => 11.00, 'l' => 3.80, 'm' => 3.80, 'n' => 3.80, 'o' => 16.00, 'p' => 22.00, 'q' => 37.00, 'r' => 17.00],
        ['a' => 22, 'b' => 5, 'c' => 2, 'd' => 2, 'e' => 0.72, 'f' => 4.32, 'g' => 11.00, 'h' => 20.00, 'i' => 20.00, 'j' => 8.00, 'k' => 11.00, 'l' => 3.25, 'm' => 3.25, 'n' => 3.25, 'o' => 14.00, 'p' => 16.00, 'q' => 28.00, 'r' => 14.00],
        ['a' => 23, 'b' => 6, 'c' => 2, 'd' => 3, 'e' => 0.33, 'f' => 3.78, 'g' => 10.00, 'h' => 16.00, 'i' => 16.00, 'j' => 7.00, 'k' => 9.00, 'l' => 3.00, 'm' => 3.00, 'n' => 3.00, 'o' => 12.00, 'p' => 13.00, 'q' => 25.00, 'r' => 10.00],
        ['a' => 31, 'b' => 7, 'c' => 3, 'd' => 1, 'e' => 1.55, 'f' => 7.00, 'g' => 22.00, 'h' => 25.00, 'i' => 'R', 'j' => 10.00, 'k' => 22.00, 'l' => 4.50, 'm' => 4.50, 'n' => 4.50, 'o' => 21.00, 'p' => 25.00, 'q' => 40.00, 'r' => 19.00],
        ['a' => 32, 'b' => 8, 'c' => 3, 'd' => 2, 'e' => 0.86, 'f' => 5.40, 'g' => 16.00, 'h' => 22.00, 'i' => 27.00, 'j' => 9.00, 'k' => 18.00, 'l' => 4.00, 'm' => 4.00, 'n' => 4.00, 'o' => 17.00, 'p' => 18.00, 'q' => 30.00, 'r' => 15.00],
        ['a' => 33, 'b' => 9, 'c' => 3, 'd' => 3, 'e' => 0.40, 'f' => 4.32, 'g' => 13.00, 'h' => 19.00, 'i' => 19.00, 'j' => 8.00, 'k' => 11.00, 'l' => 3.25, 'm' => 3.25, 'n' => 3.25, 'o' => 16.00, 'p' => 14.00, 'q' => 28.00, 'r' => 10.00],
        ['a' => 41, 'b' => 10, 'c' => 4, 'd' => 1, 'e' => 1.95, 'f' => 8.11, 'g' => 'R', 'h' => 'R', 'i' => 'R', 'j' => 10.00, 'k' => 'R', 'l' => 5.40, 'm' => 5.40, 'n' => 5.40, 'o' => 26.00, 'p' => 30.00, 'q' => 46.00, 'r' => 21.00],
        ['a' => 42, 'b' => 11, 'c' => 4, 'd' => 2, 'e' => 0.94, 'f' => 6.50, 'g' => 'R', 'h' => 'R', 'i' => 'R', 'j' => 9.00, 'k' => 'R', 'l' => 4.50, 'm' => 4.50, 'n' => 4.50, 'o' => 22.00, 'p' => 20.00, 'q' => 37.00, 'r' => 16.00],
        ['a' => 43, 'b' => 12, 'c' => 4, 'd' => 3, 'e' => 0.52, 'f' => 5.40, 'g' => 16.00, 'h' => 22.00, 'i' => 22.00, 'j' => 8.00, 'k' => 14.00, 'l' => 3.80, 'm' => 3.80, 'n' => 3.80, 'o' => 21.00, 'p' => 15.00, 'q' => 32.00, 'r' => 11.00],
        ['a' => 51, 'b' => 13, 'c' => 5, 'd' => 1, 'e' => 2.20, 'f' => 11.89, 'g' => 'R', 'h' => 'R', 'i' => 'R', 'j' => 'R', 'k' => 'R', 'l' => 6.30, 'm' => 6.30, 'n' => 6.30, 'o' => 52.00, 'p' => 40.00, 'q' => 54.00, 'r' => 26.00],
        ['a' => 52, 'b' => 14, 'c' => 5, 'd' => 2, 'e' => 1.17, 'f' => 10.27, 'g' => 'R', 'h' => 'R', 'i' => 'R', 'j' => 'R', 'k' => 'R', 'l' => 5.40, 'm' => 5.40, 'n' => 5.40, 'o' => 35.00, 'p' => 30.00, 'q' => 40.00, 'r' => 18.00],
        ['a' => 53, 'b' => 15, 'c' => 5, 'd' => 3, 'e' => 0.66, 'f' => 8.65, 'g' => 25.00, 'h' => 25.00, 'i' => 25.00, 'j' => 'R', 'k' => 17.00, 'l' => 4.50, 'm' => 4.50, 'n' => 4.50, 'o' => 31.00, 'p' => 20.00, 'q' => 36.00, 'r' => 12.00]
    ];

}
function tar_bg(){
    return [
        ['a' => 1, 'b' => 35, 'c' => 20, 'd' => 30, 'e' => 20, 'f' => 20, 'g' => 20, 'h' => 20],
        ['a' => 2, 'b' => 42, 'c' => 21, 'd' => 35, 'e' => 22, 'f' => 22, 'g' => 22, 'h' => 22],
        ['a' => 3, 'b' => 50, 'c' => 22, 'd' => 40, 'e' => 25, 'f' => 30, 'g' => 30, 'h' => 25]
    ];

}

function appli_rabais($d156){
    $appli_rabais = [
        'j1' => 0,
        'f1' => 0.85,
        'f2' => 0.9,
        'f5' => 0.9,
        'f7' => 0.95,
    ];

    if($d156 <= 1200){
        $appli_rabais['j1'] = $appli_rabais['f1'];
    }elseif($d156 > 1200){
        $appli_rabais['j1'] = $appli_rabais['f2'];
    }elseif($d156 > 2500){
        $appli_rabais['j1'] = 1;
    }else{
        $appli_rabais['j1'] = 1;
    }

    return $appli_rabais;
}


function activia_options(){
    return 
    [
        ['name' => "Propriétaire ou copropriétaire", 'value' => 1, 'show' => 0],
        ['name' => "Construction matériaux durs < 90 %", 'value' => 0, 'show' => 1],
        ['name' => "Construction matériaux durs < 30 %", 'value' => 0, 'show' => 1],
        ['name' => "Couverture matériaux durs < 90 %", 'value' => 0, 'show' => 1],
        ['name' => "Couverture matériaux durs < 30 %", 'value' => 0, 'show' => 1],
        ['name' => "Présence de 200 à 3000 l d'essence", 'value' => 0, 'show' => 1],
        ['name' => "Présence de 8 à 30 bouteilles de butane (13 kg)", 'value' => 0, 'show' => 1],
        ['name' => "Renonciation à recours", 'value' => 0, 'show' => 1],
        ['name' => "Utilisation d'un chalumeau", 'value' => 0, 'show' => 1],
        ['name' => "Travail par points chauds", 'value' => 0, 'show' => 1],
        ['name' => "Détériorations immobilières", 'value' => 1, 'show' => 0],
        ['name' => "Responsabilité civile propriétaire d'immeuble", 'value' => 1, 'show' => 0],
        ['name' => "H1 - Bâtiment (réponse O/N)", 'value' => 1, 'show' => 0],
        ['name' => "Sans franchise", 'value' => 0, 'show' => 1],
        ['name' => "B2 - Pack tempête (réponse O/N)", 'value' => 1, 'show' => 0],
        ['name' => "Application d'une franchise supplémentaire de 2/7 d'indice", 'value' => 1, 'show' => 0],
        ['name' => "Pluralité de garanties (>6 garanties)", 'value' => 0, 'show' => 0],
        ['name' => "Batiment catégorie 1", 'value' => 0, 'show' => 1]
    ];
}

function calcul_smp(){
  return 3;
}


function f157($d156, $e157 = false){
    
    $f157 = 1;
    if($e157 == 1){
        $f157 = appli_rabais($d156)['j1'];
    }

    return $f157;
    
}

function f158($d156, $e158 = false){
     
    $f158 = 1;
    
    if($e158 && calcul_smp() >= 6){
        $f158 = appli_rabais($d156)['f5'];
    }

    return $f158;
}

function f159(){
    return 1;
}

function i152(){
    return 0;
}

function i25($profession_ref, $activia_option_1, $surface_of_property){

    if($activia_option_1 == 1){
        $activia_option_1 = true;
    }else{
        $activia_option_1 = false;
    }
    $class_de_rique = classe_de_rique_pour_contole($profession_ref);

    $a1_classe = $class_de_rique['inc_vv']; //h6
    $a2_classe = $a3_classe = $class_de_rique['bg']; //l6
     
    $a1 = $a2 = $a3 = 0;

    $a1_array = [
        tar_inc_vv()[$a1_classe]['d'],
        tar_inc_vv()[$a1_classe]['e'],
        tar_inc_vv()[$a1_classe]['b'],
        tar_inc_vv()[$a1_classe]['c'],
    ];    
    $a1_options = [
        false,
        false,
        $activia_option_1,
        false
    ]; 
    
    $a1_values = [
        $a1_options[0] ? $a1_array[0] * $surface_of_property : 0,
        $a1_options[1] ? $a1_array[1] * $surface_of_property : 0,
        $a1_options[2] ? $a1_array[2] * $surface_of_property : 0,
        $a1_options[3] ? $a1_array[3] * $surface_of_property : 0,
    ];

    $a1_sum = array_sum($a1_values);

    $a2_sum = 0;
    $a3_sum = 0;

    return $a1_sum + $a2_sum + $a3_sum;
}

function i36($i25, $request){
    //G27: if activia_option_2 I25 * 0.30 else 0
    $G27 = $request->activia_option_2 == 1 ? 0.30 * $i25 : 0;
    
    //G28: if activia_option_3 I25 * 1 else 0
    $G28 = $request->activia_option_3 == 1 ? 1 * $i25 : 0;    
    //G29: if activia_option_4 I25 * 0.30 else 0
    $G29 = $request->activia_option_4 == 1 ? 0.30 * $i25 : 0;    
    
    //G30: if activia_option_5 I25 * 0.50 else 0
    $G30 = $request->activia_option_5 == 1 ? 0.5 * $i25 : 0;    
    
    //G31: if activia_option_6 I25 * 0.25 else 0
    $G31 = $request->activia_option_6 == 1 ? 0.25 * $i25 : 0;    
    
    //G32: if activia_option_7 I25 * 0.20 else 0
    $G32 = $request->activia_option_7 == 1 ? 0.20 * $i25 : 0;       
    
    //G33: if activia_option_8 I25 * 0.25 else 0
    $G33 = $request->activia_option_8 == 1 ? 0.25 * $i25 : 0;       
                                //G34: 0.4 * I25
    $G34 = $request->activia_option_18 == 1 ? 0.4 * $i25 : 0;           
                                //G35: if activia_option_9 I25 * 0.5 else 0
    $G35 = $request->activia_option_9 == 1 ? 0.5 * $i25 : 0;       
                                //G36: if activia_option_10 I25 * 0.3 else 0
    $G36 = $request->activia_option_10 == 1 ? 0.3 * $i25 : 0;

    $i36 = $G27 + $G28 + $G29 + $G30 + $G31 + $G32 + $G33 + $G34 + $G35 + $G36;

    return $i36;
}

function i42($i25, $i36){
    return 0.15 * ($i25 + $i36);
}

function i60($vol, $location, $activia_option_11, $surface_of_property){

    $i60 = 0;

    $recherche_ligne = 0;

    $d46 = 0;

    $classe = $vol;
    $zone = $location;
    $concatenation = ($classe * 10) + $zone;
    
    $tar_vol = tar_vol();

    foreach ($tar_vol as  $row) {
        if($row['a'] == $concatenation){
            $recherche_ligne = $row['b'];
            $d46 = $row['e'];
            break;
        }
    }
    // return $concatenation;
    
    if($activia_option_11 == 1){
        $i60 = $surface_of_property * $d46;
    }

    return $i60;
    
}

function i69(){
    return 0;
}

function i78($bg, $objets_de_miroiterie_extérieurs){
    $i78 = 0;
    $d72 = null;
    // $e72 = 200;
    $e72 = $objets_de_miroiterie_extérieurs;
    $tar_bg = tar_bg();

    
    foreach ($tar_bg as $row) {
        if($row['a'] == $bg){
            $d72 = $row['b'];
        }
    }

    
    $f72 = ($e72 * $d72) / 1000;


    if(!($bg == 'R' || $f72 == 0)){
        if($f72 > 47){ // coti mimi = 47
            $i78 = $f72; 
        }else{
            $i78 = 47;
        }
    }

    return $i78;
}

function i82(){
    return 0;
}

function i88(){
    return 0;
    // return (3.10 * $avec_franchise_de)/1000; // tar_del_b3 * 200 / 1000;
}

function i91(){
    return 0;
}

function i116($request){

    // return $request->all();

    //G109+G111+G112+G113+G114+G116

    //G109
    
    //=INDEX(TarDDE!B1:B3,L6)
    $l6 = classe_de_rique_pour_contole($request->profession)['dde'];

    $tar_dde_b1_b3 = [
        1 => 0.15,
        2 => 0.2,
        3 => 0.37
    ];

    $D109 = $tar_dde_b1_b3[$l6];

    $tar_dde_d12 = $D109 * $request->surface_of_property;
    
    $tar_dde_b7 = 41;
    
    $tar_dde_d13 = $tar_dde_d12 > $tar_dde_b7 ? $tar_dde_d12 : $tar_dde_b7;
    
    
    $G109 = $request->activia_option_13 == 1 ? $tar_dde_d13 : 0;
    
    return $G109;
}

function i141($activia_option_12, $surface_of_property){
    $i141 = 0;

    $tar_rc_g20;
    $tar_rc_b12 = 17.00;
    $tar_rc_b13 = 25.00;
    $tar_rc_b14 = 0.04;
    $tar_rc_c14 = 27.00;
    $tar_rc_h15;
    $tar_rc_f20;

    //tar_rc_f20 = tar_rc_f14:tar_rc_f18

    $tar_rc_f14 = $surface_of_property == 0 ? 9 : 0;
    
    $tar_rc_f15 = $surface_of_property <= 150 ? 1 : 0;
    
    $tar_rc_f16 = $surface_of_property > 150 ? 20 : 0;
    
    $tar_rc_f17 = $surface_of_property <= 300 ? 30 : 0;
    
    $tar_rc_f18 = $surface_of_property > 300 ? 40 : 0;

    $tar_rc_f20 = $tar_rc_f14 + $tar_rc_f15 + $tar_rc_f16 + $tar_rc_f17 + $tar_rc_f18; 

    //$tar_rc_g20

    if($tar_rc_f20 == 31){
        $tar_rc_g20 = 1;
    }elseif($tar_rc_f20 == 50){
        $tar_rc_g20 = 2;
    }elseif ($tar_rc_f20 == 60) {
        $tar_rc_g20 = 3;
    }elseif ($tar_rc_f20 == 40) {
        $tar_rc_g20 = 'Y';
    }else{
        $tar_rc_g20 = 'X';
    }

    //$tar_rc_h13;

    if($tar_rc_g20 == 3){
        $tar_rc_h13 = $tar_rc_b14 * $surface_of_property;
    }else{
        $tar_rc_h13 = 0;
    }

    //$tar_rc_h15

    if($tar_rc_h13 > $tar_rc_c14){
        $tar_rc_h15 = $tar_rc_h13;
    }else{
        $tar_rc_h15 = $tar_rc_c14;
    }

    if($activia_option_12 == 1){
            //=IF(G20=1,B12,IF(G20=2,B13,H15))

            if($tar_rc_g20 == 1){
                $i141 = $tar_rc_b12;
            }elseif($tar_rc_g20 == 2){
                $i141 =$tar_rc_b13;
            }else{
                $i141 = $tar_rc_h15;
            }
    }
    return $i141;
}


function i155($i116, $i91, $i88, $i82, $i78, $i69, $i60, $i42, $i36, $i25){
    return ($i116 + $i91 + $i88 + $i82 + $i78 + $i69 + $i60 + $i42 + $i36 + $i25) * 0.14;
}
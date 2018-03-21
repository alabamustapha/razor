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


function activia_options(){
    return 
    [
        "Propriétaire ou copropriétaire",
        "Construction matériaux durs < 90 %",
        "Construction matériaux durs < 30 %",
        "Couverture matériaux durs < 90 %",
        "Couverture matériaux durs < 30 %",
        "Présence de 200 à 3000 l d'essence",
        "Présence de 8 à 30 bouteilles de butane (13 kg)",
        "Renonciation à recours",
        "Utilisation d'un chalumeau",
        "Travail par points chauds",
        "Détériorations immobilières",
        "Objets de miroiterie extérieurs",
        "Avec franchise de 1/3 x l'indice",
        "Renonciation à recours",
        "Responsabilité civile propriétaire d'immeuble"
    ];
}
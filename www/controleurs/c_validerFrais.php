
<?php

/**
 * Gestion de l'affichage des frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
if (!$action) {
    $action = 'choixVisiteur';
}


switch ($action) {
    case 'choixVisiteur':
        $mois = getMois(date('d/m/Y'));
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $lesCles = array_keys($lesVisiteurs);
        $moisASelectionner = $lesCles[0];
        $lesMois = getLesDouzesDerniersMois($mois);
        //var_dump($lesMois);
        include 'vues/v_choixVisiteurMois.php';
        break;

    case 'ficheFrais':
        $visiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_SPECIAL_CHARS);
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
        $numAnnee = substr($mois, 0, 4);
        $numMois = substr($mois, 4, 2);
        //var_dump($visiteur, $mois);
        $visiteurASelectionner = $visiteur;
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $lesCles = array_keys($lesVisiteurs);
        $moisASelectionner = $mois;
        $mois2 = getMois(date('d/m/Y'));
        $lesMois = getLesDouzesDerniersMois($mois2);
        $lesFraisForfait = $pdo->getLesFraisForfait($visiteur, $mois);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteur, $mois);
        $nbJustificatif = $pdo->getNbjustificatifs($visiteur, $mois);
        var_dump($nbJustificatif);

        if (empty($lesFraisForfait) && empty($lesFraisHorsForfait)) {
            ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
            include 'vues/v_erreurs.php';
            header("Refresh: 2;URL=index.php?uc=validerFrais&action=choisirVisiteurMois");
        } else {
            include 'vues/v_ficheFraisVisiteur.php';
        }



        break;

    case 'corrigerMajFraisForfait':
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_SPECIAL_CHARS);
        $mois2 = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $nbJustificatif = $pdo->getNbjustificatifs($idVisiteur, $mois2);
        $mois = getMois(date('d/m/Y'));
        //var_dump($mois, $idVisiteur, $lesFrais);
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $mois2, $lesFrais);
            $lesVisiteurs = $pdo->getLesVisiteurs();
            $visiteurASelectionner = $idVisiteur;
            $moisASelectionner = $mois2;
            $lesMois = getLesDouzesDerniersMois($mois);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois2);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois2);
            include 'vues/v_ficheFraisVisiteur.php';
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
        break;

    case 'MajFraisHorsForfait':
        $idFrais = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_SPECIAL_CHARS);
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_SPECIAL_CHARS);
        $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
        $nbJustificatif = $pdo->getNbjustificatifs($idVisiteur, $mois);

        if (isset($_POST['corriger'])) {
            echo 'corriger';
            var_dump($mois, $idVisiteur, $libelle, $date, $montant, $idFrais);
            valideInfosFrais($date, $libelle, $montant);
            if (nbErreurs() != 0) {
                include 'vues/v_erreurs.php';
            } else {
                $nbJustificatif = $pdo->getNbjustificatifs($idVisiteur, $mois);
                $pdo->majFraisHorsForfait($idVisiteur, $mois, $libelle, $date, $montant);
                $lesVisiteurs = $pdo->getLesVisiteurs();
                $visiteurASelectionner = $idVisiteur;
                $moisASelectionner = $mois;
                $mois2 = getMois(date('d/m/Y'));
                $lesMois = getLesDouzesDerniersMois($mois2);
                $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
                include 'vues/v_ficheFraisVisiteur.php';
            }
        } elseif (isset($_POST['reporter'])) {
            echo 'reporter';
            valideInfosFrais($date, $libelle, $montant);
            if (nbErreurs() != 0) {
                include 'vues/v_erreurs.php';
            } else {
                $libelle2 = ' Refusé' . $libelle;
                $pdo->majFraisHorsForfait($idVisiteur, $mois, $libelle2, $date, $montant);
                $mois2 = $mois + 1;
                var_dump($mois2);
                if ($pdo->estPremierFraisMois($idVisiteur, $mois2)) {
                    $pdo->creeNouvellesLignesFrais($idVisiteur, $mois2);
                }
                $pdo->creeNouveauFraisHorsForfait($idVisiteur, $mois2, $libelle, $date, $montant);
                $lesVisiteurs = $pdo->getLesVisiteurs();
                $visiteurASelectionner = $idVisiteur;
                $moisASelectionner = $mois;
                $lesMois = getLesDouzesDerniersMois($mois);
                $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
                $nbJustificatif = $pdo->getNbjustificatifs($idVisiteur, $mois);
                include 'vues/v_ficheFraisVisiteur.php';
            }
        } elseif (isset($_POST['supprimer'])) {
            echo 'supprimer';
            var_dump($idFrais);
            $nbJustificatif = $pdo->getNbjustificatifs($idVisiteur, $mois);
            $pdo->supprimerFraisHorsForfait($idFrais);
            $lesVisiteurs = $pdo->getLesVisiteurs();
            $visiteurASelectionner = $idVisiteur;
            $moisASelectionner = $mois;
            $lesMois = getLesDouzesDerniersMois($mois);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
            include 'vues/v_ficheFraisVisiteur.php';
        }

        break;

    case 'valider':
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_SPECIAL_CHARS);
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        $totalFraisHorsForfait = $pdo->montantFraisForfait($idVisiteur, $mois);
        $totalFraisForfait = $pdo->montantHorsForfait($idVisiteur, $mois);
        $montantTotal = $totalFraisHorsForfait+$totalFraisForfait ;
        var_dump($montantTotal);
        include 'vues/v_fraisValides.php';
}

<?php
/**
 * Index du projet GSB
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr> et Dvorah Schvarcz
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

require_once 'includes/fct.inc.php'; //appelle la page des fonctions qui doit obligatoirement s'ouvrir si non erreur fatale
require_once 'includes/class.pdogsb.inc.php';
session_start();
$pdo = PdoGsb::getPdoGsb();//la fonction getPdoGst qui se trouve dans la class PdoGst on l a mis dans la variable pdo
$estConnecteV = estConnecteV();//esConnecte prend le resultat de la fonction est connecte (la variable id visiteur est rempli ou nn)
$estConnecteC = estConnecteC();
require 'vues/v_entete.php';//fait appel à la vue de l'entête
$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_SPECIAL_CHARS);
if ($uc && !$estConnecteV && !$estConnecteC) {
    $uc = 'connexion';
} elseif (empty($uc)) {
    $uc = 'accueil';
}
switch ($uc) {
case 'connexion':
    include 'controleurs/c_connexion.php';
    break;
case 'accueil':
    include 'controleurs/c_accueil.php';
    break;
case 'gererFrais':
    include 'controleurs/c_gererFrais.php';
    break;
case 'etatFrais':
    include 'controleurs/c_etatFrais.php';
    break;
case 'validerFrais':
    include 'controleurs/c_validerFrais.php';
    break;
case 'mettreEnPaiement':
    include 'controleurs/c_mettreEnPaiement.php';
    break;
case 'deconnexion':
    include 'controleurs/c_deconnexion.php';
    break;
}
require 'vues/v_pied.php';

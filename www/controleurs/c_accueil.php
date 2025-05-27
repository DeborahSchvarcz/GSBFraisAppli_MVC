<?php
/**
 * Gestion de l'accueil
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr> & dvorah Schvarcz
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

if ($estConnecteV) {
    include 'vues/v_accueilVisiteurs.php';

}
else if ($estConnecteC) {
    include 'vues/v_accueilComptable.php';
} else  {
    include 'vues/v_connexion.php';
}
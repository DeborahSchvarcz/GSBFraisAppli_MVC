<?php
/**
 * Vue Accueil comptable
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr> & Schvarcz Déborah
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>

<div id="accueil">
    <h2>
        Gestion des frais<small> - Comptable : 
            <?php 
            echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']
            ?></small>
    </h2>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" style= "border-color: orange ;" >
            <div class="panel-heading" style="background-color:orange; border-color: orange">
                <h3 class="panel-title" style="background-color:orange ;" >
                    <span class="glyphicon glyphicon-bookmark"></span>
                    Navigation
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <a href="index.php?uc=validerFrais&action=choixVisiteur"
                           class="btn btn-success btn-lg" role="button">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <br>Valider la fiche des frais</a>
                        <a href="index.php?uc=mettreEnPaiement&action=choixFiche"
                           class="btn btn-primary btn-lg" role="button" style="background-color: orange ; border-color: orange">
                            <span class="glyphicon glyphicon-list-alt"></span>
                            <br>Mettre en paiement</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
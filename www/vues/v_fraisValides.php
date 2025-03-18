<?php
/**
 * Vue frais valides
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
?>
</header>
<center>
    <?php
    $lesVisiteurs = $pdo->getLesVisiteurs();
    foreach ($lesVisiteurs as $unVisiteur) {
        $id = $unVisiteur['id'];
        $nom = $unVisiteur['nom'];
        $prenom = $unVisiteur['prenom'];
    }
    ?>
    <h3> Fiche de frais validée avec succès !</h3>
    <h2> La fiche de frais du <small> - Visiteur :
    <?php
    echo $nom . ' ' . $prenom;
    ?></small> a été validée . <h2/>
    <h4> Les frais hors forfaits signalés comme 'refusés' ont été reporter pour le mois prochain . </h4>
<?php
    echo $montantTotal . ' ' . $prenom;
    ?>

</center>

</body>
</html>






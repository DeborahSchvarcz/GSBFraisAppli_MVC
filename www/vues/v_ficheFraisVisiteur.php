<form method="post" 
      action="index.php?uc=validerFrais&action=corrigerMajFraisForfait" 
      role="form">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="lstVisiteurs" accesskey="n"> Visiteurs : </label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        if ($id == $visiteurASelectionner) {
                            ?>
                            <option selected value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        }
                    }
                    ?>  
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="lstMois" accesskey="n"> Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>  
                </select>
            </div>
        </div>
    </div>


    <div class="row" style="color":orange>   
        <h2>Valider la fiche de frais 
        </h2>
        <h3>Eléments forfaitisés</h3>
        <div class="col-md-4">

            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite'];
                    ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    <?php
                }
                ?>
                <button class="btn btn-success" type="submit">Corriger</button>
                <button class="btn btn-danger" type="reset">Réinitialiser</button>
            </fieldset>

        </div>
    </div>
</form>
<hr>
<form method="post" 
      action="index.php?uc=validerFrais&action=MajFraisHorsForfait" 
      role="form">
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">Descriptif des éléments hors forfait</div>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th class="date">Date</th>
                        <th class="libelle">Libellé</th>  
                        <th class="montant">Montant</th>  
                        <th class="action">&nbsp;</th> 
                    </tr>
                </thead>  
                <tbody>
                    <?php
                    foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                        $idVisiteur = $unFraisHorsForfait['idvisiteur'];
                        $mois = $unFraisHorsForfait['mois'];
                        $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                        $date = $unFraisHorsForfait['date'];
                        $montant = $unFraisHorsForfait['montant'];
                        $idFHF = $unFraisHorsForfait['id'];
                        ?>  

                    <td>
                        <!-- &id=<?php echo $idFHF ?> --> 
                        <input type="hidden" name="id" type="int" value="<?php echo $idFHF ?>">
                        <input type="hidden" name="lstVisiteurs" type="int" value="<?php echo $idVisiteur ?>">
                        <input type="hidden" name="lstMois" type="int" value="<?php echo $mois ?>">
                        <input name="date" type="text" value="<?php echo $date ?>"></td>
                    <td>  <input name="libelle" type="text" value="<?php echo $libelle ?>"></td>
                    <td>  <input name="montant" type="text" value="<?php echo $montant ?>"></td>
                    <td>
                        <input name="corriger" id="corriger" class="btn btn-success" type="submit" value="Corriger">
                        <input name="reporter" id="reporter"  class="btn btn-success" type="submit" value="Reporter">
                        <input name="supprimer"id="supprimer" class="btn btn-danger" type="submit" value="Supprimer" ></td>
                    </tr>
                    </tr>
                    <?php
                }
                ?>
                </tbody>  
            </table>
        </div>
    </div>
    <div>
        <p> Nombre de justificatifs : </p>
        <input name="$nbJustificatif" type="text" size ="3 px" value=" <?php echo $nbJustificatif ?>">
    </div>
</form>
<form method="post" action="index.php?uc=validerFrais&action=valider" 
      role="form">
    <button class="btn btn-success" type="submit">Valider</button>
    <input type="hidden" name="id" type="int" value="<?php echo $idFHF ?>">
    <input type="hidden" name="lstVisiteurs" type="int" value="<?php echo $idVisiteur ?>">
    <input type="hidden" name="lstMois" type="int" value="<?php echo $mois ?>">

</form>



<?php
    if(!isset($_SESSION['id'])) {
        echo '<form action="index.php" method="post">';
        echo '<fieldset style="width:200px">';
        echo '<p>Se connecter</p><br><br>';
        echo '<label for="<br>">Identifiant</label>';
        echo '<input type="email" id="identifiantMel" name="idMel" required<br><br>';
        echo '<label for="txtMDP">Mot de passe</label>';
        echo '<input type="password" id="identifiantMDP" name="idMDP" required><br><br>';
        echo '<input type="submit" name="btn_login" value="Connexion">';
        echo '</fieldset>';
        echo '</form>';
    } else {
        echo '<form action="index.php" method="post">';
        echo '<fieldset style="width:200px;">';
        echo '<label for="<br>">'.$_SESSION['prenom_membre']. ' '.$_SESSION['nom_membre'].'</label><br>';
        echo '<label for="info_Mail">'.$_SESSION['mel_membre'].'</label><br>';
        echo '<br>';
        echo '<label for="info_Adresse">'.$_SESSION['adresse'].'</label><br>';
        echo '<label for="info_CodePostal">'.$_SESSION['codePostal_membre']. ' '.$_SESSION['ville_membre'];
        echo '<input type="submit" value="Se déconnecter" name="btn_logout">';
        echo '</fieldset>';
        echo '</form>';
    }
?>
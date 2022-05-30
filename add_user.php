<?php
    session_start();
?>
<?php
    if (!isset($_SESSION['profil_admin'])) { // Si l'utilisateur n'est pas un administrateur et que la variable de session ne contient aucune données, alors on interdit la connexion.
        header("Location: http://localhost/biblio-drive/forbiden.php");
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Ajouter un utilisateur</title>
        <meta charset="utf-8">
        <!-- charset=UTF-8 : pour que les caractères accentués ressortent correctement -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- la balise ci-dessus indique que l'affichage doit se faire sur la totalité de l'écran, par défaut voir Responsive Design -->
    </head>
    <body>
        <?php
            require_once('connexion.php'); // Je me connecte au serveur SQL sur ma base de donnée biblio-drive.
        ?>
        <p>La Bibliothèque de Moulinsart est fermée au public jusqu'à nouvel ordre. Mais il vous est possible de réserver et retirer vos livres via notre service Biblio Drive !</p>
        <fieldset>
            <p><a href="http://localhost/biblio-drive/add_book.php">Ajouter un livre</a> Créer un membre</p>
        </fieldset>
        <h1>Créer un membre</h1>
        <form action="add_user.php" method="get">
            Mel : <input type="email" name="mel" required><br>
            Mot de passe : <input type="password" name="password" required><br>
            Nom : <input type="text" name="txtNom" required><br>
            Prénom : <input type="text" name="txtPrenom" required><br>
            Adresse : <input type="text" name="txtAdresse" required><br>
            Ville : <input type="text" name="txtVille" required><br>
            Code Postal : <input type="text" name="txtPostal" required><br>
            <input type="submit" value="Créer un membre" name="btn_creation_utilisateur">
        </form>
        <?php
        echo '<form action="logout.php" method="get">';
        echo '<fieldset style="width:200px;">';
        echo '<label for="<br>">'.$_SESSION['profil_admin'].'</label><br>';
        echo '<label for="info_Prenom_&_Nom">'.$_SESSION['prenom']. ' ' .$_SESSION['nom'].'</label><br>';
        echo '<label for="info_Mail">'.$_SESSION['mel']. '</label><br>';
        echo '<br>';
        echo '<input type="submit" name="btn_logout" value="Se déconnecter">';
        echo '</fieldset>';
        echo '</form>';
        ?>
        <?php
        if (isset($_GET['btn_creation_utilisateur'])) {
            try { // On passe par la par défaut si aucune erreur détectée.
                //FAUT UTILISER DES BINDVALUE COMME LE 8.24.18 SINON C'EST PAS BON !!! / VOIR add_book.php
                $stmt = $connexion->prepare("INSERT INTO utilisateur VALUES (:mel, :motDePasse, :nom, :prenom, :adresse, :ville, :codePostal, 'Membre')");
                $stmt->bindValue(':mel', $_GET['mel'], PDO::PARAM_STR);
                $stmt->bindValue(':motDePasse', $_GET['password'], PDO::PARAM_STR);
                $stmt->bindValue(':nom', $_GET['txtNom'], PDO::PARAM_STR);
                $stmt->bindValue(':prenom', $_GET['txtPrenom'], PDO::PARAM_STR);
                $stmt->bindValue(':adresse', $_GET['txtAdresse'], PDO::PARAM_STR);
                $stmt->bindValue(':ville', $_GET['txtVille'], PDO::PARAM_STR);
                $stmt->bindValue(':codePostal', $_GET['txtPostal'], PDO::PARAM_INT);
                $stmt->execute();
                $nb_ligne_affectees = $stmt->rowCount();
                echo $nb_ligne_affectees." ligne() insérée(s).<br>";
        } catch (Exception $e) { // Si une erreur se produit dans la tentative d'insertion alors on affiche le message d'erreur et on arrête le programme.
            echo "Problème concernant l'ajout de l'utilisateur : ".$e->getMessage();
            die();
        }
    }
        ?>
     </body>
</html>             
<?php // Démarrage de la session.
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
        <title>Ajouter un livre</title>
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
            <p>Ajouter un livre <a href="http://localhost/biblio-drive/add_user.php">Créer un membre</a></p>
        </fieldset>
        <h1>Ajouter un livre</h1>
        <form action="add_book.php" method="get">
            Auteur : <select name="auteur">
            <?php
            $stmt = $connexion->prepare("SELECT nom, noauteur FROM auteur");
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            while ($enregistrement = $stmt->fetch())
            {
                echo '<option value='.$enregistrement->noauteur.'>'.$enregistrement->nom.'</option>';
            }
        ?>
            </select><br>
            Titre : <input type="text" name="txtTitre" required><br>
            ISBN13 : <input type="text" name="txtISBN13" required><br>
            Année de parution : <input type="text" name="txtParution" required><br>
            Résumé : <input type="text" name="txtResume" required><br>
            Image : <input type="text" name="txtImage" required><br>
            <input type="submit" value="Ajouter" name="btn_creation_livre">
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
        if (isset($_GET['btn_creation_livre'])) {
            try { // Tentative d'insertion de donnée.
                //PRENDRE EXEMPLE SUR CE CODE PHP
                $dateajout = date('Y-m-d'); // VOIR AFFICHAGE DATE DANS LGBDR / BDD
                //$nolivre = rand(1, 100000);
                $stmt = $connexion->prepare("INSERT INTO livre (noauteur, titre, isbn13, anneeparution, resume, dateajout, image) VALUES (:noauteur, :titre, :isbn13, :anneeparution, :resume, :dateajout, :image)");
                //$stmt->bindValue(':nolivre', $nolivre, PDO::PARAM_INT);
                $stmt->bindValue(':noauteur', $_GET['auteur'], PDO::PARAM_INT);
                $stmt->bindValue(':titre', $_GET['txtTitre'], PDO::PARAM_STR);
                $stmt->bindValue(':isbn13', $_GET['txtISBN13'], PDO::PARAM_STR);
                $stmt->bindValue(':anneeparution', $_GET['txtParution'], PDO::PARAM_INT);
                $stmt->bindValue(':resume', $_GET['txtResume'], PDO::PARAM_STR);
                $stmt->bindValue(':dateajout', $dateajout, PDO::PARAM_STR);
                $stmt->bindValue(':image', $_GET['txtImage'], PDO::PARAM_STR);
                $stmt->execute();
                $nb_ligne_affectees = $stmt->rowCount();
                echo $nb_ligne_affectees." ligne() insérée(s).<br>";
            } catch (Exception $e) { // Si une erreur se produit dans notre insertion, on va se redirigée vers l'arrêt d'urgence du programme
                echo "Problème concernant l'insertion du livre : ".$e->getMessage();
                die(); // On peut mettre un die() ici car pas d'autre programme en dessous sinon pas de die()
            }
        }
        ?>
     </body>
</html>             
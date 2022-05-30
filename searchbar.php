<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Résultat de votre recherche</title>
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
        <form action="searchbar.php" method="get">
            <input type="text" name="searchbar" placeholder="Rechercher dans le catalogue (saisie du nom de l'auteur)" required>
            <input type="submit" value="Rechercher" name="btn_searchbar">
        </form>
        <?php
            if (isset($_SESSION["id"])) { // Si l'utilisateur est connectée sur le site, on va afficher le bouton panier.
                echo '<form action="index.php" method="get">';
                echo '<input type="submit" value="Panier" name="btn_shop">';
                echo '</form>';
            }
        ?>
        <?php
            if (isset($_GET["btn_shop"])) { // Si l'utilisateur clique sur le bouton 'Panier' alors on va le rediriger vers son panier personnel.
                header("Location: http://localhost/biblio-drive/shop.php");
            }
        ?>
         <?php // Page de connexion qui est dans une autre page.
            require('login_info.php');
        ?>
        <?php
        if (isset($_GET['btn_searchbar'])) {
            try {
                require_once('connexion.php');
                $stmt = $connexion->prepare("SELECT titre, anneeparution, nolivre FROM livre, auteur WHERE auteur.noauteur = livre.noauteur AND auteur.nom = :nomAuteur");
                $stmt->bindValue(':nomAuteur', $_GET['searchbar'], PDO::PARAM_STR);
                $stmt->setFetchMode(PDO::FETCH_OBJ); // Permet de faire $enregistrement->titre par exemple.
                $stmt->execute();
                while ($enregistrement = $stmt->fetch()) {
                    echo '<a href="http://localhost/biblio-drive/book_presentation.php?nolivre='.$enregistrement->nolivre.'">'.$enregistrement->titre. ' ' .$enregistrement->anneeparution.'</a><br>';
                } // Il est possible de faire $_GET['nolivre'] provenant de $enregistrement->nolivre en dehors d'un fichier a condition qu'il soit dans un lien.
            } catch (Exception $e) {
                echo 'Problème sur la recherche : '.$e->GetMessage();
            }

        }
        ?>
    </body>
</html>
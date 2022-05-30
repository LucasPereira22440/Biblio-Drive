<?php
    session_start();
    // PAS DE BOUTON QUE DES LIENS, REDECOREE LES LIENS EN BOUTON SUR BOOTSTRAP
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Présentation livre</title>
        <meta charset="utf-8">
        <!-- charset=UTF-8 : pour que les caractères accentués ressortent correctement -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- la balise ci-dessus indique que l'affichage doit se faire sur la totalité de l'écran, par défaut voir Responsive Design -->
    </head>
    <body>
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
        <h5>Résumé du livre</h5>
        <?php // Je vais lister les informations de tous les livres après avoir cliquée sur le lien unique du livre.
            require_once('connexion.php');
            $stmt = $connexion->prepare("SELECT resume, anneeparution, image, nolivre FROM livre WHERE nolivre = :nolivre");
            $stmt->bindValue(':nolivre', $_GET['nolivre'], PDO::PARAM_INT); //$_GET['nolivre] n'est pas une variable de type superglobal mais en réalité, elle prend le paramètre passer en URL qui est ...nolivre=x / Voir l'URL générée dans searchbar.php après le point d'interrogation.
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            if ($enregistrement = $stmt->fetch()) { // J'affiche toute le résumé du livre ainsi que sa date de parution et son et son image depuis la BDD
                $_SESSION['nolivre'] = $enregistrement->nolivre; // NE PAS METTRE EN PARAMETRE, IL EST MIEUX DE FAIRE UN LIEN style http://localhost/biblio-drive/add_shop.php?nolivre=$enregistrement->nolivre PUIS RECUPERER LE NUMERO DU LIVRE AVEC UN GET DNAS ADD_SHOP.PHP
                echo $enregistrement->resume.'<br>';
                echo '<br>';
                echo 'Date de parution : '.$enregistrement->anneeparution.'<br>';
                echo '<br>';
                echo '<img src="'.$enregistrement->image.'"/>';
            } else { // ELSE UN PEU DEBILE CAR LE TRAITEMENT A DEJA ETE FAIT EN AMONT PAR LA BARRE DE RECHERCHE, IL EST DONC INUTILE POUR LE MOMENT
                echo 'Erreur dans la recherche, veuillez réessayez !';
            }
        ?>
        <br>
        <?php
            $stmt = $connexion->prepare("SELECT titre, emprunter.nolivre FROM livre, emprunter WHERE livre.nolivre = emprunter.nolivre AND livre.nolivre = :nolivre");
            $stmt->bindValue(':nolivre', $_GET['nolivre'], PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            if ($enregistrement = $stmt->fetch()) { // Si un livre est emprunté, j'indique dans tout les cas que le livre est réservée.
                echo "Indisponible : Un utilisateur à déjà réservée ce livre.";
            } else { // Sinon le livre n'est pas réservée mais 2 solutions existe...
                if (isset($_SESSION["id"])) { // Soit je suis connectée auquel cas l'utilisateur peut réserver le livre.
                    echo '<form action="book_presentation.php" method="get">';
                    echo 'Disponible <a href="http://localhost/biblio-drive/add_shop.php ">Emprunter (ajout au panier)</a>';
                    echo '</form>';
                } else { // Soit je suis pas connectée alors j'invite le visiteur à se connecter au site pour réserver le livre.
                    echo "Disponible : Pour pouvoir réserver vous devez posséder un compte et vous identifier.";
                }
            }
        ?>
        <?php
             // Si j'appuie sur le bouton pour réserver un livre, je vais préparer le script pour insérer le livre.
            //if (isset($_GET['btn_add_shop'])) {
                //$dateemprunt = date('Y-m-d');
                //$dateretour = date('2022-01-12');
                //$stmt = $connexion->prepare("INSERT INTO emprunter VALUES (:mel, :nolivre, :dateemprunt, :dateretour)");
                //$stmt->bindValue(':mel', $_SESSION['shop'], PDO::PARAM_STR);
                //$stmt->bindValue(':nolivre',  $_SESSION["nobook"], PDO::PARAM_INT);
                //$stmt->bindValue(':dateemprunt', $dateemprunt, PDO::PARAM_STR);
                //$stmt->bindValue(':dateretour', $dateretour, PDO::PARAM_STR);
                //$stmt->setFetchMode(PDO::FETCH_OBJ);
                //$stmt->execute();
                //$nb_ligne_affectees = $stmt->rowCount();
                //if ($nb_ligne_affectees != 0) { // Si le nombre de ligne générée dans la base de données est différent de 0 c'est-à-dire qu'on à insérer des données dans la base de donnée.
                    //echo "Votre livre est ajoutée au panier !";
                    //header("Refresh:2;url=http://localhost/biblio-drive/book_presentation.php");
                //} else { // Si aucun livre n'a été affectée a la base de données alors je vais indiquer à l'utilisateur que le livre n'a pas été ajoutée à son panier.
                    //echo "Erreur dans l'ajout de ce livre dans votre panier !";
                //}
            //}
        ?>
    </body>
</html>
<?php
    session_start();
    // Mettre un tableau dans le panier exemple ($_SESSION["id"] = [nolivre])
    // PAS DE BOUTON QUE DES LIENS, REDECOREE LES LIENS EN BOUTON SUR BOOTSTRAP
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Votre panier</title>
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
        <?php // Page de connexion qui est dans une autre page.
            require('login_info.php');
        ?>
        <h4>Votre panier</h4>
        <?php // Si je suis connectée alors, je vais afficher les emprunts effectués de l'utilisateur connéctées.
            //if (isset($_SESSION["id"])) {
                //require_once('connexion.php');
                //$stmt = $connexion->prepare("SELECT prenom, nom, titre, anneeparution FROM auteur, livre, emprunter WHERE emprunter.nolivre = livre.nolivre AND livre.noauteur = auteur.noauteur AND emprunter.mel = :user");
                //$stmt->bindValue(':user', $_SESSION["shop"] , PDO::PARAM_STR);
                //$stmt->setFetchMode(PDO::FETCH_OBJ);
                //$stmt->execute();
                //while ($enregistrement = $stmt->fetch()) {
                    //echo '<form action="shop.php" method="get">';
                    //echo $enregistrement->prenom. ' ' .$enregistrement->nom. ' - ' .$enregistrement->titre. ' ' .$enregistrement->anneeparution. ' '.'<input type="submit" name="btn_delete_shop" value="Annuler">';
                    //echo '</form>';
                //}
            //} else {
                //echo "Veuillez vous connectez pour accéder à votre panier.";
            //}
            if (!isset($_SESSION['id'])) { // Si je ne suis pas connectée, j'indique que l'utilisateur doit se connecter à son compte pour avoir son panier
                echo "Vous n'êtes pas connectez sur votre compte.";
            } elseif (count($_SESSION['panier']) == 0) { // Sinon si l'utilisateur est connectée et qu'il n'a pas de livre de réservée alors j'affiche qu'aucun livre n'est réservée.
                echo "Vous n'avez réservée aucun livre pour le moment !";
            } else { // Sinon j'affiche les livres réservées.
                print_r ($_SESSION['panier']);
                echo count($_SESSION['panier']);
                echo '<br>';
                echo '<a href="http://localhost/biblio-drive/confirm_shop.php">Valider le panier</a>';
                // Réservation = Livre dans la table emprunter - nbr livre dans le tableau associatif PHP
            }
        ?>
        <?php
            if (isset($_GET['btn_delete_shop'])) {
                $stmt = $connexion->prepare("DELETE FROM emprunter WHERE nolivre = :nolivre");
                $stmt->bindValue(':nolivre', $_SESSION['nobook'] , PDO::PARAM_STR);
                $stmt->execute();
                if ($enregistrement = $stmt->fetch()) {
                    echo "Livre supprimée de votre panier.";
                } else {
                    echo "Impossible de supprimer ce livre";
                    echo $_SESSION['nobook'];
                }
            }
        ?> 
    
    <?php // Il est important de mettre ce bouton à la toute fin pour que ce bouton soit placer toujours tout en bas de la page PHP
        if (isset($_SESSION["id"]) && (isset($_SESSION['tab_shop']))) {
            echo '<a href="http://localhost/biblio-drive/confirm_shop.php">Valider le panier</a>';
        }
    ?>
    </body>
</html>
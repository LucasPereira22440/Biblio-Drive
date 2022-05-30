<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Page d'accueil</title>
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
        <br>
        <?php // Page de connexion qui est dans une autre page.
            require('login_info.php');
        ?>
        <div name="login">
            <?php
            if (isset($_POST['btn_login'])) { // Si j'appuie sur le bouton de connexion alors je vais vérifier si un utilisateur correspond avec le même mel et MDP
                require_once('connexion.php');
                $stmt = $connexion->prepare("SELECT prenom, nom, mel, profil, adresse, codepostal, ville FROM utilisateur WHERE mel = :mel AND motdepasse = :mot_de_passe");
                $stmt->bindValue(':mel', $_POST['idMel'], PDO::PARAM_STR);
                $stmt->bindValue(':mot_de_passe', $_POST['idMDP'], PDO::PARAM_STR);
                $stmt->setFetchMode(PDO::FETCH_OBJ);
                $stmt->execute();
                if ($enregistrement = $stmt->fetch()) {
                    if ($enregistrement->profil == 'Administrateur') { // Si la personne connectée est un Administrateur alors on va redirigée vers les pages admins
                        $_SESSION['profil_admin'] = $enregistrement->profil;
                        $_SESSION['prenom'] = $enregistrement->prenom;
                        $_SESSION['nom'] = $enregistrement->nom;
                        $_SESSION['mel'] = $enregistrement->mel;
                        $_SESSION["id"] = $enregistrement->prenom. ' ' .$enregistrement->nom. ' ' .$enregistrement->mel. ' ' .$enregistrement->adresse. ' ' .$enregistrement->codepostal. ' ' .$enregistrement->ville; // Je stocke le nom, le prénom etc.. dans la variable supergolable $_SESSION[$id]
                        header("Location: http://localhost/biblio-drive/add_book.php");
                    } else {
                        //Création de la variable surperglobale $_SESSION[$id]
                        $id = $enregistrement->mel;
                        $_SESSION["id"] = $enregistrement->prenom. ' ' .$enregistrement->nom. ' ' .$enregistrement->mel. ' ' .$enregistrement->adresse. ' ' .$enregistrement->codepostal. ' ' .$enregistrement->ville; // Je stocke le nom, le prénom etc.. dans la variable supergolable $_SESSION[$id]
                        $_SESSION["mel_membre"] = $enregistrement->mel; //Sert uniquement pour afficher le panier de l'utilisateur concernée : Cela evite d'afficher tous les paniers de tous les membres.
                        $_SESSION['profil_membre'] = $enregistrement->profil;
                        $_SESSION['prenom_membre'] = $enregistrement->prenom;
                        $_SESSION['nom_membre'] = $enregistrement->nom;
                        $_SESSION['adresse'] = $enregistrement->adresse;
                        $_SESSION['codePostal_membre'] = $enregistrement->codepostal;
                        $_SESSION['ville_membre'] = $enregistrement->ville;
                        $_SESSION['panier'] = array(); // Permet d'enregistrer les numéros de livre si l'utilisateur réserve un livre.
                        header("Refresh:0");
                        //echo '<form action="index.php" method="get">';
                        //echo '<fieldset style="width:200px;">';
                        //echo '<label for="<br>">'.$_SESSION['prenom_membre']. ' '.$_SESSION['nom_membre'].'</label><br>';
                        //echo '<label for="info_Mail">'.$_SESSION['mel_membre'].'</label><br>';
                        //echo '<br>';
                        //echo '<label for="info_Adresse">'.$_SESSION['adresse'].'</label><br>';
                        //echo '<label for="info_CodePostal">'.$_SESSION['codePostal_membre']. ' '.$_SESSION['ville_membre'];
                        //echo '<input type="submit" value="Se déconnecter" name="btn_logout">';
                        //echo '</fieldset>';
                        //echo '</form>';
                        //echo $_SESSION["id"];
                        //echo '<form action="index.php" method="get">'; 
                        //echo '<input type="submit" value="Se déconnecter" name="btn_logout">'; // On récuperera ce bouton quand l'utilisateur voudra se déconnecter, l'utilisation du formulaire est obligatoire pour récuperer le bouton.
                        //echo '</form>';
                    }
                } else {
                    echo "Veuillez vérifier votre mot de passe ou votre identifiant ! Si vous n'avez pas de mot de passe, veuillez joindre un administrateur !";
                }
            }
            ?>
        </div>
            <?php
            // Si j'appuie sur le bouton "Se déconnecter" et que je suis connecter alors je vais déconnecter l'utilisateur en utilisant le fichier logout.php (require('logout.php'))
                if (isset($_POST['btn_logout'])) {
                    header("Location: http://localhost/biblio-drive/logout.php");
                }
            ?>
        <h5>Dernières acquisition</h5>
    </body>
</html>
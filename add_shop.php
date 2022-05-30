<?php
    session_start();
?>
<?php
    if (isset($_SESSION["id"]) && (count($_SESSION['panier']) < 5)) {
        // Pour rappel : $_SESSION['panier'] = array();
        array_push($_SESSION['panier'],$_SESSION["nolivre"]); // Je rajoute dans mon tableau panier, le numéro du livre.
        echo "Ajout de votre livre dans votre panier. Veuillez patientez...";
        header("Refresh:3;url=http://localhost/biblio-drive/shop.php");
    } elseif (isset($_SESSION["id"]) && (count($_SESSION['panier']) >= 5)) { // Si je suis connectée et que j'ai 5 livres ou plus, j'affiche un message en lui disant qu'il est impossible de réserver + redirection.
        echo "Vous ne pouvez plus réservez de livre, 5 réservations de livre possible... Redirection vers la page principal !";
        header("Refresh:3;url=http://localhost/biblio-drive/index.php");
    } else { // Si je ne suis pas connectée, j'affiche un message en disant qu'on a pas de profil Membre + redirection.
        echo "Redirection vers la page principal... Vous n'avez pas de profil Membre.";
        header("Refresh:3;url=http://localhost/biblio-drive/index.php");
    }
?>
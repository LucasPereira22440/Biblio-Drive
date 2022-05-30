<?php
    session_start(); // Initialisation de la session pour la supprimer par la suite.
?>

<?php
    if (isset($_SESSION["id"])) { // Si j'ai un compte actif, alors je vais déconnecter l'utilisateur.
        $_SESSION["id"];
        unset($_SESSION['id']);
        session_unset();
        session_destroy();
        echo "Deconnexion en cours... Merci de vouloir patienter...";
        header("Refresh:3;url=http://localhost/biblio-drive/index.php");
    } else { // Si je ne suis pas connecter, alors je vais informer l'utilisateur qu'aucune action sera effectuée et il sera dirigée vers la page principal du site.
        echo "Vous n'avez pas de compte actif, vous allez être redirigée vers la page principal.";
        header("Refresh:3;url=http://localhost/biblio-drive/index.php");
    }
?>
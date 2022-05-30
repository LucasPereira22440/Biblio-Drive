<?php
    session_start();
?>
<?php
    echo "Vous n'êtes pas Administrateur du site, redirection vers la page principal.";
    header("Refresh:3;url=http://localhost/biblio-drive/index.php");
?>
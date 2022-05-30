<?php
    session_start();
?>

<?php
    if (isset($_SESSION["id"])) {
        $panier_lenght = count($_SESSION['panier']);
        for ($insertion = 0; $insertion < $panier_lenght; $insertion++) {
            require_once("connexion.php");
            $dateemprunt = date('Y-m-d');
            $dateretour = date('2022-01-12');
            $stmt = $connexion->prepare("INSERT INTO emprunter VALUES (:mel, :nolivre, :dateemprunt, :dateretour)");
            $stmt->bindValue(':mel', $_SESSION["mel_membre"], PDO::PARAM_STR);
            $stmt->bindValue(':nolivre', $_SESSION['nolivre'], PDO::PARAM_INT);
            $stmt->bindValue(':dateemprunt', $dateemprunt, PDO::PARAM_STR);
            $stmt->bindValue(':dateretour', $dateretour, PDO::PARAM_STR);
            $stmt->execute();
            $nb_ligne_affectees = $stmt->rowCount();
            unset($_SESSION['panier'], $_SESSION['nolivre']);
        }
            echo "Ajout des livres dans votre panier...";
            $_SESSION['panier'] = array();
            header("Refresh:2;url=http://localhost/biblio-drive/index.php");
    } else {
        echo "Vous devez être connectée pour réserver des livres, redirection vers le site principal...";
        header("Refresh:3;url=http://localhost/biblio-drive/index.php");
    } 
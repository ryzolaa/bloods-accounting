<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('include.php');

if(isset($_SESSION['id'])) {
    header('Location: /accounting.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('_menu/head.php'); ?>
    <title>Bloods Accounting Home</title>

</head>

<body>
    <form method="post" class="formBox">

        <div class="row g-3">
            <h2 class="formTitle">Comptabilité Bloods</h2>
        </div>

        <div class="row g-3">

        </div>

        <div class="d-grid gap-2">
            <a class="btn btn-primary" href="login.php">Connexion</a>
        </div>



    </form>
    <?php require_once('_menu/footer.php'); ?>
    <link rel="stylesheet" href="/css/home.css">
</body>

</html>
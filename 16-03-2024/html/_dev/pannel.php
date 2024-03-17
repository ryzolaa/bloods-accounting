<?php
    require_once('../include.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Admin Pannel</title>
    <link rel="stylesheet" href="../css/pannel.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <?php include_once('../_menu/head.php') ?>
</head>

<body>
    <?php require_once('../_menu/menu.php'); ?>
    <div class="adminPannelLeft">
        <div class="shape1">Gestion du site</div>
        <div class="shape2">Changer le thème</div>
        <div class="shape2">Changer les prix</div>
        <div class="shape3">Logs</div>
    </div>
    <?php require_once('../_menu/footer.php') ?>
</body>

</html>
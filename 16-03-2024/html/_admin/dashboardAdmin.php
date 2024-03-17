<?php
    require_once('../include.php');
    
    $req = $conn->prepare('SELECT COUNT(*) AS nb FROM `user` WHERE `role` = 0');
    $req->execute();
    $result = $req->fetch();
    $userCount = $result['nb'];

    $req = $conn->prepare('SELECT COUNT(*) AS nb FROM `user` WHERE `role` = 1');
    $req->execute();
    $result = $req->fetch();
    $adminCount = $result['nb'];

    $req = $conn->prepare('SELECT COUNT(*) AS nb FROM `user` WHERE `role` = 2');
    $req->execute();
    $result = $req->fetch();
    $superAdminCount = $result['nb'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>DashBoard</title>
    <?php include_once('../_menu/head.php') ?>
</head>

<body>
    <?php require_once('../_menu/menu.php'); ?>

    <div class="adminCardBox">

        <div class="adminCard">
            <h5 class="adminCardTitle">Utilisateurs</h5>
            <p>Voir la liste des utilisateurs enregistrés sur le site.</p>
            <ul class="list-group list-group-flush">
                <li class=" cardComponent"></li>
                <li class="cardComponentText">Nombre d'utilisateurs:
                    <?= $userCount?></li>
                <li class=" cardComponent"></li>
                <li class=" cardComponentText">Nombre d'administrateurs:
                    <?= $adminCount?></li>
                <li class=" cardComponent"></li>
                <li class=" cardComponentText">Nombre de Super-Admin:
                    <?= $superAdminCount?></li>
                <li class=" cardComponent"></li>
            </ul>
            <br>
            <div class="d-grid gap-2">
                <a href="_admin/users.php" class="btn btn-primary">Voir les utilisateurs</a>
                <a href="../register.php" class="btn btn-primary">Créer un nouvel utilisateur</a>
            </div>
        </div>

        <div class="adminCard">
            <h5 class="adminCardTitle">Roles</h5>
            <p>Modifier le role des utilisateurs sur le site.</p>
            <div class="d-grid gap-2">
                <a href="_admin/role.php" class="btn btn-primary">Modifier les roles</a>
            </div>
        </div>

        <div class="adminCard">
            <h5 class="adminCardTitle">Dev Space</h5>
            <p>Espace dédié aux développeurs.</p>
            <div class="d-grid gap-2">
                <a href="_dev/devSpace.php" class="btn btn-primary">Dev Space</a>
            </div>
        </div>

    </div>
    <?php require_once('../_menu/footer.php') ?>
</body>

</html>
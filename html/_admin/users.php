<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once('../include.php');

    if(!isset($_SESSION['id'])) {
        header('Location: /');
        exit;
    }

    $req = $conn->prepare("SELECT id, pseudo
    FROM user");

    $req->execute();

    $req_members = $req->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('../_menu/head.php') ?>
    <title>Users</title>
</head>

<body>
    <?php require_once('../_menu/menu.php') ?>
    <div class='users'>

        <h1 class="formTitle">Utilisateurs:</h1>

        <?php foreach ($req_members as $rm) { ?>

        <div class="mb-3 row" style="border: 2px solid; border-radius: 10px; padding: 5px;">
            <label class="col-auto"><?= $rm['id']; ?></label>
            <label class="col-auto"><?= $rm['pseudo']; ?></label>
            <div class="col-auto">
                <a class="btn btn-primary btn-sm" href="_admin/profils.php?id=<?= $rm['id']?>">Voir Profil</a><br>
            </div>
        </div>

        <?php } ?>
    </div>
    <?php require_once('../_menu/footer.php') ?>
</body>

</html>
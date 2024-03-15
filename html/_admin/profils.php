<?php

    require_once('../include.php');

    if(!isset($_SESSION['id'])) {
        header('Location: /');
        exit;
    }

    $get_id = (int) $_GET['id'];

    if($get_id <= 0) {
        header('Location: users.php');
        exit;
    };
    
    $req = $conn->prepare("SELECT *
    FROM user
    WHERE id = ?");

    $req->execute([$get_id]);

    $req_user = $req->fetch();

    $pseudo = $req_user['pseudo'];

    $mail = $req_user['mail'];

    $pass = $req_user['pass'];

    $date = date_create($req_user['date_creation']);
    $date_inscription = date_format($date, 'd/m/Y');


    switch($req_user['role']) {
        case 0:
            $role = 'Utilisateur';
        break;
        case 1:
            $role = "Administrateur";
        break;
        case 2:
            $role = "SuperAdmin";
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('../_menu/head.php') ?>
    <title>Mon profil</title>
</head>

<body>
    <?php require_once('../_menu/menu.php');?>

    <form class="formBoxAccount">

        <div class="d-grid gap-2">
            <h2 class="formTitle">Compte de <?= $pseudo ?></h2>
        </div>

        <div class="row g-3">
            <div class="col-sm">
                <div class="form-text">Pseudo</div>
                <input class="form-control" type="test" value="<?= $pseudo ?>" readonly>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-sm">
                <div class="form-text">Mail</div>
                <input class="form-control" value="<?= $mail ?>" readonly>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-sm">
                <div class="form-text">Mot de passe</div>
                <input class="form-control" value="********" readonly>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-sm">
                <div class="form-text">Date d'inscription</div>
                <input class="form-control" value="<?= $date_inscription ?>" readonly>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-sm">
                <div class="form-text">Role</div>
                <input class="form-control" value="<?= $role; ?>" readonly>
            </div>
        </div>

    </form>

    <?php require_once('../_menu/footer.php') ?>
</body>

</html>
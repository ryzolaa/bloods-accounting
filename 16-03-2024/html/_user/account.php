<?php

    require_once('../include.php');

    if(!isset($_SESSION['id'])) {
        header('Location: /');
        exit;
    }
    
    $req = $conn->prepare("SELECT *
    FROM user
    WHERE id = ?");

    $req->execute([$_SESSION['id']]);

    $req_user = $req->fetch();

    $pseudo = $req_user['pseudo'];

    $mail = $req_user['mail'];

    $pass = "********";

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
            $role = "Super-Admin";
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <?php include_once('../_menu/head.php') ?>
    <title>Mon Compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php require_once('../_menu/menu.php');?>

    <form class="formBoxAccount">

        <div class="d-grid gap-2">
            <h2 class="formTitle">Mon compte</h2>
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
                <input class="form-control" value="<?= $pass ?>" readonly>
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

        <div class="d-grid gap-2">
            <a class="btn btn-primary" href="_user/accountEdit.php">Modifier mes informations</a>
        </div>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
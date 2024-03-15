<?php
require_once('include.php');

if (!empty($_POST)) {
    extract($_POST);

    if (isset($_POST['register'])) {
        [$err_pseudo, $err_mail, $err_pass] = $_Register->verify_register($pseudo, $mail, $pass, $passConf);
    }
}   
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('_menu/head.php') ?>
    <title>Register</title>
</head>

<body>
    <?php require_once('_menu/menu.php'); ?>
    <form method="post" class="formBox">

        <?php if(isset($err_pseudo)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $err_pseudo ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>

        <?php if(isset($err_mail)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $err_mail ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>

        <?php if(isset($err_pass)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $err_pass ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>

        <div class="row g-3">
            <h2 class="formTitle">Créer un nouvel utilisateur</h2>
        </div>

        <div class="row g-3">
            <div class="col-sm">
                <div class="form-text">Pseudo</div>
                <input class="form-control" type="text" name="pseudo"
                    value="<?php if (isset($pseudo)) { echo $pseudo; } ?>" required>
            </div>
        </div>

        <div class="row g-3">

            <div class="col-sm">
                <div class="form-text">Email</div>
                <input class="form-control" type="email" name="mail" value="<?php if (isset($mail)) { echo $mail; } ?>"
                    required>
            </div>

        </div>

        <div class="row g-3">

            <div class="col-sm">
                <div class="form-text">Mot de passe</div>
                <input class="form-control" type="password" name="pass"
                    value="<?php if (isset($pass)) { echo $pass; } ?>" required>
            </div>

            <div class="col-sm">
                <div class="form-text">Confirmation du mot de passe</div>
                <input class="form-control" type="password" name="passConf"
                    value="<?php if (isset($passConf)) { echo $passConf; } ?>" required>
            </div>

        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit" name="register">CONFIRMER</button>
        </div>

    </form>
    <?php require_once('_menu/footer.php') ?>
</body>

</html>
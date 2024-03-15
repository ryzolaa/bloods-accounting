<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('include.php');

if(isset($_SESSION['id'])) {
    header('Location: /accounting.php');
    exit;
}

if (!empty($_POST)) {
    extract($_POST);

    if (isset($_POST['login'])) {
        [$err_mail] = $_Login->verify_login($mail, $pass);
    }
}   
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('_menu/head.php'); ?>
    <title>Login</title>

</head>

<body>
    <a href="/"></a>
    <form method="post" class="formBox">

        <?php if(isset($err_mail)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $err_mail ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>

        <div class="row g-3">
            <h2 class="formTitle">Connexion</h2>
        </div>

        <div class="row g-3">

            <div class="col-sm">
                <div class="form-text">Adresse Mail</div>
                <input class="form-control" type="email" name="mail" value="<?php if (isset($mail)) { echo $mail; } ?>"
                    placeholder="email@example.com">
            </div>

            <div class="col-sm">
                <div class="form-text">Mot de passe</div>
                <input class="form-control" type="password" name="pass"
                    value="<?php if (isset($pass)) { echo $pass; } ?>" placeholder="Password">
            </div>

        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit" name="login">Connexion</button>
        </div>



    </form>
    <?php require_once('_menu/footer.php'); ?>
</body>

</html>
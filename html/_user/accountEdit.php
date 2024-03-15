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

    if (!empty($_POST)) {
        extract($_POST);
    
        $valid = true;

        if (isset($_POST['formMail'])) {

            $mail = (String) trim($mail);

            if($mail == $_SESSION['mail']) {
                $valid = false; 
                $err_mail = "Le mail doit être différent du mail actuel !";

            } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
                $valid = false;
                $err_mail = 'Format du mail invalide!';

            } else {
                $req = $conn->prepare("SELECT id
                FROM user
                WHERE mail = ?");

                $req->execute([$mail]);

                $req = $req->fetch();

                if(isset($req['id'])) {
                    $valid = false;
                    $err_mail = "Ce mail est déjà associé à un compte !";
                }
            }

            if($valid) {

                $req = $conn->prepare("UPDATE user SET mail = ? WHERE id = ?");
                $req->execute([$mail, $_SESSION['id']]);
                $_SESSION['mail'] = $mail;
                $success = "Mail modifié avec succès !";

            }

        } elseif (isset($_POST['formPass'])) {
            $oldPass = (String) trim($oldPass);
            $newPass = (String) trim($newPass);
            $confNewPass = (String) trim($confNewPass);

            if ($oldPass) {
                $req = $conn->prepare("SELECT pass
                FROM user
                WHERE id = ?");

                $req->execute([$_SESSION['id']]);

                $req = $req->fetch();

                if (isset($req['pass'])) {

                    if(!password_verify($oldPass, $req['pass'])) {
                        $valid = false;
                        $err_pass = 'Mot de passe incorecte !';
                    }

                } else {
                    $valid = false;
                    $err_pass = 'Mot de passe incorecte !';
                }
            }

            if ($valid) {
                if($newPass <> $confNewPass) {
                    $valid = false;
                    $err_pass = 'Le mot de passe ne correspond pas !';

                } elseif ($oldPass == $newPass) {
                    $valid = false;
                    $err_pass = "Merci de choisir un mot de passe différent de l'actuel !";
                }
            }

            if($valid) {

                $crypt_pass = password_hash($newPass, PASSWORD_DEFAULT);

                $req = $conn->prepare("UPDATE user SET pass = ? WHERE id = ?");
                $req->execute([$crypt_pass, $_SESSION['id']]);

                $success = "Mot de pass modifié avec succès !";
            }
        }
    }  

    if(!isset($mail)) {
        $mail = $req_user['mail'];
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Modifier mes informations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php require_once('../_menu/menu.php');?>
    <div class='formBox'>

        <?php if(isset($success)) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $success ?>
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
            <h1 class="formTitle">Modifier mes informations</h1>
        </div>


        <form class="row g-3" method="post">
            <h4 class="contentEditAccount">Modifier votre adresse mail</h4>
            <div class="col-auto">
                <input class="form-control-plaintext" value="<?= $mail ?>" style="margin-right: 15px" readonly>
            </div>
            <div class="col-auto">
                <input type="mail" name="mail" value="" class="form-control" required>
            </div>
            <div class="col-auto">
                <button type="submit" name="formMail" class="btn btn-primary mb-3">Modifier</button>
            </div>
        </form>

        <form method="post" class="formEditPass">

            <div class="row g-3">
                <h4 class="contentEditAccount">Modifier votre mot de passe</h4>
            </div>

            <div class="row g-3">
                <div class="col-sm">
                    <input type="password" name="oldPass" class="form-control" value=""
                        placeholder="Mot de passe actuel" required>
                </div>
            </div>

            <div class="row g-3">

                <div class="col-sm">
                    <input type="password" name="newPass" class="form-control" value=""
                        placeholder="Nouveau mot de passe" required>
                </div>

                <div class="col-sm">
                    <input type="password" name="confNewPass" class="form-control" value=""
                        placeholder="Confimation du mot de passe" required>
                </div>

            </div>

            <div class="d-grid gap-2">
                <button type="submit" name="formPass" class="btn btn-primary mb-3">Modifier</button>
            </div>


        </form>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
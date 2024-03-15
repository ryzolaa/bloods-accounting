<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once('../include.php');

    if(!isset($_SESSION['id'])) {
        header('Location: /');
        exit;
    }

    $req = $conn->prepare("SELECT u.*, ar.libelle
    FROM user u
    LEFT JOIN admin_role ar ON ar.role = u.role
    WHERE u.id <> ?");

    $req->execute([$_SESSION['id']]);

    $req_list_users = $req->fetchAll();


    $req = $conn->prepare("SELECT *
    FROM admin_role");

    $req->execute();

    $req_list_roles = $req->fetchAll();

    $tab_list_roles = [];
    
    foreach($req_list_roles as $r) {
        array_push($tab_list_roles, [$r['role'], $r['libelle']]);
    }

    if(!empty($_POST)) {
        extract($_POST);

        $valid = true;

        if(isset($_POST['new_role'])) {
            $user_id = (int) $user_id;
            $role = (int) $role;

            $req = $conn->prepare("SELECT *
            FROM user
            WHERE id = ?");
        
            $req->execute([$user_id]);
            $verif_user = $req->fetch();
            
            if(!$verif_user) {
                $valid = false;
                $err_role = "Cet utilisateur n'existe pas !";

            } else {

                $req = $conn->prepare("SELECT *
                FROM admin_role
                WHERE role = ?");
            
                $req->execute([$role]);
            
                $verif_role = $req->fetch();
    
                if(!$verif_role) {
                    $valid = false;
                    $err_role = "Ce role n'existe pas !";
                }
            }


            if($valid) {
                $req = $conn->prepare("UPDATE user SET role = ? WHERE id = ?");

                $req->execute([$verif_role['role'], $user_id]);

                header('Location: role.php');
                exit;
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('../_menu/head.php') ?>
    <title>Utilisateurs</title>
</head>

<body>
    <?php require_once('../_menu/menu.php');?>
    <div class="formBox">

        <div class="row g-3">
            <h2 class="formTitle">Modifier les rôles</h2>
        </div>

        <?php foreach($req_list_users as $r) { ?>

        <form method="post" class="userRoleBox">

            <div>
                <?= $r['pseudo'] ?>
            </div>

            <select name="role" class="form-select form-select-sm">
                <option value="<?= $r['role'] ?>" hidden><?= $r['libelle'] ?></option>
                <?php foreach($tab_list_roles as $tr) {?>
                <option value="<?= $tr['0'] ?>"><?= $tr['1'] ?></option>
                <?php } ?>
            </select>

            <input type="hidden" name="user_id" value=" <?= $r['id'] ?>">
            <button type="submit" name="new_role" class="btn btn-primary">Modifier</button>
        </form>
        <?php } ?>
    </div>

    <?php require_once('../_menu/footer.php') ?>
</body>

</html>
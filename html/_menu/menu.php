<?php
    if (isset($_SESSION["id"])) {
        $req = $conn->prepare("SELECT *
        FROM user
        WHERE id = ?");
        
        $req->execute([$_SESSION['id']]);
        $req_user = $req->fetch();
        $coins = $req_user['coins'];
    }
?>

<base href='/'>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="accounting.php">Comptabilité</a>
                </li>

                <?php if(!isset($_SESSION['id'])) { ?>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">Bonjour</a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="login.php">Connexion</a></li>
                            <li><a class="dropdown-item" href="register.php">Inscription</a></li>
                        </ul>

                    </div>
                </li>
                <?php } else { ?>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">Bonjour, <?= $_SESSION['pseudo']; ?></a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="_user/account.php">Mon compte</a></li>
                            <li><a class="dropdown-item" href="disconnect.php">Déconnexion</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item">Vente: <?=$coins?></a></li>
                            <?php if($_SESSION['role'] == 2) {?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="_admin/dashboardAdmin.php">Administration</a></li>
                            <?php } ?>
                        </ul>

                    </div>
                </li>
                <?php } ?>
        </div>
    </div>
    </div>
</nav>
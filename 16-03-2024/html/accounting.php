<?php 
    require_once('include.php');

    $drugs = "SELECT * FROM drugs";
    $drugsreq = $conn->query($drugs); 


    $weapons = "SELECT * FROM weapon";
    $weaponsreq = $conn->query($weapons); 

    $current_total_query = "SELECT * FROM accounting ORDER BY id DESC LIMIT 1";
    $current_total_req = $conn->query($current_total_query); 
    $current_total_stmt = $current_total_req->fetch(PDO::FETCH_ASSOC);
    $current_total = $current_total_stmt['total'];

    $total_format = 0;
    $total_format = number_format($current_total, 0, ',', '.');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('_menu/head.php'); ?>
    <title>Comptabilité Bloods</title>
    <link rel="stylesheet" href="/css/accounting.css">
</head>

<body>
    <?php require_once('_menu/menu.php'); ?>
    <div class="accountingLine1">
        <div class="chest">
            <h1>Coffre drogues</h1>
            <div class="boxItemAccounting">
                <?php while ($row = $drugsreq->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="itemAccounting">
                    <h3><?= $row['item']?></h3>
                    <h5>stock: <?= $row['amount']?></h5>
                    <h5>prix: <?= $row['price']?></h5>

                    <form action="/_class/updt_drug_count.php" method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="item" value="<?= $row['item'] ?>">
                        <input type="hidden" name="price" value="<?= $row['price'] ?>">
                        <button type="submit" class="btn btn-danger" name="action" value="remove">Vendre</button>
                        <button type="submit" class="btn btn-success" name="action" value="add">Ajouter</button>
                        <div class="input-group">
                            <input type="number" id="quantity" name="quantity" class="form-control"
                                placeholder="Quantité" required>
                        </div>
                        <div class="input-group">
                            <input type="text" id="sell_price" name="sell_price" class="form-control"
                                placeholder="Only if special price">
                        </div>
                    </form>
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="chest">
            <h1>Trésorerie</h1>
            <div class="boxItemAccounting">
                <div class="moneyAccounting">
                    <h3 class="moneyTitle">Argent sale: <?= $total_format ?>$ </h3>
                    <form class="formMoney" action="/_class/updt_accounting.php" method="post">
                        <div class="formMoneyButton">
                            <button type="submit" class="btn btn-danger" name="action" value="remove"
                                style="width: calc(50% - 10px)">Retirer</button>
                            <button type="submit" class="btn btn-success" name="action" value="add"
                                style="width: calc(50% - 10px)">Ajouter</button>
                        </div>
                        <div class="formMoneyInput">
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="Montant"
                                required>
                            <input type="text" id="reason" name="reason" class="form-control" placeholder="Raison">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="chest">
        <h1>Coffre armes</h1>
        <div class="boxItemAccounting">
            <?php while ($row = $weaponsreq->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="itemAccounting">
                <h3><?= $row['weapon']?></h3>
                <h5>stock: <?= $row['amount']?></h5>
                <h5>prix: <?= $row['price']?></h5>

                <form action="/_class/updt_weapon_count.php" method="post">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="weapon" value="<?= $row['weapon'] ?>">
                    <input type="hidden" name="price" value="<?= $row['price'] ?>">
                    <button type="submit" class="btn btn-danger" name="action" value="remove">Vendre</button>
                    <button type="submit" class="btn btn-success" name="action" value="add">Ajouter</button>
                    <div class="input-group">
                        <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Quantité"
                            required>
                    </div>
                    <div class="input-group">
                        <input type="text" id="sell_price" name="sell_price" class="form-control"
                            placeholder="Only if special price">
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>

    <?php require_once('_menu/footer.php'); ?>
</body>

</html>
<?php
require_once('../include.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $new_price = $_POST['new_price'];

    // Mettre à jour le prix dans la base de données
    $sql = "UPDATE coins_prices SET prices = :new_price WHERE coins = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':new_price', $new_price, PDO::PARAM_STR);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: coinEdit.php?success=1");
        exit();
    } else {
        echo "Une erreur est survenue lors de la mise à jour du prix.";
        print_r($stmt->errorInfo());
    }
}

// récupération de la liste des packs-coins
$query = "SELECT prices, coins FROM coins_prices";
$result = $conn->query($query);
$products = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Modifier les prix de la boutique</title>
    <?php require_once('../_menu/head.php') ?>
</head>

<body>
    <?php require_once('../_menu/menu.php') ?>

    <form action="_admin/coinEdit.php" method="post" class="coinEdit">

        <h3>Modifier le prix des coins dans la boutique</h3>

        <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Prix mis à jour avec succès !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>

        <label for="product_id">Pack de coins:</label>

        <select name="product_id" class="form-select" required>
            <?php foreach ($products as $product) { ?>
            <option value="<?php echo $product['coins']; ?>" n><?php echo $product['coins']; ?></option>
            <?php } ?>
        </select><br>

        <label for="new_price">Nouveau prix:</label>
        <input type="text" name="new_price" required class="form-control"><br>

        <input type="submit" value="Mettre à jour" class="btn btn-primary">
    </form>
    <?php require_once('../_menu/footer.php') ?>
</body>

</html>
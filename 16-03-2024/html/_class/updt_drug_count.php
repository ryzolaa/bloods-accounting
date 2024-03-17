<?php
require_once('../include.php');

if (isset($_POST['action'], $_POST['id'], $_POST['item'], $_POST['price'], $_POST['sell_price'], $_POST['quantity'])) {
    $action = $_POST['action'];
    $drug_id = $_POST['id'];
    $drug_name = $_POST['item'];
    $drug_quantity = $_POST['quantity'];
    $user = $_SESSION['pseudo'];
    
    $drugs = "SELECT amount FROM drugs WHERE id = :id";
    $drugsreq = $conn->prepare($drugs);
    $drugsreq->bindParam(':id', $drug_id, PDO::PARAM_INT);
    $drugsreq->execute();
    $row = $drugsreq->fetch(PDO::FETCH_ASSOC);

    if (empty($_POST['sell_price'])) {
        $drug_price = $_POST['price'] * $drug_quantity;
    } else {
        $drug_price = $_POST['sell_price'] * $drug_quantity;
    }

    if ($action === 'add') {
        $query = "UPDATE drugs SET amount = amount + $drug_quantity WHERE id = :id";
        $log_type = "+$drug_quantity"; // Ajout
        $new_stock = $row['amount'] + $drug_quantity;
    } elseif ($action === 'remove') {
        $query = "UPDATE drugs SET amount = amount - $drug_quantity WHERE id = :id";
        $log_type = "-$drug_quantity"; // Retrait
        $new_stock = $row['amount'] - $drug_quantity;
        
        try {
            $total_query = "SELECT total FROM accounting ORDER BY id DESC LIMIT 1";
            $total_stmt = $conn->prepare($total_query);
            $total_stmt->execute();
            $total_result = $total_stmt->fetch(PDO::FETCH_ASSOC);
            $current_total = $total_result['total'];
            $new_total = $current_total + $drug_price;
            
            $accounting_query = "INSERT INTO accounting (total, op, reason, transac, user) VALUES (:total, :op, :reason, :transac, :user)";
            $accounting_stmt = $conn->prepare($accounting_query);
            $accounting_stmt->bindParam(':total', $new_total, PDO::PARAM_STR);
            $accounting_stmt->bindValue(':op', $log_type . " " . $drug_name, PDO::PARAM_STR);
            $accounting_stmt->bindValue(':reason', 'vente', PDO::PARAM_STR);
            $accounting_stmt->bindValue(':transac', "+" . $drug_price, PDO::PARAM_STR);
            $accounting_stmt->bindParam(':user', $user, PDO::PARAM_STR);
            $accounting_stmt->execute();
            
        } catch (PDOException $e) {
            echo 'Erreur SQL : ' . $e->getMessage();
        }
    }
    $if_drug_add = '0';
    
    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $drug_id, PDO::PARAM_INT);
        $stmt->execute();

        $date = date("Y-m-d H:i:s");
        $log_query = "INSERT INTO drugs_logs (stock, type, item, sell_price, user, date) VALUES (:stock, :type, :item, :sell_price, :user, :date)";
        $log_stmt = $conn->prepare($log_query);

        $log_stmt->bindParam(':stock', $new_stock, PDO::PARAM_STR);
        $log_stmt->bindParam(':type', $log_type, PDO::PARAM_STR);
        $log_stmt->bindParam(':item', $drug_name, PDO::PARAM_STR);
        if($action === 'add') {
            $log_stmt->bindParam(':sell_price', $if_drug_add, PDO::PARAM_STR);
        } else {
            $log_stmt->bindParam(':sell_price', $drug_price, PDO::PARAM_STR);
        }
        $log_stmt->bindParam(':user', $user, PDO::PARAM_STR);
        $log_stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $log_stmt->execute();

        header('Location: ../accounting.php');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur SQL : ' . $e->getMessage();
    }
}
?>
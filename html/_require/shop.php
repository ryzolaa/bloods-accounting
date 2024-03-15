<?php 
    $req = $conn->prepare("SELECT *
    FROM coins_prices");

    $req->execute();

    $row1 = $req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_ABS, 0);
    $coin1 = $row1["coins"];
    $price1 = $row1["prices"];

    $row2 = $req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_ABS, 1);
    $coin2 = $row2["coins"];
    $price2 = $row2["prices"];

    $row3 = $req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_ABS, 2);
    $coin3 = $row3["coins"];
    $price3 = $row3["prices"];

    $row4 = $req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_ABS, 3);
    $coin4 = $row4["coins"];
    $price4 = $row4["prices"];
?>
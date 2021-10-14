<?php
function checkifhoused($productname, $supplier)
{
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM " . TBL_PRODUCTS;
    $result = mysqli_query($db, $sql);
    while ($row = $result->fetch_assoc()) {
        if ($row['supplierid'] == $supplier and $row['name'] == $productname) {
            return true;
        }
    }
    return false;
}


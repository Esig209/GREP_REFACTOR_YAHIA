<?php 

include 'header.php'; 


function create_unique_id(){

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getCartItems($bdd, $user_id) {
    $select_cart = $bdd->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $select_cart->execute([$user_id]);
    return $select_cart->fetchAll(PDO::FETCH_ASSOC);
}

function getProductDetails($bdd, $product_id) {
    $select_products = $bdd->prepare("SELECT * FROM `products` WHERE id_prod = ?");
    $select_products->execute([$product_id]);
    return $select_products->fetch(PDO::FETCH_ASSOC);
}
?>




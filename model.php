<?php 

include 'connection.php';

function getCartItems($user_id) {
    $bdd = getConnexion();
    $select_cart = $bdd->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $select_cart->execute([$user_id]);
    return $select_cart->fetchAll(PDO::FETCH_ASSOC);
}

function getProductDetails($product_id) {
    $bdd = getConnexion();
    $select_products = $bdd->prepare("SELECT * FROM `products` WHERE id_prod = ?");
    $select_products->execute([$product_id]);
    return $select_products->fetch(PDO::FETCH_ASSOC);
}

function testDeleteConfirmation($expected, $actual) {
    if ($expected === $actual) {
        echo "Test de Confirmation de Suppression réussi\n";
    } else {
        echo "Test de Confirmation de Suppression échoué\n";
    }
}
?>



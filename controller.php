<?php

include_once('../../LoginOZ/cookieconnect.php');
include_once('model.php');
include_once 'model.php';


if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
}

if(isset($_POST['update_cart'])){

    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_UNSAFE_RAW);
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_UNSAFE_RAW);
 
    $update_qty = $bdd->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);
 
    $success_msg[] = 'Panier mis à jour!';
}

if(isset($_POST['delete_item'])){

   $cart_id = $_POST['cart_id'];
   $cart_id = filter_var($cart_id, FILTER_UNSAFE_RAW);
   
   $verify_delete_item = $bdd->prepare("SELECT * FROM `cart` WHERE id = ?");
   $verify_delete_item->execute([$cart_id]);

   if($verify_delete_item->rowCount() > 0){
      $delete_cart_id = $bdd->prepare("DELETE FROM `cart` WHERE id = ?");
      $delete_cart_id->execute([$cart_id]);
      $success_msg[] = 'Produit supprimé du panier!';
   }else{
      $warning_msg[] = 'Produit déjà supprimé du panier!';
   } 

}

if(isset($_POST['empty_cart'])){

   $verify_empty_cart = $bdd->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $verify_empty_cart->execute([$user_id]);

   if($verify_empty_cart->rowCount() > 0){
      $delete_cart_id = $bdd->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart_id->execute([$user_id]);
      $success_msg[] = 'Panier vidé!';
   }else{
      $warning_msg[] = 'Panier déja supprimé!';
   } 
}

function displayCart($bdd, $user_id) {
    $grand_total = 0;
    $cartItems = getCartItems($bdd, $user_id);

    if (!empty($cartItems)) {
        foreach ($cartItems as $cartItem) {
            $productDetails = getProductDetails($bdd, $cartItem['id_produit']);

            if ($productDetails) {
                $sub_total = $cartItem['qty'] * $cartItem['price'];
                $grand_total += $sub_total;

                include 'views/cart_item.php';
            } else {
                echo '<p class="empty">Produit inexistant !</p>';
            }
        }
    } else {
        echo '<p class="empty">Votre panier est vide</p>';
    }
}

?>


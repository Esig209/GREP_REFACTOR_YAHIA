<?php

$bdd = new PDO("mysql:host=hhva.myd.infomaniak.com;dbname=hhva_t24_8_v2", "hhva_t24_8_v2", "1kChruwd5");
$bdd->query("SET NAMES 'utf8'");

include_once('../../LoginOZ/cookieconnect.php');



function create_unique_id(){
   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $charactersLength = strlen($characters);
   $randomString = '';
   for ($i = 0; $i < 20; $i++) {
       $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
   }
   return $randomString;
}


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

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>PANIER</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

   <link rel="stylesheet" href="../css/stylePanier.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="products">

   <h1 class="heading">PANIER</h1>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_cart = $bdd->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){

         $select_products = $bdd->prepare("SELECT * FROM `products` WHERE id_prod = ?");
         $select_products->execute([$fetch_cart['id_produit']]);
         if($select_products->rowCount() > 0){
            $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
      
   ?>
   <form action="" method="POST" class="box">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id_produit']; ?>">
      <img src="<?= $fetch_product['image']; ?>" class="image" alt="">
      <h3 class="name"><?= $fetch_product['name']; ?></h3>
      <div class="flex">
         <p class="price"><i class=""></i> CHF <?= $fetch_cart['price']; ?></p>
         <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99" maxlength="2" class="qty">
         <button type="submit" name="update_cart" class="fas fa-edit">
         </button> 
      </div>
      <p class="sub-total">TOTAL : <span><i> CHF    </i> <?= $sub_total = ($fetch_cart['qty'] * $fetch_cart['price']); ?></span></p>
      <input type="submit" value="SUPPRIMER" name="delete_item" class="delete-btn" onclick="return confirm('delete this item?');">
   </form>
   <?php
      $grand_total += $sub_total;
      }else{
         echo '<p class="empty">Produit inexistant !</p>';
      }
      }
   }else{
      echo '<p class="empty">Votre panier est vide</p>';
   }
   ?>

   </div>

   <?php if($grand_total != 0){ ?>
      <div class="cart-total">
         <p>TOTAL  : <span><i>CHF   </i> <?= $grand_total; ?></span></p>
         <form action="" method="POST">
          <input type="submit" value="VIDER PANIER" name="empty_cart" class="delete-btn" onclick="return confirm('empty your cart?');">
         </form>
         <a href="../../LoginOZ/index.php" class="btn">SE CONNECTER</a>
      </div>
   <?php } ?>

</section>





<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="js/script.js"></script>

<?php include 'alerte.php'; ?>
<?php include 'footer.php'; ?>



</body>
</html>
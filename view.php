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
<?php include_once 'model.php';?>
<?php include_once 'controller.php';?>

<section class="products">

   <h1 class="heading">PANIER</h1>

   <div class="box-container">

   <?php
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

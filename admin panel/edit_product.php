<?php
    include '../components/connect.php';
    
    if(isset($_COOKIE['seller_id'])){
        $seller_id = $_COOKIE['seller_id'];

        $select_seller = $conn->prepare("SELECT * FROM sellers WHERE id = ?");
        $select_seller->execute([$seller_id]);
    } else {
        $seller_id='';
        header('location:login.php');
    }
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>página de registro de vendedores</title>
    <link rel="stylesheet" type="text/CSS" href="../CSS/admin_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        
        <section class="post-editor">
            <div class="heading">
                <h1>Editar producto</h1>
                <img src="../image/separator-img.png" alt="imagen de control">
            </div>
            <div class="box-container">
                <?php 
                    $product_id = $_GET['id'];
                    $select_product = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
                    $select_product->execute([$product_id, $seller_id]);
                    
                    if($select_product->rowCount() > 0){
                        while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                ?>
                
                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data" class="register">
                        <input type="hidden" name="old_image" value="<?= htmlspecialchars($fetch_product['image']); ?>">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_product['id']); ?>">
                        
                        <div class="input-field">
                            <p>Estado del producto <span>*</span></p>
                            <select name="status" class="box">
                                <option value="<?= htmlspecialchars($fetch_product['status']); ?>" selected><?= htmlspecialchars($fetch_product['status']); ?></option>
                                <option value="active">Activo</option>
                                <option value="inactive">desactivado</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <p>Nombre del producto <span>*</span></p>
                            <input type="text" name ="name" value="<?= $fetch_product['name']; ?> " class="box" >
                        </div>
                        <div class="input-field">
                            <p>Precio del producto <span>*</span></p>
                            <input type="number" name ="price" value="<?= $fetch_product['price']; ?> " class="box" >
                        </div>
                        <div class="input-field">
                            <p>Descripcion del producto <span>*</span></p>
                            <textarea name="decription" class="box"><?= $fetch_product['product_detail']; ?></textarea>
                        </div>
                        <div class="input-field">
                            <p>Stock del producto <span>*</span></p>
                            <input type="number" name ="stock" value="<?= $fetch_product['stock']; ?> " class="box" min="0" max="9999999" maxlength="10">
                        </div>
                        <div class="input-field">
                            <p>Imagen del producto <span>*</span></p>
                            <input type="file" name ="image" accept="image/*"  class="box" >
                            <?php
                                if($fetch_product['image'] != ''){?>
                                <img src="../Archivos_subidos/<?= $fetch_product['image']; ?>" class="image">
                                <div class="flex-btn">
                                    <input type="submit" name="delete_image" class="btn" value="delete image">
                                    <a href="view_products.php" class="btn" style=" width:49%; text-aling:center; height: 3rem; margin-top: .7rem; ">volver</a>
                                </div>
                            <?php } ?>
                            
                        </div>
                    </form> 
                </div>
                
                <?php        
                        }
                    } else {
                        echo '<div class="empty">
                            <p>Ningún producto añadido todavía!</p>
                        </div>';
                    }
                ?>
            </div>
        </section>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../JS/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
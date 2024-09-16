<?php
    include '../components/connect.php';

    // Verificar si la cookie 'seller_id' está presente
    if(isset($_COOKIE['seller_id'])){
        $seller_id = $_COOKIE['seller_id'];

        // Opcional: Verificar si el seller_id es válido en la base de datos
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
    <title>mostrar página de productos</title>
    <link rel="stylesheet" type="text/CSS" href="../CSS/admin_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>
<body>
    <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="show-post">
        <div class="heading">
            <h1>productos</h1>
            <img src="../image/separator-img.png" alt="imagen de control">
        </div>
        
        <div class="box-container">
            <?php 
                $select_productos = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
                $select_productos->execute([$seller_id]);
                if($select_productos->rowCount() > 0){
                    while($fetch_products = $select_productos->fetch(PDO::FETCH_ASSOC)){

            ?>
        
            <form action="" method="post" class="box">
                <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">

                <?php if($fetch_products['image'] != '') { ?>
                    <img src="../archivos_subidos/<?= $fetch_products['image']; ?>" class="image">
                <?php } ?>

                <div class="status" style="color: <?php if($fetch_products['status'] == 'active'){ echo 'limegreen'; }else{ echo 'coral'; } ?>">
                    <?= $fetch_products['status']; ?>
                </div>

                <div class="price">$<?= $fetch_products['price']; ?></div>

                <div class="content">
                    <div class="title"> <?= $fetch_products['name']; ?> </div>

                    <div class="flex-btn">
                        <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">editar</a>
                        <button type="submit" name="delete" class="btn" onclick="return confirm('eliminar este producto?');">borar</button>
                        <a href="read_product.php?pos_id=<?= $fetch_products['id']; ?>" class="btn">leer producto</a>
                    </div>
                </div>
            </form>


            <?php 
                    }
                }
                else{
                    echo '<div class="empty">
                                <p>No hay productos añadidos todavía! <br> <a href="add_products.php" class="btn" style="margin-top: 1.5rem;">agregar productos</a></p>
                            </div>';
                }
            
            ?>

        </div>

    </section>
    </div>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../JS/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
<?php
include '../components/connect.php';

if(isset($_COOKIE['seller_id'])){
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
}

if(isset($_GET['query'])){
    $search_query = $_GET['query'];
    $search_query = filter_var($search_query, FILTER_SANITIZE_STRING);

    $search_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ? AND (name LIKE ? OR product_detail LIKE ?)");
    $search_products->execute([$seller_id, "%$search_query%", "%$search_query%"]);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" type="text/CSS" href="../CSS/admin_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        
        <section class="show-post">
            <h1>Resultados para: <?= htmlspecialchars($search_query); ?></h1>
            <div class="box-container">
                <?php 
                if($search_products->rowCount() > 0){
                    while($fetch_products = $search_products->fetch(PDO::FETCH_ASSOC)){
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
                        <p><?= $fetch_products['product_detail']; ?></p>
                        <div class="flex-btn">
                            <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">editar</a>
                            <button type="submit" name="delete" class="btn" onclick="return confirm('eliminar este producto?');">borar</button>
                        </div>
                    </div>
                </form>
                <?php
                    }
                } else {
                    echo '<div class="empty">
                                <p>No se encontraron productos! <br> </p>
                            </div>';
                }
                ?>
            </div>
        </section>
    </div>
    
    <script src="../JS/admin_script.js"></script>
</body>
</html>

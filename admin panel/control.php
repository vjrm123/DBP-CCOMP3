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
    <title>página de registro de vendedores</title>
    <link rel="stylesheet" type="text/CSS" href="../CSS/admin_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>
<body>
    <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    
    <section class="control">
        <div class="heading">
            <h1>control</h1>
            <img src="../image/separator-img.png" alt="imagen de control">
        </div>

        <div class="box-container">

            <div class="box">
                <h3>Bienvenido</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="update.php" class="btn">actualisar perfil</a>
            </div>

            <div class="box">
                <?php
                    $select_message = $conn->prepare("SELECT * FROM message ");
                    $select_message->execute();
                    $number_of_msg = $select_message->rowCount();
                ?>
                <h3><?= $number_of_msg; ?></h3>
                <p>Mensaje no leido</p>
                <a href="admin_message.php" class="btn">ver mensage</a>
            </div>

            <div class="box">
                <?php
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");
                    $select_products->execute([$seller_id]);
                    $number_of_products = $select_products->rowCount();
                ?>
                <h3><?= $number_of_products; ?></h3>
                <p>productos agregados</p>
                <a href="add_products.php" class="btn">agregar producto</a>
            </div>

            <div class="box">
                <?php
                    $select_active_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?  AND status = ?");

                    $select_active_products->execute([$seller_id, 'active']);
                    $number_of_active_products = $select_active_products->rowCount();
                ?>
                <h3><?= $number_of_active_products; ?></h3>
                <p>productos disponibles</p>
                <a href="view_products.php" class="btn">ver producto</a>
            </div>

            <div class="box">
                <?php
                    $select_deactive_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?  AND status = ?");

                    $select_deactive_products->execute([$seller_id, 'deactive']);
                    $number_of_deactive_products = $select_deactive_products->rowCount();
                ?>
                <h3><?= $number_of_deactive_products; ?></h3>
                <p>productos en borrador</p>
                <a href="view_products.php" class="btn">productos en borrador</a>
            </div>

            <div class="box">
                <?php
                    $select_users = $conn->prepare("SELECT * FROM users ");
                    $select_users->execute();
                    $number_of_users = $select_users->rowCount();
                ?>
                <h3><?= $number_of_users; ?></h3>
                <p>cuenta de usuarios</p>
                <a href="users_accounts.php" class="btn">ver usuarios</a>
            </div>

            <div class="box">
                <?php
                    $select_sellers = $conn->prepare("SELECT * FROM sellers ");
                    $select_sellers->execute();
                    $number_of_sellers = $select_sellers->rowCount();
                ?>
                <h3><?= $number_of_sellers; ?></h3>
                <p>cuenta de vendedores</p>
                <a href="sellers_accounts.php" class="btn">ver vendedores</a>
            </div>

            <div class="box">
                <?php
                    $select_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ?");
                    $select_orders->execute([$seller_id]);
                    $number_of_orders = $select_orders->rowCount();
                ?>
                <h3><?= $number_of_orders; ?></h3>
                <p>total de pedidos</p>
                <a href="admin_order.php" class="btn">total de pedidos</a>
            </div>

            <div class="box">
                <?php
                    $select_confirm_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ? AND status = ?");
                    $select_confirm_orders->execute([$seller_id, 'in progress']);
                    $number_of_confirm_orders = $select_confirm_orders->rowCount();
                ?>
                <h3><?= $number_of_confirm_orders; ?></h3>
                <p>pedidos confirmados</p>
                <a href="admin_order.php" class="btn">confirmar pedidos</a>
            </div>

            <div class="box">
                <?php
                    $select_canceled_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ? AND status = ?");
                    $select_canceled_orders->execute([$seller_id, 'canceled']);
                    $number_of_canceled_orders = $select_canceled_orders->rowCount();
                ?>
                <h3><?= $number_of_canceled_orders; ?></h3>
                <p>total  de pedidos cancelados</p>

                <a href="admin_order.php" class="btn">pedidos cancelados</a>
            </div>

        </div>
    </section>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../JS/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
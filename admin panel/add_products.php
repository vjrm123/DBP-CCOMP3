<?php
    include '../components/connect.php';

    if(isset($_COOKIE['seller_id'])){
        $seller_id = $_COOKIE['seller_id'];

    } else {
        $seller_id='';
        header('location:login.php');
    }

    //agregar productos en la base de datos
    if(isset($_POST['publish'])){
        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);

        $descripcion = $_POST['description'];
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_STRING);

        $stock = $_POST['stock'];
        $stock = filter_var($stock, FILTER_SANITIZE_STRING);
        $status = 'active';

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = '../Archivos_subidos/'.$image;

        $select_image = $conn->prepare("SELECT * FROM products WHERE image = ? AND seller_id = ?");
        $select_image->execute([$image, $seller_id]);

        if(isset($image)) {
            if($select_image->rowCount() > 0) {
                $warning_msg[] = 'nombre de la imagen repetido';
            }
            elseif($image_size > 20000000){
                $warning_msg[] = 'imagen demasiado grande';
            }
            else{
                move_uploaded_file($image_tmp, $image_folder);
            }
        } else{
            $warning_msg[] = 'no se ha seleccionado imagen';
        }

        if($select_image->rowCount() > 0 AND $image != ''){
            $warning_msg[] = 'Por favor cambia el nombre de tu imagen';
        }
        else{
            $insert_product = $conn->prepare("INSERT INTO `products`(id, seller_id, name, price, image, stock, product_detail, status) VALUES(?,?,?,?,?,?,?,?)");
            $insert_product->execute([$id, $seller_id, $name, $price, $image, $stock, $descripcion, $status]);
            $warning_msg[] = 'producto agregado con exito';
        }
    }

    if(isset($_POST['draft'])){
        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);

        $descripcion = $_POST['description'];
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_STRING);

        $stock = $_POST['stock'];
        $stock = filter_var($stock, FILTER_SANITIZE_STRING);
        $status = 'deactive';

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = '../Archivos_subidos/'.$image;

        $select_image = $conn->prepare("SELECT * FROM products WHERE image = ? AND seller_id = ?");
        $select_image->execute([$image, $seller_id]);

        if(isset($image)) {
            if($select_image->rowCount() > 0) {
                $warning_msg[] = 'nombre de la imagen repetido';
            }
            elseif($image_size > 20000000){
                $warning_msg[] = 'imagen demasiado grande';
            }
            else{
                move_uploaded_file($image_tmp, $image_folder);
            }
        } else{
            $warning_msg[] = 'no se ha seleccionado imagen';
        }

        if($select_image->rowCount() > 0 AND $image != ''){
            $warning_msg[] = 'Por favor cambia el nombre de tu imagen';
        }
        else{
            $insert_product = $conn->prepare("INSERT INTO `products`(id, seller_id, name, price, image, stock, product_detail, status) VALUES(?,?,?,?,?,?,?,?)");
            $insert_product->execute([$id, $seller_id, $name, $price, $image, $stock, $descripcion, $status]);
            $warning_msg[] = 'El producto se guardo como borrador correctamente';
        }

    }
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página para agregar productos</title>
    <link rel="stylesheet" type="text/CSS" href="../CSS/admin_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>
<body>
    <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="post-editor">
        <div class="heading">
            <h1>agregar pproductos</h1>
            <img src="../image/separator-img.png" alt="imagen de control">
        </div>
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data" class="register">
                <div class="input-field">
                    <p>Nombre del producto</p>
                    <input type="text" name="name" maxlenth="100" placeholder="agrega el nombre del producto" required class="box">
                </div>

                <div class="input-field">
                    <p>precio del producto</p>
                    <input type="number" name="price" maxlenth="100" placeholder="agrega precio del producto" required class="box">
                </div>

                <div class="input-field">
                    <p>detalles del producto</p>
                    <textarea name="description" required maxlength="1000" placeholder="agrega detalles del producto" class="box"></textarea>
                </div>

                <div class="input-field">
                    <p>Stock del producto</p>
                    <input type="number" name="stock" maxlenth="10" min="0" max="999999999" placeholder="agrega stock del producto" required class="box">
                </div>

                <div class="input-field">
                    <p>imagen del producto</p>
                    <input type="file" name="image" accept="image/*" required class="box">
                </div>

                <div class="flex-btn">
                    <input type="submit" name="publish" value="agregar producto" class="btn">
                    <input type="submit" name="draft" value="guardar como borrador" class="btn">
                </div>
            </form>
        </div>
    </section>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../JS/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
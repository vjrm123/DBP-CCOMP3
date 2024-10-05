<?php
    include '../components/connect.php';

    if(isset($_POST['submit'])) {
        $id = unique_id();

        $name = $_POST['name'];
        $name = filter_var($name , FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); 

        $pass = sha1($_POST['pass']);

        $cpass = sha1($_POST['cpass']);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id() . '.' . $ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../Archivos_subidos/' . $rename;

        $select_seller = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
        $select_seller->execute([$email]);

        if($select_seller->rowCount() > 0){
            $warning_msg[] = '¡El correo electrónico ya existe!';
        } else {
            if($pass != $cpass){
                $warning_msg[] = '¡Las contraseñas no coinciden!';
            } else {
                // Insertar nuevo usuario
                $insert_seller = $conn->prepare("INSERT INTO sellers (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
                $insert_seller->execute([$id, $name, $email, $pass, $rename]); // Aquí debes guardar $pass
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'Nuevo vendedor registrado, por favor inicie sesión ahora';
            }
        }
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
    
<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data" class="register">
        <h3>Regístrate ahora</h3>
        <div class="flex">
            <div class="col">
                <div class="input-field">
                    <p>Nombre <span>*</span></p>
                    <input type="text" name="name" placeholder="Introduce tu nombre" maxlength="50" required class="box">
                </div>
                <div class="input-field">
                    <p>correo electrónico<span>*</span></p>
                    <input type="email" name="email" placeholder="Introduce tu correo electrónico" maxlength="50" required class="box" autocomplete="off">
                </div>
            </div>
            <div class="col">
                <div class="input-field">
                    <p>contraseña <span>*</span></p>
                    <input type="password" name="pass" placeholder="Ingrese su contraseña" maxlength="50" required class="box">
                </div>
                <div class="input-field">
                    <p>confirma contraseña <span>*</span></p>
                    <input type="password" name="cpass" placeholder="Confirme su contraseña" maxlength="50" required class="box">
                </div>
            </div>
        </div>
        <div class="input-field">
            <p>perfil<span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
        </div>
        <p class ="link" >¿Ya tienes una cuenta?<span>*</span><a href="login.php">  Iniciar sesión ahora</a></p>
        <input type="submit" name="submit" value="enviar" class = "btn">
        
    </form>
</div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../JS/script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
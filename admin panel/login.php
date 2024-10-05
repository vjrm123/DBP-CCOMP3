<?php 
    include '../components/connect.php';

    if(isset($_POST['submit'])) {

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); 

        $pass = sha1($_POST['pass']);

        $select_seller = $conn->prepare("SELECT * FROM sellers WHERE email = ? AND password = ?");
        $select_seller->execute([$email, $pass]);
        $row = $select_seller->fetch(PDO::FETCH_ASSOC);

        if($select_seller->rowCount() > 0){
            setcookie('seller_id', $row['id'], time() + 60*60*24*30, '/');
            header('location:control.php');
        } else{
            $warning_msg[] = 'Correo electrónico o contraseña incorrectos';
        }
    }
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" type="text/CSS" href="../CSS/admin_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    
<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data" class="login">
        <h3>Iniciar sesión ahora</h3>
        <div class="input-field">
            <p>correo electrónico<span>*</span></p>
            <input type="email" name="email" placeholder="Introduce tu correo electrónico" maxlength="50" required class="box" >
        </div>
        <div class="input-field">
                <p>contraseña<span>*</span></p>
                <input type="password" name="pass" placeholder="Ingrese su contraseña" maxlength="50" required class="box">
        </div>
        <p class ="link">¿No tienes una cuenta?<span>*</span><a href="register.php">  Regístrate ahora</a></p>
        <input type="submit" name="submit" value="Iniciar sesión" class="btn">
    </form>
</div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../JS/script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
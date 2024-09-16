<header>
    <div class="logo">
        <img src="../image/logo.png" width="50" alt="logo">
    </div>
    <div class="rigth">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>
    </div>
    <div class="profile-detail">
        <?php 
            $select_profile = $conn->prepare("SELECT * FROM sellers WHERE id= ?");
            $select_profile->execute([$seller_id]);
            if($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="profile">
                <img src="../Archivos_subidos/<?= $fetch_profile['image']; ?>" class="logo-img" width="150" alt="perfil">
                <p><?=$fetch_profile['name']; ?></p>
                <div class="flex-btn">
                    <a href="profile.php" class="btn">perfil</a>
                    <a href="../components/admin_cerrar_sesion.php" onclick="return confirm('Cerrar sesión en este sitio web');" class="btn">cerrar sesion</a>
                </div>
        </div>
        <?php }?>
    </div>
</header>

<div class="sidebar-container">
    <div class="sidebar">
        <?php 
            $select_profile = $conn->prepare("SELECT * FROM sellers WHERE id= ?");
            $select_profile->execute([$seller_id]);

            if($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="profile">
            <img src="../Archivos_subidos/<?= $fetch_profile['image']; ?>" class="logo-img" width="80" alt="perfil">      
        </div>
        <?php } ?>
        <h5>menu</h5>
        <div class="navbar">
            <ul>
                <li><a href="control.php"><i class="bx bxs-home-smile"></i> Control</a></li>
                <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i> Agregar productos</a></li>
                <li><a href="view_products.php"><i class="bx bxs-food-menu"></i> Ver productos</a></li>
                <li><a href="cuenta_usuario.php"><i class="bx bxs-user-detail"></i> Cuenta de usuario</a></li>
                <li><a href="../components/admin_cerrar_sesion.php" onclick="return confirm('logout from this website');"><i class="bx bx-log-out"></i> Cerrar sesión</a></li>
            </ul>
        </div>
        <h5>encuentranos en: </h5>
        <div class="social-links">
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram"></i>
            <i class="bx bxl-linkedin"></i>
            <i class="bx bxl-whatsapp"></i>
        </div>
    </div>
</div>


<header>
    <div class="logo">
        <img src="../image/logo.png" width="50" alt="logo">
    </div>
    <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" name="query" placeholder="Buscar..." required>
                <button type="submit"><i class="bx bx-search"></i></button>
            </form>
        </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        
        <div class="toggle-btn">
            <i class="bx bx-menu"></i>
        </div>
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
                    <a href="profile.php" class="btn"><strong>perfil</strong></a>
                    <a href="../components/admin_cerrar_sesion.php" onclick="return confirm('Cerrar sesión');" class="btn"><strong>cerrar sesión</strong></a>
                </div>
        </div>
        <?php } ?>
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
            <p><?=$fetch_profile['name']; ?></p>
        </div>
        <?php } else { ?>
        <div class="profile">
            <img src="../image/default-profile.png" class="logo-img" width="80" alt="perfil por defecto">
            <p><strong>No hay perfil cargado</strong></p>
            <a href="profile.php" class="btn">Completar perfil</a>
        </div>
        <?php } ?>
        

        <h5>Menú</h5>
        <div class="navbar">
            <ul>
                <li><a href="control.php"><i class="bx bxs-home-smile"></i> <strong>Panel de Control</strong></a></li>
                <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i> <strong>Agregar productos</strong></a></li>
                <li><a href="view_products.php"><i class="bx bxs-food-menu"></i> <strong>Ver productos</strong></a></li>
                <li><a href="cuenta_usuario.php"><i class="bx bxs-user-detail"></i> <strong>Cuenta de usuario</strong></a></li>
                <li><a href="../components/admin_cerrar_sesion.php" onclick="return confirm('Cerrar sesión');"><i class="bx bx-log-out"></i> <strong>Cerrar sesión</strong></a></li>
            </ul>
        </div>
        
        <h5>Nuestras redes sociales: </h5>
        <div class="social-links">
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram"></i>
            <i class="bx bxl-linkedin"></i>
            <i class="bx bxl-whatsapp"></i>
        </div>
    </div>
</div>
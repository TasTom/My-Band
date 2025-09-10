<?php 
session_start();
?>
    
    <header>
        <?php 
        if (!isset($_SESSION['logo']))
            $_SESSION['logo'] = generate_bandlogo();
        
        if (!isset($_SESSION['band_name']))
            $_SESSION['band_name'] = generate_bandname();
        ?>
        <img src="<?php echo $_SESSION['logo'] ?>" alt="Logo du groupe" class="logo">
        <!-- echo generate_bandlogo(); -->
        <h1><?php echo $_SESSION['band_name'] ?></h1>
        <!-- echo generate_bandname() -->
        <ul>
            <li><a href="band.php">HOME</a></li>
            <li><a href="bandD.php">BAND</a></li>
            <li>SETLIST</li>
            <li>CONTACT</li>
        </ul>
    </header>
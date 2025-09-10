

<!DOCTYPE html>
<html>
    <?php 
        require_once 'band_generators.php';
        require_once 'component/header.php';
        ?>
    <head>
        <title>TP1 PHP Par TAS Tom</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="band.css">
    </head>
    <php ?>

   
    <body class="band">
    <?php
        $background = generate_background();
        echo "<div class='background' style='background-image: url($background)'></div>";
    ?>

    </body>
    <?php require_once 'component/footer.php'; ?>
    
</html>


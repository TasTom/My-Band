

<!DOCTYPE html>
<html>
    <?php 
        include_once 'band_generators.php';
    ?>
    <head>
        <title>TP1 PHP Par TAS Tom</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="band.css">
    </head>
    <header>
        <img src="<?php echo generate_bandlogo();?>" alt="Logo du groupe" class="logo">
        <h1><?php echo generate_bandname();?></h1>
        <ul>
            <li><a href="band.php">HOME</a></li>
            <li><a href="bandD.php">BAND</a></li>
            <li>SETLIST</li>
            <li>CONTACT</li>
        </ul>
    </header>
    <body class="band">
    <?php
        $background = generate_background();
        echo "<div class='background' style='background-image: url($background)'></div>";
    ?>

    </body>
      <footer>
        <p class=footer>
            <?php
                date_default_timezone_set('Europe/Paris');

                $formatter = new IntlDateFormatter(
                    'fr_FR',
                    IntlDateFormatter::NONE,
                    IntlDateFormatter::NONE,
                    'Europe/Paris',
                    IntlDateFormatter::GREGORIAN,
                    "'Nous sommes le' EEEE d MMMM y', il est' HH:mm"
                );

                echo $formatter->format(new DateTime());
            ?>

        </p>
    </footer>
</html>


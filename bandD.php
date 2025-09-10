

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
    <body class="bandD">
    <article>
       <h2>Notre groupe</h2> 
        <p>Nous sommes un groupe de musique spécialisé dans le stoner rock, un genre musical qui mélange des éléments de rock psychédélique, de heavy metal et de blues. Notre musique est caractérisée par des riffs lourds, des rythmes hypnotiques et une ambiance souvent sombre et planante.</p>
        <p>Notre groupe est composé de quatre membres passionnés par la musique et déterminés à créer un son unique et puissant. Nous nous inspirons de groupes légendaires tels que Kyuss, Queens of the Stone Age, Sleep et Electric Wizard, tout en apportant notre propre touche personnelle à notre musique.</p>
        <p>Nous avons commencé notre aventure musicale il y a quelques années, en jouant dans des petits clubs et des festivals locaux. Au fil du temps, nous avons développé notre style et notre son, et nous avons eu la chance de partager la scène avec d'autres groupes talentueux du genre.</p>
        <p>Notre musique est souvent décrite comme une expérience immersive, où les auditeurs sont transportés dans un univers sonore riche et captivant. Nous aimons explorer des thèmes tels que la nature, la spiritualité, l'aliénation et la rébellion à travers nos paroles, tout en créant des atmosphères sonores qui évoquent des paysages désertiques, des voyages interstellaires et des états de conscience altérés.</p>
    </article>

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


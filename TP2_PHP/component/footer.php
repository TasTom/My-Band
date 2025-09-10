<?php ?>
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
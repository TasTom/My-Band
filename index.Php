
<!DOCTYPE html>
<html>
    <head>
        <title>TP1 PHP Par TAS Tom</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="index.css">
    </head>

    <body>
        <?php 
            // phpinfo();
            echo "Hello World!";
            

            
        ?>
        <h1>TP1 PHP Par TAS Tom</h1>
        <div class="server">
            <article>
                <h2>Exercice php</h2>
                <?php
                echo $_SERVER['REQUEST_METHOD'];
                echo "<br>";
                
                echo $_SERVER['SERVER_NAME'];
                echo $_SERVER['REQUEST_URI'];

                
                ?>
                <a href="band.php">Lien page web groupe de musique</a>
            </article>
        </div>

    </body>
  
</html>




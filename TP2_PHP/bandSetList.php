<!DOCTYPE html>
<html>
    <?php 
        require_once 'band_generators.php';
        require_once 'component/header.php';
    ?>
    <head>
        <title>TP2 PHP Par TAS Tom</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="bandSetList.css">
        <script src="rechercher.js"></script>
    </head>
    <body>
    <?php
        require_once 'connection.php';
        if (isset($_GET['order']) && $_GET['order'] == 'ASC') {
            $order = 'DESC';
        } else {
            $order = 'ASC';
        }
        
        if (isset($_GET['column']) && $_GET['column'] == 'title') 
            {
                $sql = 'SELECT * FROM setlist ORDER BY title '.$order;
            } 
        elseif (isset($_GET['column']) && $_GET['column'] == 'artist') 
            {
                $sql = 'SELECT * FROM setlist ORDER BY artist '.$order;
            } 
        elseif (isset($_GET['column']) && $_GET['column'] == 'style') 
            {
                $sql = 'SELECT * FROM setlist ORDER BY style '.$order;
            } 
        else {
                $sql = 'SELECT * FROM setlist';
            }

        if ($connect->query($sql) == false) {
            echo "La table setlist n'existe pas !";
        }
        else {
        ?>
        <h2 class="centre">Set List</h2>
        <table class="centre" id="jolie">
            <tr>
               <!-- <th> <input type="text" placeholder="Rechercher..." id="myInput" onkeyup="rechercher()"></th> -->
                <th colspan="3"> <input type="text" placeholder="Rechercher..." id="recherche" onkeyup="rechercher()"></th>
            </tr>
            <tr>
               
                <!-- <th><a href="bandSetList.php">Titre</a></th>
                <th><a href="bandSetList.php">Artiste</a></th>
                <th><a href="bandSetList.php">Style</a></th> -->
                <th><a href="bandSetList.php?order=<?php echo $order;?>&column=title">Titre</a></th>
                <th><a href="bandSetList.php?order=<?php echo $order;?>&column=artist">Artiste</a></th>
                <th><a href="bandSetList.php?order=<?php echo $order;?>&column=style">Style</a></th>
            
                </tr>
        <?php
            foreach ($connect->query($sql) as $row) {
                echo "<tr><td>".$row['title'] . "</td><td>\t".
                $row['artist'] . "</td><td>\t".
                $row['style'] ."</td></tr>\n";
            }
        }



    ?>
    </table>
    </body>
    <?php require_once 'component/footer.php'; ?>
</html>

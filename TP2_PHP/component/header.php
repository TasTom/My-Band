<?php 
session_start();
?>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="component/header.css">

    </head>
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
            <li><button onclick="document.getElementById('id01').style.display='block'">Login</button></li>
            <li><a href="bandD.php">BAND</a></li>
            <li><a href="bandSetList.php">SETLIST</a></li>
            <li>CONTACT</li>
        </ul>

        
        <div id="id01" class="modal">
            <span onclick="document.getElementById('id01').style.display='none'"
            class="close" title="Close Modal">&times;</span>

        <!-- Modal Content -->
            <form class="modal-content animate" action="/action_page.php">
                <div class="imgcontainer">
                <img src="img_avatar2.png" alt="Avatar" class="avatar">
                </div>

                <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <button type="submit">Login</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
                </div>

                <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
                </div>
            </form>
        </div>

    </header>


            <script>
            // Get the modal
            var modal = document.getElementById('id01');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
            }
        </script>
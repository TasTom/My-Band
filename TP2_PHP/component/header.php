<?php 
session_start();

// Déconnexion automatique stricte - chaque chargement de page déconnecte
// if (isset($_SESSION['logged_in']) && !isset($_POST['uname'])) {
//     // Exception : ne pas déconnecter si c'est une redirection après connexion
//     if (!isset($_SESSION['just_logged_in'])) {
//         session_unset();
//         session_destroy();
//         session_start();
//     } else {
//         // Supprimer le flag après le premier chargement
//         unset($_SESSION['just_logged_in']);
//     }
// }

// Gestion de la déconnexion via GET
if (isset($_GET['disconnect']) && $_GET['disconnect'] == 1) {
    session_unset();
    session_destroy();
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

// Gestion de la connexion via POST
if (isset($_POST['uname']) && isset($_POST['psw'])) {
    $username = $_POST['uname'];
    $password = $_POST['psw'];
    
    if ($username === 'superu' && $password === 'admin') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = time();
        $_SESSION['just_logged_in'] = true;
        
        if (isset($_POST['remember'])) {
            $_SESSION['remember_me'] = true;
        }
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['login_error'] = "Identifiants incorrects !";
    }
}

// Générer logo et nom de groupe si nécessaire
if (!isset($_SESSION['logo'])) {
    require_once 'band_generators.php';
    $_SESSION['logo'] = generate_bandlogo();
}

if (!isset($_SESSION['band_name'])) {
    require_once 'band_generators.php';
    $_SESSION['band_name'] = generate_bandname();
}
?>

<header>
    <img src="<?php echo $_SESSION['logo']; ?>" alt="Logo du groupe" class="logo">
    <h1><?php echo $_SESSION['band_name']; ?></h1>
    <ul>
        <li><a href="band.php">HOME</a></li>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <li><a href="?disconnect=1">DISCONNECT</a></li>
            <li>Bonjour, <?php echo $_SESSION['username']; ?>!</li>
        <?php else: ?>
            <li><button onclick="document.getElementById('id01').style.display='block'">CONNECT</button></li>
        <?php endif; ?>
        <li><a href="bandD.php">BAND</a></li>
        <li><a href="bandSetList.php">SETLIST</a></li>
        <li><a href="contact.php">CONTACT</a></li>

    </ul>

    <!-- Modal de connexion -->
    <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
    <div id="id01" class="modal">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>

        <form class="modal-content animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="imgcontainer">
                <img src="<?php echo $_SESSION['logo']; ?>" alt="Avatar" class="logo">
            </div>

            <div class="container">
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="error-message" style="color: red; margin-bottom: 10px;">
                        <?php echo $_SESSION['login_error']; ?>
                    </div>
                    <?php unset($_SESSION['login_error']); ?>
                <?php endif; ?>
                
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <div class="button-container">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <button type="submit" class="loginbtn">Login</button>
            </div>
        </form>
    </div>
    <?php endif; ?>
</header>

<script>
    var modal = document.getElementById('id01');
    if (modal) {
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
</script>

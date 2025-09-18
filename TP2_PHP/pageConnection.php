
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="submit" value="Se connecter">
</form>

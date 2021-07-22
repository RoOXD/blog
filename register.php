<?php

if (isset($_POST['submit'])) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=blog user=postgres");

    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = pg_query_params($dbconn, 'INSERT INTO users (username, password) VALUES ($1,$2)', array($username,$password));
    if ($query) {
        echo  "Inregistrare efectuata cu succes";
    } else {
        echo "Nume de utilizator luat!";
    }
}
?>
<html>
<body>
<p>Formular inregistrare.Introduceti datele.</p>
<form action="register.php" method="post">
Nume utilizator: <input type="text" name="username" required><br>
Parola: <input type="password" name="password" minlength="6" required><br>
<input type="submit" name="submit" value="Inregistrare">
</form>

</body>
</html>
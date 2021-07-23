<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</html>
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

<div class="container">
<div class="blog-header">
<h1 class="blog-title">Formular inregistrare.Introduceti datele.</h1>
</div>
</div>

<form action="register.php" method="post">
<div class="form-group">
<label for="username">Nume utilizator</label>
<input type="text" name="username" required class="form-control"><br>
<label for="username">Parola</label>
<input type="password" name="password" minlength="6" required class="form-control"><br>
<input type="submit" name="submit" value="Inregistrare" class="btn btn-primary">
</form>

</body>
</html>
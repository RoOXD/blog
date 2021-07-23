<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</html>
<?php
require 'auth.php';

if (isset($_COOKIE["UserCookie"])&&!empty($_COOKIE["UserCookie"])) {
    header('Location: http://127.0.0.1:9000/index.php');
} else {
    ?>
<html>
<body>


<body>
<div class="container">
<div class="blog-header">
<h1 class="blog-title">Pagina Login</h1>
</div>
</div>

<form action="login.php" method="post">
<div class="form-group">
<label for="username">Numele utilizatorului</label>
<input type="text" name="username" required class="form-control"><br>

<label for="password">Parola</label>
<input type="password" name="password" minlength="6" required class="form-control"><br>
<input type="submit" name="submit" value="Login" class="btn btn-primary">
</div>
</form>

</body>
</html>
<?php
if (isset($_POST['submit'])) {
        $dbconn = pg_connect("host=localhost port=5432 dbname=blog user=postgres");

        $username = $_POST['username'];
    
        $password = $_POST['password'];

        $query = pg_query_params($dbconn, 'SELECT id, password FROM users WHERE username=$1', array($username));
    
        $arr = pg_fetch_array($query, 0, PGSQL_NUM);
        if (password_verify($password, $arr[1])) {
            $secret=encodeUserID($arr[0]);
            setcookie("UserCookie", $secret);
            header('Location: http://127.0.0.1:9000/index.php?pageno=1');
        } else {
            echo 'Parola incorecta.'; ?>
<html>
	        <p>Puteti incerca din nou sau va puteti inregistra <a href="http://127.0.0.1:9000/register.php">aici</a></p>
</html>
<?php
        }
    }
}
?>
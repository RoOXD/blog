<?php
require 'auth.php';

if (isset($_COOKIE["UserCookie"])&&!empty($_COOKIE["UserCookie"])) {
    header('Location: http://127.0.0.1:9000/index.php');
} else {
    ?>
<html>
<body>
<p>Pagina Login</p>
<form action="login.php" method="post">
Numele utilizatorului: <input type="text" name="username" required><br>
Parola: <input type="password" name="password" minlength="6" required><br>
<input type="submit" name="submit" value="Login">
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
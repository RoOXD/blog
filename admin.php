<?php
require 'auth.php';
$value=$_COOKIE["UserCookie"];

if (isset($_POST['submit'])&&decodeUserID($value)) {
    $parts = explode(".", $value);
    $id = $parts[0];

    $dbconn = pg_connect("host=localhost port=5432 dbname=blog user=postgres");
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
    $body = htmlspecialchars($_POST['body'], ENT_QUOTES);

    $query = pg_query_params($dbconn, 'INSERT INTO posts(author_id, title, body) VALUES ($1,$2,$3);', array($id,$title,$body));
    if ($query) {
        header('Location: http://127.0.0.1:9000/index.php');
    } else {
        echo "Nume de utilizator luat!";
    }
}
?>
<html>
<body>
<p>Creati o postare.</p>
<form action="admin.php" method="post">
Titlu: <input type="text" name="title" required><br>
Continut: <input type="text" name="body" required><br>
<input type="submit" name="submit" value="Posteaza">
</form>

</body>
</html>
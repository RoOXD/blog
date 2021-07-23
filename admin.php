<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</html>
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
<div class="container">
<div class="blog-header">
<h1 class="blog-title">Creati o postare</h1>
</div>
</div>

<form action="admin.php" method="post">
<div class="form-group">
<label for="title">Titlu</label>
<input type="text" name="title" required class="form-control"><br>

<label for="title">Continut</label>
<textarea name="body" required class="form-control" rows="3"></textarea><br>

<input type="submit" name="submit" value="Posteaza" class="btn btn-primary">
</div>
</form>
</body>
</html>
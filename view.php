<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</html>
<?php

if (isset($_GET['id'])) {
    $postID = $_GET['id'];
    $dbconn = pg_connect("host=localhost port=5432 dbname=blog user=postgres");
    $result = pg_query_params($dbconn, 'SELECT title,body FROM posts WHERE id=$1', array($postID));

    echo '<table border="3" style="width: 100%;">';
    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
        echo "\t<tr>\n";
        foreach ($line as $col_value) {
            echo "\t\t<td>$col_value</td>\n";
        }
        echo "\t</tr>\n";
    }
} else {
    header('Location: http://127.0.0.1:9000/index.php?pageno=1');
}

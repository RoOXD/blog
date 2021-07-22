<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</html>
<?php
    require 'auth.php';

    $value=$_COOKIE["UserCookie"];

    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }

    $no_of_records_per_page = 10;
    $offset = ($pageno-1) * $no_of_records_per_page;
    
    $dbconn = pg_connect("host=localhost port=5432 dbname=blog user=postgres");

    $total_pages_sql = pg_query($dbconn, "SELECT COUNT (*) FROM posts");
    $total_rows = pg_fetch_array($total_pages_sql)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);

    $result = pg_query_params($dbconn, 'SELECT id,title,body,created_at FROM posts ORDER BY created_at DESC LIMIT $1 OFFSET $2', array($no_of_records_per_page,$offset));
    echo '<table border="3">';
    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
        echo "\t<tr>\n";
        $k=1;
        foreach ($line as $col_value) {
            if ($k==1) {
                echo "\t\t<td><a href='view.php?id=$col_value'>$col_value</a></td>\n";
                $k=0;
            } else {
                echo "\t\t<td>$col_value</td>\n";
            }
        }
        echo "\t</tr>\n";
    }
    echo "</table>\n";
    if (decodeUserID($value)) {
        ?>
<html>	
	<form action="logout.php">
    	<input type="submit" value="Logout" />
	</form>
	<form action="admin.php">
    	<input type="submit" value="Posteaza" />
	</form>
</html>
<?php
    } else {
        ?>
<html>
	<form action="login.php">
    	<input type="submit" value="Login" />
	</form>
</html>
<?php
        setcookie("UserCookie", null, -1, '/');
    }
?>
<html>

	<ul class="pagination">
    <li><a href="?pageno=1">First</a></li>
    <li class="<?php if ($pageno <= 1) {
    echo 'disabled';
} ?>">
        <a href="<?php if ($pageno <= 1) {
    echo '#';
} else {
    echo "?pageno=".($pageno - 1);
} ?>">Prev</a>
    </li>
    <li class="<?php if ($pageno >= $total_pages) {
    echo 'disabled';
} ?>">
        <a href="<?php if ($pageno >= $total_pages) {
    echo '#';
} else {
    echo "?pageno=".($pageno + 1);
} ?>">Next</a>
    </li>
    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
	</ul>

</html>
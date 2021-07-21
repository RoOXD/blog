<?php
require 'auth.php';

$value=$_COOKIE["UserCookie"];

if (decodeUserID($value)){

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

	$result = pg_query($dbconn, "SELECT title,body,created_at FROM posts ORDER BY created_at DESC LIMIT $no_of_records_per_page OFFSET $offset");
		echo '<table border="3" style="width: 100%;">';
		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    		echo "\t<tr>\n";
    		foreach ($line as $col_value) {
        	echo "\t\t<td>$col_value</td>\n";
    		}
		    echo "\t</tr>\n";
		}
		echo "</table>\n";
?>
<html>	
	<form action="logout.php">
    	<input type="submit" value="Logout" />
	</form>
	<form action="admin.php">
    	<input type="submit" value="Posteaza" />
	</form>

	<ul class="pagination">
    <li><a href="?pageno=1">First</a></li>
    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
    </li>
    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
    </li>
    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
	</ul>

</html>
<?php
}else {
	echo "Date eronate";
	setcookie("UserCookie", null, -1, '/');
}
?>
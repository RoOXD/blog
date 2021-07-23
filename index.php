<html>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <style>
        /* stylelint-disable selector-list-comma-newline-after, property-no-vendor-prefix */

        /*
        * Globals
        */

        body {
        font-family: Georgia, "Times New Roman", Times, serif;
        color: #555;
        }

        h1, .h1,
        h2, .h2,
        h3, .h3,
        h4, .h4,
        h5, .h5,
        h6, .h6 {
        margin-top: 0;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-weight: 400;
        color: #333;
        }


        /*
        * Override Bootstrap's default container.
        */

        @media (min-width: 1200px) {
        .container {
            width: 970px;
        }
        }


        /*
        * Masthead for nav
        */

        .blog-masthead {
        background-color: #428bca;
        -webkit-box-shadow: inset 0 -2px 5px rgba(0, 0, 0, .1);
        box-shadow: inset 0 -2px 5px rgba(0, 0, 0, .1);
        }

        /* Nav links */
        .blog-nav-item {
        position: relative;
        display: inline-block;
        padding: 10px;
        font-weight: 500;
        color: #cdddeb;
        }
        .blog-nav-item:hover,
        .blog-nav-item:focus {
        color: #fff;
        text-decoration: none;
        }

        /* Active state gets a caret at the bottom */
        .blog-nav .active {
        color: #fff;
        }
        .blog-nav .active:after {
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 0;
        margin-left: -5px;
        vertical-align: middle;
        content: " ";
        border-right: 5px solid transparent;
        border-bottom: 5px solid;
        border-left: 5px solid transparent;
        }


        /*
        * Blog name and description
        */

        .blog-header {
        padding-top: 20px;
        padding-bottom: 20px;
        }
        .blog-title {
        margin-top: 30px;
        margin-bottom: 0;
        font-size: 60px;
        font-weight: 400;
        }
        .blog-description {
        font-size: 20px;
        color: #999;
        }


        /*
        * Main column and sidebar layout
        */

        .blog-main {
        font-size: 18px;
        line-height: 1.5;
        }

        /* Sidebar modules for boxing content */
        .sidebar-module {
        padding: 15px;
        margin: 0 -15px 15px;
        }
        .sidebar-module-inset {
        padding: 15px;
        background-color: #f5f5f5;
        border-radius: 4px;
        }
        .sidebar-module-inset p:last-child,
        .sidebar-module-inset ul:last-child,
        .sidebar-module-inset ol:last-child {
        margin-bottom: 0;
        }


        /* Pagination */
        .pager {
        margin-bottom: 60px;
        text-align: left;
        }
        .pager > li > a {
        width: 140px;
        padding: 10px 20px;
        text-align: center;
        border-radius: 30px;
        }


        /*
        * Blog posts
        */

        .blog-post {
        margin-bottom: 60px;
        margin-left: 20px;
        }
        .blog-post-title {
        margin-bottom: 5px;
        font-size: 40px;
        margin-left: 30px;
        }
        .blog-post-meta {
        margin-bottom: 20px;
        color: #999;
        }


        /*
        * Footer
        */

        .blog-footer {
        padding: 40px 0;
        color: #999;
        text-align: center;
        background-color: #f9f9f9;
        border-top: 1px solid #e5e5e5;
        }
        .blog-footer p:last-child {
        margin-bottom: 0;
        }

    </style>
</html>
<?php

    require 'auth.php';
    $value=$_COOKIE["UserCookie"];

    if (decodeUserID($value)) {
        ?>
<html>
<div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="admin.php">Posteaza</a>
          <a class="blog-nav-item" href="logout.php">Logout</a>
      </div>
</div>
</html>
<?php
    } else {
        ?>
<html>
    <div class="blog-masthead">
        <div class="container">
            <nav class="blog-nav">
            <a class="blog-nav-item active" href="login.php">Login</a>
            <a class="blog-nav-item" href="register.php">Register</a>
        </div>
    </div>
</html>
<?php
    setcookie("UserCookie", null, -1, '/');
    }

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
    echo '<body class="body">';
    echo '<div class="blog-post">';
    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
        $k=1;
        $id=0;
        foreach ($line as $col_value) {
            if ($k==1) {
                $id=$col_value;
                $k++;
            } elseif ($k==2) {
                echo "<h2 class='blog-post-title'><a href='view.php?id=$id'>$col_value</a></h2>";
                $k++;
            } elseif ($k==3) {
                echo "<p>$col_value</p>";
                $k++;
            } else {
                echo "<p class='blog-post-meta'>$col_value</p>";
            }
        }
    }
    echo '</div>';
    echo '</body>';
?>

<html>
<nav>
	<ul class="pagination justify-content-center">
    <li><a href="?pageno=1"><<</a></li>
    <li class="<?php if ($pageno <= 1) {
    echo 'disabled';
} ?>">
        <a href="<?php if ($pageno <= 1) {
    echo '#';
} else {
    echo "?pageno=".($pageno - 1);
} ?>"><</a>
    </li>
    <li class="<?php if ($pageno >= $total_pages) {
    echo 'disabled';
} ?>">
        <a href="<?php if ($pageno >= $total_pages) {
    echo '#';
} else {
    echo "?pageno=".($pageno + 1);
} ?>">></a>
    </li>
    <li><a href="?pageno=<?php echo $total_pages; ?>">>></a></li>
	</ul>
</nav>
</html>
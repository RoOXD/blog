<?php

setcookie("UserCookie", null, -1, '/');
header('Location: http://127.0.0.1:9000/login.php');

?>
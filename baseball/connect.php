<?php

//Connect To Database
$hostname='127.0.0.1'; //IP or localhost
$username='root'; //default is root
$password=''; //PW
$dbname='gitbaseball'; //Database name you used for this//

$DB = mysqli_connect($hostname,$username,$password,$dbname) or
die("Problem connecting: ".mysqli_error($DB));

mysqli_select_db($DB,$dbname);
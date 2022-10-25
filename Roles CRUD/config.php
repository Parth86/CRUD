<?php
$link = mysqli_connect('localhost', 'root', '', 'crud');
if($link == false) {
    die('Error' .mysqli_connect_error());
}
?>
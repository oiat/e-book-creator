<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

foreach ($_GET['widget'] as $sort => $item) :
$q = "UPDATE " . TBL_BOOKS_WIDGETS . " set sort='$sort' where id='$item'";
$result = $database->query($q);
endforeach;
echo("true");
?>
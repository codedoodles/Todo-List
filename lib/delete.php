<?php
  require_once('db.php');
  $sql_delete = "delete from list_items where list_item = '".$_POST['list_item']."';";

  $db->query($sql_delete);
?>


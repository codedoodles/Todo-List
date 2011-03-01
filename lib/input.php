<?php
  require_once('db.php');
  $sql_insert = "insert into list_items (list_item, list_id) values ('".$_POST['list_item']."', 1);";

  $db->query($sql_insert);
?>

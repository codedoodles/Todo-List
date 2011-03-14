<?php
  require_once('db.php');
  $sql_insert = "insert into lists (list_id, list_title) values (last_insert_id(), '".$_POST['list_title']."');";

  $db->query($sql_insert);
?>

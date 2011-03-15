<?php
  require_once('db.php');
  $sql_delete = "delete from list_items where item_id = '".$_POST['item_id']."';";

  $db->query($sql_delete);
?>


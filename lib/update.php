<?php
  require_once('db.php');
print_r($_POST);

  $sql_update = "update list_items set list_item = '".$_POST['current']."' where list_item = '".$_POST['original']."';";

  $db->query($sql_update);
?>



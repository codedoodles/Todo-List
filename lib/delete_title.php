<?php
  require_once('db.php');
  $sql_delete = "delete from lists where list_id = '".$_POST['list_id']."';";

  $db->query($sql_delete);
?>


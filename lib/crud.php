<?php
  require_once('db.php');
  $sql_delete = "delete from list_items where list_item = '".$_POST['list_item']."';";


  $db->query($sql_delete);




  $sql_insert = "insert into list_items (list_item, list_id) values ('".$_POST['list_item']."', 1);";

  $db->query($sql_insert);






print_r($_POST);

  $sql_update = "update list_items set list_item = '".$_POST['current']."' where list_item = '".$_POST['original']."';";

  $db->query($sql_update);
?>




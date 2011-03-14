<?php
  require_once('db.php');
  $sql_insert = "insert into lists (list_title) values ('".$_POST['list_title']."');";

  $db->query($sql_insert);

  $query_id = 'select last_insert_id()'; 

  $return_id = $db->query($query_id);

  $the_id = $return_id->fetch_array();
  echo $the_id[0];

?>

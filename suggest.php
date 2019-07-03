<?php
require_once 'config.php';

if(isset($_GET['key']) && $_GET['key']!= "") {
  $text = mysqli_real_escape_string($db, $_GET["key"]);
  $keyword =  trim(preg_replace('/\s+/',' ', $text));
  
  $sql = $db->query("SELECT distinct title FROM search WHERE title LIKE '%$keyword%'");
  $rowcount = $sql->num_rows;
  
  if($rowcount != 0) {
	  $json = array();
	  
	  foreach($sql as $key => $value) {
		  $json_data[] = $value['title'];
	  }
	  echo json_encode($json_data);
  } else {
	  echo 0;
  }
}


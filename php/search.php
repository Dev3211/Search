<?php
 require_once 'config.php';

 function title($link) {
  $doc = new DOMDocument();
  @$doc->loadHTMLFile($link);
  $xpath = new DOMXPath($doc);
  
  return $xpath->query('//title')->item(0)->nodeValue."\n";
 }
 
 function description($link) {
  @$url = parse_url( $link );
  @$tags = get_meta_tags($url['scheme'].'://'.$url['host'] );
  return $tags['description'];
 }

 function checkurl($link) {
  $results = true;
  $link = filter_var($link, FILTER_SANITIZE_URL);
	
  if(!filter_var($link, FILTER_VALIDATE_URL)){
   $results = false;	  
  }
	 
  $curlInit = curl_init($link); //make sure you have curl enabled
  curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
  curl_setopt($curlInit,CURLOPT_HEADER,true);
  curl_setopt($curlInit,CURLOPT_NOBODY,true);
  curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
  curl_setopt($curlInit,CURLOPT_HEADER,true);
  curl_setopt($curlInit,CURLOPT_NOBODY,true);
  curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
	 
  $result = curl_exec($curlInit);
  curl_close($curlInit);
	 
  if(!$result) $results = false;
  
  return $results;
 }
 
 if ($_POST && isset($_POST["search"])) {
    $text = mysqli_real_escape_string($db, $_POST["search"]);
    
    if (empty($text)) {
        die('You did not fill out the required field');
    }
    
    $results  = $db->query("SELECT * FROM search WHERE MATCH(title, description) AGAINST('$text')");
    $rowcount = $results->num_rows;
    
    if ($rowcount != 0) {
        while ($row = $results->fetch_array()) {
            echo "<li><a href='" . $row['link'] . "'><span class='title'>" . $row['title'] . "</span>" . "<br>" . $row['link'] . "<br><span class='desc'>" . $row['description'] . "</span></a></li>";
        }
    } else {
		$results  = $db->query("SELECT * FROM search WHERE (title LIKE '%".$text."%' OR description LIKE '%".$text."%') ");
		$rowcount = $results->num_rows;
		
		if($rowcount == 0){
		 die("No search results found!");
		}
		
		 while ($row = $results->fetch_array()) {
            echo "<li><a href='" . $row['link'] . "'><span class='title'>" . $row['title'] . "</span>" . "<br>" . $row['link'] . "<br><span class='desc'>" . $row['description'] . "</span></a></li>";
        }
    }
}else if($_POST && isset($_POST["crawl"])) {
  $link = mysqli_real_escape_string($db, $_POST["crawl"]);
  $link1 = checkurl($link);
  
  if(empty($link)) {
	  die('You did not fill out the required field');
  }else if(!$link1){
	  die('There seems to be an issue with your URL, please check!');
  }
  
  $title = title($link);
  $desc = description($link);
  
  if(!$title || !$desc) {
	die('There was an issue crawling your website!');
  }
	 
  $sql = $db->prepare("SELECT title FROM search WHERE title = ?");
  $sql->bind_param("s", $title);
  $sql->execute();
  $sql->store_result();
	 
  if($sql->num_rows == 1) {
   $sql->close(); 
   die('This website is already crawled!');
  }
  
  $query = $db->prepare("INSERT INTO search (title, description, link) VALUES (?, ?, ?)");
  $query->bind_param("sss", $title, $desc, $link);
  $query->execute();
  
  if($query) {
	die('done');
  } else {
	die($db->error);
  }
}

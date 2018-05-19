<?php


$link = mysql_connect('localhost','root','') or die('Cannot connect to the DB');
	mysql_select_db('sms_roemani',$link) or die('Cannot select the DB');


$query = "SELECT kd_poli,nm_poli FROM ma_poli GROUP BY nm_poli ORDER BY nm_poli ASC";
$result = mysql_query($query,$link) or die('Errant query:  '.$query);
$posts = array();
	if(mysql_num_rows($result)) {
		while($post = mysql_fetch_assoc($result)) {
			$posts[] = array('post'=>$post);
		}
	}

	/* output in necessary format */
	
		header('Content-type: text/xml');
		echo '<posts>';
		foreach($posts as $index => $post) {
			if(is_array($post)) {
				foreach($post as $key => $value) {
					echo '<',$key,'>';
					if(is_array($value)) {
						foreach($value as $tag => $val) {
							echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
						}
					}
					echo '</',$key,'>';
				}
			}
		}
		echo '</posts>';
	

	/* disconnect from the db */
	@mysql_close($link);

 
  ?>  

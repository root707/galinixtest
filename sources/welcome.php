<?php
function PageMain() {
	global $TMPL, $CONF, $db;
	if(isset($_POST['import'])){
		$ext = strtolower(pathinfo($_FILES['csvfile']['name'],PATHINFO_EXTENSION));
		if(!($_FILES['csvfile']['name'])){
			$TMPL['importMsg'] = notificationBox('danger', 'Empty file');
		}elseif ($ext != 'csv') {
			$TMPL['importMsg'] = notificationBox('danger', 'Only CSV files are authorized');
		}elseif ($_FILES['csvfile']['size'] > 1000000 ) {
			$TMPL['importMsg'] = notificationBox('danger', 'Your file is too large, maximum size allowed is 1 Mo');
		}else{
			$finalName = mt_rand().'_'.mt_rand().'.'.$db->real_escape_string($ext);
			move_uploaded_file($_FILES['csvfile']['tmp_name'], './uploads/'.$finalName);
			$csvfile = new Csvfile();
			$csvfile->filename= $finalName;
			$TMPL['importMsg'] =$csvfile->import($db);
		}
		
	}
	$TMPL['menu']='<h5 class="my-0 mr-md-auto font-weight-normal">Import Users</h5>
		<a class="btn btn-primary" href="'.$CONF['url'].'/index.php?a=result" role="button">Results</a>&nbsp;
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Clear all records</button>';
	$TMPL['url'] = $CONF['url'];
	$TMPL['title']="Import users";
	$skin = new skin('welcome/content');
	return $skin->make();
}
?>
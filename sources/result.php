<?php
function PageMain() {
	global $TMPL, $CONF, $db;
	$user = new User();
	$user->db = $db;
	$user->url = $CONF['url'];
	$TMPL['userList'] = $user->getUsers();
	$TMPL['title'] = 'Result';
	$TMPL['menu']='<h5 class="my-0 mr-md-auto font-weight-normal">List of Users</h5>
	<a class="btn btn-primary" href="'.$CONF['url'].'/index.php?a=welcome" role="button">Import</a>&nbsp;';
	$TMPL['title'] = 'Result';
	$skin = new skin('result/content');
	
	return $skin->make();
}
?>
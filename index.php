<?php
require_once('./includes/config.php');
require_once('./includes/skins.php');
require_once('./includes/classes.php');
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");

if(isset($_GET['a']) && isset($action[$_GET['a']])) {
	$page_name = $action[$_GET['a']];
} else {
	$page_name = 'welcome';
}
require_once("./sources/{$page_name}.php");

$TMPL['content'] = PageMain();
$skin = new skin('wrapper');

echo $skin->make();

mysqli_close($db);
?>
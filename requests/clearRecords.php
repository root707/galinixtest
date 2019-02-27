<?php
include("../includes/config.php");
include("../includes/classes.php");

$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");

$user = new User();
$user->db = $db;
$user->clearRecords();
echo notificationBox('success', 'All records are cleared successfuly');
mysqli_close($db);
?>
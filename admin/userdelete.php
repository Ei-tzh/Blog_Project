<?php
require('../config/config.php');

$stmt=$db->prepare("DELETE FROM users WHERE id=".$_GET['id']);
$stmt->execute();

header('Location:userindex.php');
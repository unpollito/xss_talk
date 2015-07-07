<?php

require('db.php');

$db = new DbWrapper();

echo json_encode($db->getMessages());
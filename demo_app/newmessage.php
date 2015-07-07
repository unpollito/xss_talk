<?php

if (!isset($_POST['user']) || !isset($_POST['message']))
{
    echo 'No POST parameters were found.';
    die();
}

require('db.php');

$db = new DbWrapper();
$db->newMessage($_POST['user'], $_POST['message']);
<?php

if (!isset($_POST['user']) || !isset($_POST['image']))
{
    die();
}

require('db.php');

$db = new DbWrapper();
$db->newUser($_POST['user'], $_POST['image']);
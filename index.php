<?php
include_once('staticpage.php');

$id = 1;
$page = new StaticPage($id);
$page->render();
echo $page->id($id);
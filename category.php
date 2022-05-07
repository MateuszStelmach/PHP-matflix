<?php
require_once("includes/header.php");

if(isset($_GET["id"])) {
    $id = $_GET["id"];
    
}else {
    ErrorMsg::show("No id passed to page $id and $end");
}

$preview = new PreviewProvider($con, $usersignin);
echo $preview->createCategoryPreviewVideo($id);

$containers = new CategoryContainers($con, $usersignin);
echo $containers->showCategory($id);
?>

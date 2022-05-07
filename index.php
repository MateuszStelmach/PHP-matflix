<?php
    
require_once("includes/header.php");
$preview = new PreviewProvider($con,$usersignin);

echo $preview->createPreviewVideo(null);

$containers = new CategoryContainers($con,$usersignin);

echo $containers->showAllCategories();

?>

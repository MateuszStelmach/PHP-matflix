<?php
    
require_once("includes/header.php");
$preview = new PreviewProvider($con,$usersignin);

echo $preview->createTvShowPreviewVideo();

$containers = new CategoryContainers($con,$usersignin);

echo $containers->showTVCategories();

?>

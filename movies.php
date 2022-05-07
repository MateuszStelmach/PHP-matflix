<?php
    
require_once("includes/header.php");
$preview = new PreviewProvider($con,$usersignin);

echo $preview-> createMoviesPreviewVideo();

$containers = new CategoryContainers($con,$usersignin);

echo $containers->showMovieCategories();

?>

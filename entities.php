<?php 
require_once("includes/header.php");

if(!isset($_GET["id"])){
    ErrorMsg::show("No id passed into page");
}

$entityId = $_GET["id"];
$entity = new Entity($con, $entityId);

$preview = new PreviewProvider($con,$usersignin);

echo $preview->createPreviewVideo($entity);

$seasonProvider = new SeasonsProvider($con,$usersignin);
echo $seasonProvider->create($entity);

$categoryContainers = new CategoryContainers($con,$usersignin);
echo $categoryContainers->showCategory($entity->getCategoryId(),"You might also like");

?>
<?php
$hideNav = true;
require_once("includes/header.php");

if(!isset($_GET["id"])){
    ErrorMsg::show("No id passed into page");
}

$video = new Video($con, $_GET["id"]);
$video->incrementView();
$upNext = VideoProvider::getUpNext($con,$video);

?>

<div class="watchVideo"> 

<div class = "videoControls watchNav"> 
    <button onclick="goBack()">
    <i class="fas fa-arrow-left"></i>
    </button> 
    <h1><?php echo $video->getTitle() ?></h1>
</div>    


<div class = "videoControls upNext" style="display:none;">

        <button onclick="restartVideo();"><i class="fas fa-redo"></i></button>
        <div class="upNextContainer">
            <h2>Up next:</h2>
            <h3><?php echo $upNext->getTitle() ?></h3>
            <h3><?php echo $upNext->getSeasonAndEpisode() ?></h3>

            <button onclick="watchVideo(<?php echo $upNext->getId() ?>);" class="playNext">

            <i class="fas fa-play"></i> Play

            </button>
        </div>

</div>

<video controls autoplay onended="showupNext();">
        <source src = '<?php echo $video->getFilePath(); ?>' type="video/mp4"> 
</video>

</div>

<script>
    initVideo("<?php echo $video->getId(); ?>", "<?php echo $usersignin; ?>");
</script>

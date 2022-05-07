<?php 

class PreviewProvider {

    private $con;
    private $username;
    public function __construct($con,$username)
    
    {
            $this->con = $con;
            $this->username= $username;    
    }

    public function createCategoryPreviewVideo($categoryId){ 
        $entitiesArray = EntityProvider:: getEntieties($this->con, $categoryId, 1);

        if(sizeof($entitiesArray) == 0) {
            ErrorMsg::show("No TV shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }


    public function createTvShowPreviewVideo(){
        $entitiesArray = EntityProvider::getTvShowEntities($this->con,null,1);

        if(sizeof($entitiesArray) ==0){
            ErrorMsg::show("No Tv show to display");
        }
        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createMoviesPreviewVideo(){
        $entitiesArray = EntityProvider::getMoviesEntities($this->con,null,1);

        if(sizeof($entitiesArray) ==0){
            ErrorMsg::show("No movies to display");
        }
        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createPreviewVideo($etnity){
        if($etnity ==  null){
            $etnity = $this->getRandomEntity();
        };
        $id = $etnity->getId();
        $preview = $etnity ->getPreview();
        $thumbnail = $etnity -> getThumbnail();
        $name = $etnity->getName();

        $videoId =  VideoProvider::getEntityVideoFromUser($this->con,$id,$this->username); 
        $video = new Video($this->con,$videoId);
        $inProgress = $video->isInProgress($this->username);
        $playButton = $inProgress ? "Continue" : "Play" ;
        $seasonEpisode = $video->getSeasonAndEpisode();
        $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>" ;
        return "<div class = 'previewContainer'> 
        
                    <img src = ' $thumbnail' class = 'previewImage' hidden>
                     <video autoplay muted class = 'previewVideo' onended = 'previewEneded()'>
                        <source src = '$preview' type = 'video/mp4'>
                    </video>
                    <div class ='previewOverlay'> 
                        <div class = 'mainDetails'>
                            <h3>$name</h3>
                            $subHeading
                            <div class = 'buttons'>
                            <button onclick='watchVideo($videoId)'><i class='fas fa-play'></i> $playButton</button>
                            <button onclick = 'volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                            </div>
                        </div>
                       </div>
                    </div> ";
      
    }

    public function createEntityPreviwSqr($entity){
        $id = $entity -> getId();
        $thumbnail = $entity -> getThumbnail();
        $name = $entity -> getName();
        return "<a href = 'entities.php?id=$id'>
                <div class = 'previewContainer small'> 
                    <img src = '$thumbnail' title = '$name'>
                </div>
        </a>";
    }

    private function getRandomEntity(){
     $etnity = EntityProvider::getEntieties($this->con,null,1);
     return $etnity[0];
    }
}

?>
<?php 
class CategoryContainers {

    private $con;
    private $username;
    public function __construct($con,$username)
    
    {
            $this->con = $con;
            $this->username= $username;    
    }

    public function showAllCategories(){
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();
        $html = "<div class= 'previewCategories' >";
        while($row = $query->fetch(PDO::FETCH_ASSOC) ){
            $html .= $this->getCategoryHTML($row,null,true,true);
        }
        return $html . "</div>";
       
    }

    public function showTVCategories(){
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();
        $html = "<div class= 'previewCategories' ><h1>TV Shows</h1>";
        while($row = $query->fetch(PDO::FETCH_ASSOC) ){
            $html .= $this->getCategoryHTML($row,null,true,false);
        }
        return $html."</div>";
       
    }

    public function showMovieCategories(){
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();
        $html = "<div class= 'previewCategories' ><h1>Movies</h1>";
        while($row = $query->fetch(PDO::FETCH_ASSOC) ){
            $html .= $this->getCategoryHTML($row,null,false,true);
        }
        return $html."</div>";
       
    }

    public function showCategory($categoryId, $title = null) {
        $query = $this->con->prepare("SELECT * FROM categories WHERE id=:id");
        $query->bindValue(":id", $categoryId);
        $query->execute();

        $html = "<div class='previewCategories noScroll'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, $title, true, true);
        }

        return $html."</div>";
    }

    private function getCategoryHTML($sqldata,$title,$tvShows,$movies){
        $catagoryId = $sqldata["id"];
        $title = $title == null ? $sqldata["name"] : $title ;

        if($tvShows && $movies){
            $entities = EntityProvider::getEntieties($this->con, $catagoryId, 30);
        }else if($tvShows){
            $entities = EntityProvider::getTvShowEntities($this->con, $catagoryId, 30);
        }else{
            $entities = EntityProvider::getMoviesEntities($this->con, $catagoryId, 30);
        }

        if(sizeof($entities)==0){
            return;
        }

        $entitesHTM = "";
        $previewProvider = new PreviewProvider($this->con, $this->username);
        foreach($entities as $entity){
            $entitesHTM .= $previewProvider->createEntityPreviwSqr($entity);
        }

        return "<div class = 'category'> 
                <a href ='category.php?id=$catagoryId'><h3> $title </h3> </a>
                    <div class = 'entities'>$entitesHTM</div>
                 </div>";

    }
}
?>
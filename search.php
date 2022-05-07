<?php
require_once("includes/header.php");
?>
<span></span>
<div class="textBoxContainer">
<input type="text" class="searchInput" placeholder="Search for something"></input>
</div>
<div class="results"></div>

<script>
$(function() {

    var username = '<?php echo $usersignin; ?>';
    var timer;

    $(".searchInput").keyup(function(){
        clearTimeout(timer);
       
        timer = setTimeout(function(){
            var val = $(".searchInput").val();
            if(val !=""){
                $.post("ajax/getSearchResult.php", {term:val,username:username}, function(data){
                    $(".results").html(data);
                })
            } else {
                $(".results").html("");
            }
        },500)
    })
})

</script>

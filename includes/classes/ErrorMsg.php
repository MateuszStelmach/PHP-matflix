<?php
class ErrorMsg{
    public static function show ($text){
        exit("<span class='errorBanner'>$text</span>");
    }
}

?>
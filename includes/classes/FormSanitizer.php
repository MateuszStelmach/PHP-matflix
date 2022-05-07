<?php

class FormSanitizer {
  public static function  sanitizeFormString($inputTxt)
    {
      $inputTxt = strip_tags($inputTxt);
      $inputTxt = str_replace(" ", "",$inputTxt);
      $inputTxt = strtolower($inputTxt);
      $inputTxt = ucfirst($inputTxt);
      return $inputTxt;
    }
    public static function  sanitizeFormUsername($inputTxt)
      {
        $inputTxt = strip_tags($inputTxt);
        $inputTxt = str_replace(" ", "",$inputTxt);
        return $inputTxt;
      }

      public static function  sanitizeFormPassword($inputTxt)
        {
          $inputTxt = strip_tags($inputTxt);
          return $inputTxt;
        }

        public static function  sanitizeFormEmail($inputTxt)
          {
            $inputTxt = strip_tags($inputTxt);
            $inputTxt = str_replace(" ", "",$inputTxt);
            return $inputTxt;
          }

  }
  ?>

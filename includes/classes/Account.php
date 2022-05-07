<?php
class Account{
  private $con;
  private $errorArray = array();
  public function __construct($con){
    $this->con = $con;
  }

  public function updateDetails($fn, $ln, $em, $un) {
    $this->validateFirstName($fn);
    $this->validateLastName($ln);
    $this->validateNewEmail($em, $un);

    if(empty($this->errorArray)) {
        $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln, email=:em
                                        WHERE username=:un");
        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":em", $em);
        $query->bindValue(":un", $un);

        return $query->execute();
    }

    return false;
}

  public function register ($fn,$ln,$un,$email,$email2,$pswd,$pswd2){
    $this->validateFirstName($fn);
    $this->validateLastName($ln);
    $this->validateUsername($un);
    $this->validateEmail($email,$email2);
    $this->validatePswd($pswd,$pswd2);
    if(empty($this->errorArray)){
      return $this-> insertUserDetails($fn,$ln,$un,$email,$pswd);
    }
    return false;
  }

  public function signin ($username, $password){
    $password = hash("sha512",$password);

    $query = $this->con->prepare("SELECT * FROM users WHERE username = :un AND password = :pswd");
   
    $query->bindValue(":un",$username);
  
    $query->bindValue(":pswd",$password);
    $query->execute();

    if($query->rowCount()==1){
      return true;
    } else {
      array_push($this->errorArray, Constants::$signInError);
      return false;} 

  }

  private function insertUserDetails($fn,$ln,$un,$email,$pswd){
    $pswd = hash("sha512",$pswd);
    $query = $this->con->prepare("INSERT INTO users (firstName,lastName,username,email,password)
                                          VALUES (:fn,:ln,:un,:em,:pswd)");
    $query->bindValue(":fn",$fn);
    $query->bindValue(":ln",$ln);
    $query->bindValue(":un",$un);
    $query->bindValue(":em",$email);
    $query->bindValue(":pswd",$pswd);
    return $query->execute();

  }

  private function validateFirstName($fn){
      if(strlen($fn)  < 2 || strlen($fn) > 25){
      array_push($this->errorArray,Constants::$firstNameErrorMsg);
     
      }
  }

  private function validateLastName($ln){
      if(strlen($ln)  < 2 || strlen($ln) > 25){
      array_push($this->errorArray,Constants::$lastNameErrorMsg);
      }
  }

  private function validateUsername($un){
      if(strlen($un)  < 5 || strlen($un) > 50){
      array_push($this->errorArray,Constants::$usernameErrorMsg);
      return;
      }

      $query = $this->con->prepare("SELECT * FROM users WHERE username-:un");
      $query->bindValue(":un",$un);
      $query->execute();
      $num = $query->rowCount();
      if($num != 0){
        array_push($this->errorArray,Constants::$usernameTaken);
      }
  }

  private function validateNewEmail($em, $un) {

    if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
        array_push($this->errorArray, Constants::$emailInvalid);
        return;
    }

    $query = $this->con->prepare("SELECT * FROM users WHERE email=:em AND username != :un");
    $query->bindValue(":em", $em);
    $query->bindValue(":un", $un);

    $query->execute();
    
    if($query->rowCount() != 0) {
        array_push($this->errorArray, Constants::$emailTaken);
    }
}

  private function validateEmail($em, $em2){
   if($em != $em2){
    array_push($this->errorArray,Constants::$emailCompareErrMsg);
    return;
   }
   if(!filter_var($em,FILTER_VALIDATE_EMAIL)){
    array_push($this->errorArray,Constants::$emailNotProper);
    return;
   }
   $query = $this->con->prepare("SELECT * FROM users WHERE email-:em");
   $query->bindValue(":em",$em);
   $query->execute();
   $num = $query->rowCount();
   if($num != 0){
     array_push($this->errorArray,Constants::$emailTaken);
   }
  }

  private function validatePswd($pswd,$pswd2){
    if($pswd != $pswd2){
      array_push($this->errorArray,Constants::$passwordErrorMsg);
      return;
    }
    if(strlen($pswd) < 5 || strlen($pswd) > 255){
      array_push($this->error_Array,Constants::$password2ErrorMsg);
    }
  }


  public function getError($error){
    if(in_array($error,$this->errorArray)){
      return "<span class ='errorMsg'> $error</span>";
    }
  }


public function getFirstError() {
    if(!empty($this->errorArray)) {
        return $this->errorArray[0];
    }
}

public function updatePassword($oldPw, $pw, $pw2, $un) {
  $this->validateOldPassword($oldPw, $un);
  $this->validatePswd($pw, $pw2);

  if(empty($this->errorArray)) {
      $query = $this->con->prepare("UPDATE users SET password=:pw WHERE username=:un");
      $pw = hash("sha512", $pw);
      $query->bindValue(":pw", $pw);
      $query->bindValue(":un", $un);

      return $query->execute();
  }

  return false;
}

public function validateOldPassword($oldPw, $un) {
  $pw = hash("sha512", $oldPw);

  $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
  $query->bindValue(":un", $un);
  $query->bindValue(":pw", $pw);

  $query->execute();

  if($query->rowCount() == 0) {
      array_push($this->errorArray, Constants::$passwordIncorrect);
  }
}



}


 ?>

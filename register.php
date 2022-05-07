<?php
require_once("includes/classes/FormSanitizer.php");
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");


 $account = new Account($con);

  if(isset($_POST["submitButton"])) {
    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

    $success = $account->register($firstName,$lastName,$username,$email,$email2,$password,$password2);
    if($success){
      $_SESSION["userSignedIn"] = $username;
      header("Location:index.php");
    }

  }

  function getInputValue($name){
    if(isset($_POST[$name])){
      echo $_POST[$name];
    }
  }

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to MatFlix</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
  </head>
  <body>
<div class="signInContainer">
  <div class="column">
      <div class="header">
          <img src="assets/images/matflix.png" title="Logo" alt="Site Logo" />
          <h3 class = "singUpMessage"> Sing Up </h3>
          <span class = "singUpMessage2"> to continue to watch great movies </span>

      </div>
      <form method="POST">
          <?php echo $account->getError(Constants::$firstNameErrorMsg); ?>
        <input type="text" name="firstName"placeholder="First name" value = "<?php getInputValue("firstName"); ?>" required>
          <?php echo $account->getError(Constants::$lastNameErrorMsg); ?>
        <input type="text" name="lastName"placeholder="Last name" value = "<?php getInputValue("lastName"); ?>" required >
            <?php echo $account->getError(Constants::$usernameErrorMsg); ?>
            <?php echo $account->getError(Constants::$usernameTaken); ?>
        <input type="text" name="username"placeholder="Username" value = "<?php getInputValue("username"); ?>" required >
        <?php echo $account->getError(Constants::$emailCompareErrMsg); ?>
        <?php echo $account->getError(Constants::$emailNotProper); ?>
        <?php echo $account->getError(Constants::$emailTaken); ?>
        <input type="email" name="email"placeholder="E-mail" value = "<?php getInputValue("email"); ?>" required >
        <input type="email" name="email2"placeholder="Confirm e-mail"  value = "<?php getInputValue("email2"); ?>" required>
        <?php echo $account->getError(Constants::$passwordErrorMsg); ?>
        <?php echo $account->getError(Constants::$password2ErrorMsg); ?>
        <input type="password" name="password"placeholder="Password" required>
        <input type="password" name="password2"placeholder="Confirm password" required>
        <input type="submit" name="submitButton"value="SUBMIT">

      </form>
      <a href = "login.php" class="signInMessage"> Already have an account? Sign in here </a>
  </div>
</div>
  </body>
</html>

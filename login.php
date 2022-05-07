<?php

require_once("includes/classes/FormSanitizer.php");
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");


 $account = new Account($con);

  if(isset($_POST["submitButton"])) {
    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

    $success = $account->signin($username,$password);
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
          <h3> Sign In </h3>
          <span> to continue to watch great movies </span>

      </div>
      <form method="POST">
      <?php echo $account->getError(Constants::$signInError); ?>
        <input type="text" name="username"placeholder="Username" value = "<?php getInputValue("username"); ?>" required>
        <input type="password" name="password"placeholder="Password" required>
        <input type="submit" name="submitButton"value="SUBMIT">
      </form>
      <a href = "register.php" class="signInMessage"> Don't have an account? Sign Up here! </a>
  </div>
</div>
  </body>
</html>

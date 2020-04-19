<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/retman/core/init.php';
  include 'includes/head.php';

  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $email = trim($email);
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $password = trim($password);
  $errors = array();
?>

<style media="screen">
  body
  {
    background-image: url("/retman/images/headerlogo/adminBackground.png");
    background-size: 100vw 100vh;
    background-attachment: fixed;
  }
</style>

<div id="login-form">
  <div>
    <?php
      if ($_POST)
      {
        //form validation
        if (empty($_POST['email']) || empty($_POST['password']))
        {
          $errors[] = 'You must provide email and password.';
        }
        //validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
          $errors[] = 'You must enter a valid email';
        }
        //password is more than 6 characters
        if (strlen($password) < 6)
        {
          $errors[] = 'Password must be at least 6 characters';
        }
        //check if email exists in the database
        $query = $db->query("SELECT * FROM users WHERE email = '$email'");
        $user = mysqli_fetch_assoc($query);
        $userCount = mysqli_num_rows($query);
        if ($userCount < 1)
        {
          $errors[] = 'That email does not exist in our database';
        }
        if (!password_verify($password, $user['password']))
        {
          $errors[] = 'The password does not match our records. Please try again.';
        }
        //check for errors
        if (!empty($errors))
        {
          echo display_error($errors);
        }
        else
        {
          $user_id = $user['id'];
          login($user_id);
        }
      }
    ?>
  </div>
  <h2 class="text-center">Login</h2>
  <form action="login.php" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" class="form-control" value="<?php echo $password; ?>">
    </div>
    <div class="form-group">
      <input type="submit" value="Login" class="btn btn-primary">
    </div>
    <div class="form-group">
      <p class="text-center"><a href="create_acc.php" alt="home">Don't have an account? Create now !</a></p>
    </div>
  </form>
  <p class="text-right"><a href="/retman/index.php" alt="home">Visit Site</a></p>

</div>

<?php include 'includes/footer.php' ?>

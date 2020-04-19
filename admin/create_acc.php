<?php
  require_once '../core/init.php';
  include 'includes/head.php';

  $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
  $errors = array();

  if ($_POST)
  {
    $emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
    $emailCount = mysqli_num_rows($emailQuery);
    if ($emailCount != 0)
    {
      $errors[] = 'That email already exists on our database';
    }
    $required = array('name', 'email', 'password', 'confirm', 'permissions');
    foreach ($required as $f)
    {
      if (empty($_POST[$f]))
      {
        $errors[] = 'You must fill out all fields';
        break;
      }
    }
    if (strlen($password) < 6)
    {
      $errors[] = 'Your password must be at least 6 characters.';
    }
    if ($password != $confirm)
    {
      $errors[] = 'Your password password does not match';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $errors[] = 'You must enter a valid email.';
    }
    if (!empty($errors))
    {
      echo display_error($errors);
    }
    else
    {
      //add user
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $db->query("INSERT INTO users (full_name, email, password, permissions) VALUES ('$name', '$email', '$hashed', '$permissions')");
      $_SESSION['success_flash'] = 'Account has been created ! You can log in now.';
      header('LOCATION: login.php');
    }
  }
?>
<h2 class="text-center">Create New Account</h2>
<form action="create_acc.php" method="post">
  <div class="form-group col-md-6">
    <label for="name">Full Name:</label>
    <input type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>">
  </div>
  <div class="form-group col-md-6">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
  </div>
  <div class="form-group col-md-6">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" class="form-control" value="<?php echo $password; ?>">
  </div>
  <div class="form-group col-md-6">
    <label for="confirm">Comfirm Password:</label>
    <input type="password" name="confirm" id="confirm" class="form-control" value="<?php echo $confirm; ?>">
  </div>
  <div class="form-group col-md-6">
    <label for="name">Permission:</label>
    <select class="form-control" name="permissions">
      <option value=""<?=(($permissions == '')?' selected':'') ;?>></option>
      <option value="user"<?=(($permissions == 'user')?' selected':'') ;?>>User</option>
    </select>
  </div>
  <div class="form-group col-md-6 text-right" style="margin-top:25px;">
    <a href="login.php" class="btn btn-default">Cancel</a>
    <input type="submit" value="Create Account" class="btn btn-primary">
  </div>
</form>

<?php
  include 'includes/footer.php';
?>

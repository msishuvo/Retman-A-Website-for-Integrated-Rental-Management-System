<?php
  require_once '../core/init.php';
  if (!is_logged_in())
  {
    login_error_redirect();
  }
  if (!has_permission('admin'))
  {
    permission_error_redirect('index.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
  //get brands from Database
  $sql = "SELECT * FROM brand ORDER BY brand";
  $results = $db->query($sql);

  $errors = array();

  //Edit Brand
  if (isset($_GET['edit']) && !empty($_GET['edit']))
  {
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $sql2 = "SELECT * FROM brand WHERE id = '$edit_id'";
    $edit_result = $db->query($sql2);
    $eBrand = mysqli_fetch_assoc($edit_result);
  }

  //Delete Brand
  if (isset($_GET['delete']) && !empty($_GET['delete']))
  {
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sql = "DELETE FROM brand WHERE id = '$delete_id'";
    $db->query($sql);
    echo "<script>alert('Brand name successfully deleted. Please see the table..'); window.location = 'brands.php';</script>";
  }

  //If add form is submitted
  if(isset($_POST['add_submit']))
  {
    $brand = sanitize($_POST['brand']);
    //check if brand is blank
    if ($_POST['brand'] == "")
    {
      $errors[] .= "You must enter a BRAND name !";
    }
    //check if brand exists on Database
    $sql = "SELECT * FROM brand WHERE brand = '$brand'";
    if (isset($_GET['edit']))
    {
      $sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";
    }
    $result_exits = $db->query($sql);
    $count = mysqli_num_rows($result_exits);
    if ($count > 0)
    {
      $errors[] .= $brand.' is already exists ! Enter another Brand name...';
    }
    //display errors
    if (!empty($errors))
    {
      echo display_error($errors);
    }

    else
    {
      //Add brand to Database
      $sql = "INSERT INTO brand (brand) VALUES ('$brand')";
      if (isset($_GET['edit']))
      {
        $sql = "UPDATE brand SET brand='$brand' WHERE id='$edit_id'";
      }
      $db->query($sql);
      echo "<script>alert('Operation successfully done!! Please see the table..'); window.location = 'brands.php';</script>";
    }
  }
?>
<h2 class="text-center">Brands</h2><hr>
<!--Brand Form-->
<div class="text-center">
  <form class="form-inline" action="brands.php<?php echo ((isset($_GET['edit']))?'?edit='.$edit_id :''); ?>" method="post">
    <div class="form-group">
      <?php
        $brand_value='';
        if (isset($_GET['edit']))
        {
          $brand_value = $eBrand['brand'];
        }
        else
        {
          if (isset($_POST['brand']))
          {
            $brand_value = sanitize($_POST['brand']);
          }
        }
      ?>
      <label for="brand"><?php echo ((isset($_GET['edit']))?'Edit':'Add') ?> a Brand Name</label>
      <input type="text" name="brand" id="brand" class="form-control" value="<?php echo $brand_value; ?>">
      <?php if(isset($_GET['edit'])): ?>
        <a href="brands.php" class="btn btn-default">Cancel</a>
      <?php endif; ?>
      <input type="submit" name="add_submit" value="<?php echo ((isset($_GET['edit']))?'Edit':'Add') ?> Brand" class="btn btn-success">
    </div><hr>
  </form>

</div>
<table class="table table-bordered table-striped table-auto table-condensed">
  <thead>
    <th></th>
    <th>Brands</th>
    <th></th>
  </thead>
  <tbody>
    <?php while ($brand = mysqli_fetch_assoc($results)): ?>
    <tr>
      <td><a href="brands.php?edit=<?php echo $brand['id']; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
      <td><?php echo $brand['brand']; ?></td>
      <td><a href="brands.php?delete=<?php echo $brand['id']; ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Remove</a></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php include 'includes/footer.php'; ?>

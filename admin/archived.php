<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/retman/core/init.php';
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

  //Restore Product
  if (isset($_GET['restore']))
  {
    $id = sanitize($_GET['restore']);
    $db->query("UPDATE products SET deleted = 0 WHERE id = '$id'");
    header('LOCATION: archived.php');
  }

  $sql = "SELECT * FROM products WHERE deleted = 1";
  $presults = $db->query($sql);
  ?>

  <h2 class="text-center">Archived Products</h2>
  <hr>
  <table class="table table-bordered table-condensed table-striped">
    <thead>
      <th></th>
      <th>Product</th>
      <th>Price</th>
      <th>Category</th>
      <th>Sold</th>
    </thead>
    <tbody>
      <?php while($product = mysqli_fetch_assoc($presults)) :
        $childID = $product['categories'];
        $catSql = "SELECT * FROM categories WHERE id = '$childID'";
        $result = $db->query($catSql);
        $child = mysqli_fetch_assoc($result);
        $parentID = $child['parent'];
        $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
        $presult = $db->query($pSql);
        $parent = mysqli_fetch_assoc($presult);
        $category = $child['category'].' ('.$parent['category'].')';
        ?>
        <tr>
          <td>
            <a href="archived.php?restore=<?php echo $product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-refresh"></sapn></a>
          </td>
          <td><?php echo $product['title']; ?></td>
          <td><?php echo money($product['price']); ?></td>
          <td><?php echo $category; ?></td>
          <td>0</td>
        </tr>
      <?php endwhile; ?>
    </tbody>

  </table>

  <?php
  include 'includes/footer.php';
?>

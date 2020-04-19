<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  include 'includes/leftbar.php';

  $sql = "SELECT * FROM products";
  $cat_id = (($_POST['cat'] != '')?sanitize($_POST['cat']):'');

  if ($cat_id == '')
  {
    $sql .= " WHERE deleted = 0";
  }
  else
  {
    $sql .= " WHERE categories = '$cat_id' AND deleted = 0";
  }

  $price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
  $min_price = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):'');
  $max_price = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):'');
  $brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):'');

  if ($min_price != '')
  {
    $sql .= " AND price >= '$min_price'";
  }
  if ($max_price != '')
  {
    $sql .= " AND price <= '$max_price'";
  }
  if ($brand != '')
  {
    $sql .= " AND brand = '$brand'";
  }
  if ($price_sort == 'low')
  {
    $sql .= " ORDER BY price";
  }
  if ($price_sort == 'high')
  {
    $sql .= " ORDER BY price DESC";
  }

  $productQ = $db->query($sql);
  $category = get_category($cat_id);
?>
  <!-- Top nav bar -->

  <!-- Header -->


    <!--Main Content-->
  <div class="col-md-8">
    <div class="row">
      <?php if($cat_id != ''): ?>
        <h2 class="text-center"><?php echo $category['parent'].' '.$category['child']; ?></h2>
      <?php elseif(mysqli_num_rows($productQ)==0):?>
        <h2 class="text-center text-danger">No Results Found !</h2>
      <?php else: ?>
        <h2 class="text-center">Search Results</h2>
      <?php endif; ?>
      <?php while ($product = mysqli_fetch_assoc($productQ)) : ?>
        <div class="col-md-3 text-center">
          <h4><?php echo $product['title']; ?></h4>
          <?php $photos = explode(',',$product['image']); ?>
          <img src="<?php echo $photos[0]; ?>" alt="<?php echo $product['title']; ?>" class="img-thumb">
          <p class="list-price text-danger">List Price: <s>$<?php echo $product['list_price']; ?></s></p>
          <p class="price">Our Price: $<?php echo $product['price']; ?></p>
          <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $product['id']; ?>)">Details</button>
        </div>
      <?php endwhile; ?>


    </div>
  </div>

<?php
  include 'includes/rightbar.php';
  include 'includes/footer.php';
?>

<?php
  require_once '../core/init.php';
  if (!is_logged_in())
  {
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
  //session_destroy();
?>
<!--Order to Fill -->
<?php
  $txnQuery = "SELECT t.id, t.cart_id, t.full_name, t.description, t.txn_date, t.grand_total, c.items, c.paid, c.shipped FROM transactions t
    LEFT JOIN cart c ON t.cart_id = c.id WHERE c.paid = 1 AND c.shipped = 0 ORDER BY t.txn_date";
  $txnResults = $db->query($txnQuery);


?>
<div class="col-md-12">
  <h3 class="text-center">Orders To Ship</h3>
  <table class="table table-condensed table-bordered table-striped">
    <thead>
      <th></th>
      <th>Name</th>
      <th>Description</th>
      <th>Total</th>
      <th>Date</th>
    </thead>
    <tbody>
      <?php while($order = mysqli_fetch_assoc($txnResults)): ?>
        <tr>
          <td><a href="orders.php?txn_id=<?php echo $order['id']; ?>" class="btn btn-xs btn-info">Details</a></td>
          <td><?php echo $order['full_name']; ?></td>
          <td><?php echo $order['description']; ?></td>
          <td><?php echo money($order['grand_total']); ?></td>
          <td><?php echo pretty_date($order['txn_date']); ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<div class="row">
  <!--Rents By Month-->
  <?php
    $thisYr = date("Y");
    $lastYr = $thisYr - 1;
    $thisYrQ = $db->query("SELECT grand_total, txn_date FROM transactions WHERE YEAR(txn_date) = '$thisYr'");
    $lastYrQ = $db->query("SELECT grand_total, txn_date FROM transactions WHERE YEAR(txn_date) = '$lastYr'");
    $current = array();
    $last = array();
    $currentTotal = 0;
    $lastTotal = 0;

    for ($month=1; $month <=12 ; $month++)
    {
      $last[(INT)$month] = 0;
      $current[(INT)$month] = 0;
    }

    while ($x = mysqli_fetch_assoc($thisYrQ))
    {
      $month = date("m", strtotime($x['txn_date']));
      $current[(int)$month] += $x['grand_total'];
      $currentTotal += $x['grand_total'];
    }
    while ($x = mysqli_fetch_assoc($lastYrQ))
    {
      $month = date("m", strtotime($x['txn_date']));
      $last[(int)$month] += $x['grand_total'];
      $lastTotal += $x['grand_total'];
    }
  ?>
  <div class="col-md-4">
    <h3 class="text-center">Rents By Month</h3>
    <table class="table table-striped table-bordered table-condensed">
      <thead>
        <th></th>
        <th><?php echo $lastYr; ?></th>
        <th><?php echo $thisYr; ?></th>
      </thead>
      <tbody>
        <?php for($i = 1; $i <= 12; $i++):
          $dt = DateTime::createFromFormat('!m',$i);
        ?>
          <tr>
            <td><?php echo $dt->format("F"); ?></td>
            <td><?php echo (array_key_exists($i,$last))?money($last[$i]):money(0); ?></td>
            <td><?php echo (array_key_exists($i,$current))?money($current[$i]):money(0); ?></td>
          </tr>
        <?php endfor; ?>
        <tr>
          <td>Total</td>
          <td><?php echo money($lastTotal); ?></td>
          <td><?php echo money($currentTotal); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <!--Inventory-->
  <?php
    $iQuery = $db->query("SELECT * FROM products WHERE deleted = 0");
    $lowItems = array();
    while ($product = mysqli_fetch_assoc($iQuery))
    {
      $item = array();
      $editions = editionsToArray($product['editions']);
      foreach ($editions as $edition)
      {
        if ($edition['quantity'] <= $edition['threshold'])
        {
          $cat = get_category($product['categories']);
          $item = array(
            'title' => $product['title'],
            'edition' => $edition['edition'],
            'quantity' => $edition['quantity'],
            'threshold' => $edition['threshold'],
            'category' => $cat['parent']. '~'.$cat['child']
          );
          $lowItems[] = $item;
        }
      }
    }
  ?>
  <div class="col-md-8">
    <h3 class="text-center">Inventory</h3>
    <table class="table table-striped table-bordered table-condensed">
      <thead>
        <th>Product</th>
        <th>Category</th>
        <th>Edition</th>
        <th>Quantity</th>
        <th>Inventory</th>
      </thead>
      <tbody>
        <?php foreach ($lowItems as $item): ?>
          <tr <?php echo ($item['quantity'] == 0)?' class="danger"':''; ?>>
            <td><?php echo $item['title']; ?></td>
            <td><?php echo $item['category']; ?></td>
            <td><?php echo $item['edition']; ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo $item['threshold']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

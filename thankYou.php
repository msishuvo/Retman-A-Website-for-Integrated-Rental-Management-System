<?php
  require_once 'core/init.php';

  // Set your secret key: remember to change this to your live secret key in production
  // See your keys here: https://dashboard.stripe.com/account/apikeys
  \Stripe\Stripe::setApiKey(STRIPE_PRIVATE);

  // Token is created using Checkout or Elements!
  // Get the payment token ID submitted by the form:
  $token = $_POST['stripeToken'];
  //get rest of the post data

  $full_name = sanitize($_POST['full_name']);
  $email = sanitize($_POST['email']);
  $phone = sanitize($_POST['phone']);
  $street = sanitize($_POST['street']);
  $street2 = sanitize($_POST['street2']);
  $city = sanitize($_POST['city']);
  $state = sanitize($_POST['state']);
  $zip_code = sanitize($_POST['zip_code']);
  $country = sanitize($_POST['country']);
  $tax = sanitize($_POST['tax']);
  $sub_total = sanitize($_POST['sub_total']);
  $grand_total = sanitize($_POST['grand_total']);
  $cart_id = sanitize($_POST['cart_id']);
  $description = sanitize($_POST['description']);
  $charge_amount = number_format($grand_total, 2) * 100;
  $metadata = array(
    "cart_id" => $cart_id,
    "tax" => $tax,
    "sub_total" => $sub_total,
  );


  try
  {
    $charge = \Stripe\Charge::create([
      'amount' => $charge_amount,
      'currency' => CURRENCY,
      'description' => $description,
      'source' => $token,
      'receipt_email' => $email,
      'metadata' => $metadata,
    ]);

    //adjust inventory
    $itemQ = $db->query("SELECT * FROM cart WHERE id = '$cart_id'");
    $iresults = mysqli_fetch_assoc($itemQ);
    $items = json_decode($iresults['items'],true);
    foreach ($items as $item)
    {
      $newEditions = array();
      $item_id = $item['id'];
      $productQ = $db->query("SELECT editions FROM products WHERE id = '$item_id'");
      $product = mysqli_fetch_assoc($productQ);
      $editions = editionsToArray($product['editions']);
      foreach ($editions as $edition)
      {
        if ($edition['edition'] == $item['edition'])
        {
          $q = $edition['quantity'] - $item['quantity'];
          $t = $edition['threshold'];
          $newEditions[] = array('edition' => $edition['edition'], 'quantity' => $q, 'threshold' => $t);
        }
        else
        {
          $newEditions[] = array('edition' => $edition['edition'], 'quantity' => $edition['quantity'], 'threshold' => $edition['threshold']);
        }
      }
      $editionString = editionsToString($newEditions);
      $db->query("UPDATE products SET editions = '$editionString' WHERE id = '$item_id'");
    }

    //update cart
    $db->query("UPDATE cart SET paid = 1 WHERE id = '$cart_id'");
    $db->query("INSERT INTO transactions (charge_id, cart_id, full_name, email, phone, street, street2, city, state, zip_code, country, sub_total, tax, grand_total, description, txn_type)
                VALUES ('$charge->id', '$cart_id', '$full_name', '$email', '$phone', '$street', '$street2', '$city', '$state', '$zip_code', '$country', '$sub_total', '$tax', '$grand_total', '$description', '$charge->object')");
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST'] : false;
    setcookie(CART_COOKIE,'',1,"/",$domain,false);
    include 'includes/head.php';
    include 'includes/navigation.php';
    include 'includes/headerpartial.php';
?>
    <h1 class="text-center text-success">Thank You!</h1>
    <p>
      Your card has been successfully charged <?php echo money($grand_total); ?>. You will be contacted soon through your contact number and mail address. You can print this page as a receipt also.
    </p>
    <p>Your order will be shipped to the address below: </p>
    <address>
      <?php echo $full_name; ?><br>
      <?php echo $phone; ?><br>
      <?php echo $street; ?>
      <?php echo (($street2 !='')?$street2.'<br>':''); ?>
      <?php echo $city.', '.$state.', '.$zip_code; ?><br>
      <?php echo $country; ?><br>
    </address>
    <h6 class="text-center text-danger">*Important: Product must be returned within 3 days.</h6>

<?php
  include 'includes/footer.php';
  }
  catch(\Stripe\Error\Card $e)
  {
    echo $e;
  }
?>

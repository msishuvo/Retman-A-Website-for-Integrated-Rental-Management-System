<?php
  require_once 'core/init.php';
  if (!is_logged_in())
  {
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'admin/includes/navigation.php';
  include 'includes/headerpartial.php';

  if ($cart_id != '')
  {
    $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
    $result = mysqli_fetch_assoc($cartQ);
    $items = json_decode($result['items'], true);
    $i = 1;
    $sub_total = 0;
    $item_count = 0;

  }
?>

<div class="col-md-12">
  <div class="row">
    <h2 class="text-center">My Shopping Cart</h2><hr>
    <?php if ($cart_id == '') : ?>
      <div class="bg-danger">
        <p class="text-center text-danger">
          Your shopping cart is empty !
        </p>
      </div>
    <?php else : ?>
      <table class="table table-bordered table-condensed table-striped">
        <thead>
          <th>#</th>
          <th>Item</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Edition</th>
          <th>Sub Total</th>
        </thead>
        <tbody>
          <?php
            foreach ($items as $item)
            {
              $product_id = $item['id'];
              $productQ = $db->query("SELECT * FROM products WHERE id = '$product_id'");
              $product = mysqli_fetch_assoc($productQ);
              $sArray = explode(',',$product['editions']);
              foreach ($sArray as $editionString)
              {
                $s = explode(':', $editionString);
                if ($s[0] == $item['edition'])
                {
                  $available = $s[1];
                }
              }
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $product['title']; ?></td>
                <td><?php echo money($product['price']); ?></td>
                <td>
                  <button class="btn btn-xs btn-default" onclick="update_cart('removeone', '<?php echo $product['id']; ?>', '<?php echo $item['edition']; ?>');">-</button>
                  <?php echo $item['quantity']; ?>
                  <?php if($item['quantity'] < $available): ?>
                    <button class="btn btn-xs btn-default" onclick="update_cart('addone', '<?php echo $product['id']; ?>', '<?php echo $item['edition']; ?>');">+</button>
                  <?php else: ?>
                    <span class="text-danger">Maximum reached</span>
                  <?php endif; ?>
                </td>
                <td><?php echo $item['edition']; ?></td>
                <td><?php echo money($item['quantity'] * $product['price']); ?></td>
              </tr>
              <?php
              $i++;
              $item_count += $item['quantity'];
              $sub_total += ($product['price'] * $item['quantity']);
            }
            $tax = TAXRATE * $sub_total;
            $tax = number_format($tax,2);
            $grand_total = $tax + $sub_total;
          ?>
        </tbody>
      </table>

      <table class="table table-bordered table-condensed text-center">
        <legend class="text-center">Totals</legend>
        <thead class="totals-table-header">
          <th>Total Items</th>
          <th>Sub Total</th>
          <th>Tax</th>
          <th>Grand Total</th>
        </thead>

        <tbody>
          <tr>
            <td><?php echo $item_count; ?></td>
            <td><?php echo money($sub_total); ?></td>
            <td><?php echo money($tax); ?></td>
            <td class="bg-success"><?php echo money($grand_total); ?></td>
          </tr>
        </tbody>
      </table>
      <!--Check Out -->
      <div class="col-xs-2 pull-right">
        <button type="button" class="btn btn-primary btn-primary btn-block" data-toggle="modal" data-target="#checkoutModal">
          <span class="glyphicon glyphicon-shopping-cart"></span> Card Payment >>
        </button>
      </div>
      <div class="col-xs-2 pull-right">
        <button type="button" class="btn btn-primary btn-primary btn-block" data-toggle="modal" data-target="#checkoutModal2">
          <span class="glyphicon glyphicon-shopping-cart"></span> Cash on Delivery >>
        </button>
      </div>

      <!--MODAL2-->
      <div class="modal fade" id="checkoutModal2" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="checkoutModalLabel2">Shipping Address</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form action="thankYou2.php" method="post" id="payment-form2">
                  <span class="bg-danger" id="payment-errors2"></span>
                  <input type="hidden" name="tax" value="<?php echo $tax; ?>">
                  <input type="hidden" name="sub_total" value="<?php echo $sub_total; ?>">
                  <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">
                  <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                  <input type="hidden" name="description" value="<?php echo $item_count.' item'.(($item_count>1)?'s':'').' from Retman.'; ?>">
                  <div id="step21" style="display:block;">
                    <div class="form-group col-md-6">
                      <label for="full_name">Full Name:</label>
                      <input type="text" class="form-control" id="full_name2" name="full_name">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="email">Email:</label>
                      <input type="email" class="form-control" id="email2" name="email">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="conNum">Contact Number:</label>
                      <input type="tel" class="form-control" id="phone2" name="phone">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="street">Street Address:</label>
                      <input type="text" class="form-control" id="street2" name="street">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="street2">Street Address 2:</label>
                      <input type="text" class="form-control" id="street22" name="street2">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="city">City:</label>
                      <input type="text" class="form-control" id="city2" name="city">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="state">State:</label>
                      <input type="text" class="form-control" id="state2" name="state">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="zip_code">Zip Code:</label>
                      <input type="text" class="form-control" id="zip_code2" name="zip_code">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="country">Country:</label>
                      <input type="text" class="form-control" id="country2" name="country">
                    </div>
                  </div>
                  <div id="step22" style="display:none;">
                    <div class="form-group row-xs-2">
                      <h2 class="text-center">If you are confirm, click checkout button.</h2>
                    </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="check_address2();" id="next_button2">Next >></button>
              <button type="button" class="btn btn-primary" onclick="back_address2();" id="back_button2" style="display:none;"><< Back</button>
              <button type="submit" class="btn btn-primary" id="checkout_button2" style="display:none;">Checkout >></button>
                </form>
            </div>
          </div>
        </div>
      </div>


      <!-- Modal -->
      <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="checkoutModalLabel">Shipping Address</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form action="thankYou.php" method="post" id="payment-form">
                  <span class="bg-danger" id="payment-errors"></span>
                  <input type="hidden" name="tax" value="<?php echo $tax; ?>">
                  <input type="hidden" name="sub_total" value="<?php echo $sub_total; ?>">
                  <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">
                  <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                  <input type="hidden" name="description" value="<?php echo $item_count.' item'.(($item_count>1)?'s':'').' from Retman.'; ?>">
                  <div id="step1" style="display:block;">
                    <div class="form-group col-md-6">
                      <label for="full_name">Full Name:</label>
                      <input type="text" class="form-control" id="full_name" name="full_name">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="email">Email:</label>
                      <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="conNum">Contact Number:</label>
                      <input type="tel" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="street">Street Address:</label>
                      <input type="text" class="form-control" id="street" name="street" data-stripe="address_line1">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="street2">Street Address 2:</label>
                      <input type="text" class="form-control" id="street2" name="street2" data-stripe="address_line2">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="city">City:</label>
                      <input type="text" class="form-control" id="city" name="city" data-stripe="address_city">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="state">State:</label>
                      <input type="text" class="form-control" id="state" name="state" data-stripe="address_state">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="zip_code">Zip Code:</label>
                      <input type="text" class="form-control" id="zip_code" name="zip_code" data-stripe="address_zip">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="country">Country:</label>
                      <input type="text" class="form-control" id="country" name="country" data-stripe="address_country">
                    </div>
                  </div>
                  <div id="step2" style="display:none;">
                    <div class="form-group col-md-3">
                      <label for="name">Name on Card:</label>
                      <input type="text" id="name" class="form-control" data-stripe="name">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="number">Card Number:</label>
                      <input type="text" id="number" class="form-control" data-stripe="number">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="cvc">CVC:</label>
                      <input type="text" id="cvc" class="form-control" data-stripe="cvc">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="exp-month">Expire Month:</label>
                      <select class="form-control" id="exp-month" data-stripe="exp_month">
                        <option value=""></option>
                        <?php for($i=1; $i<13; $i++): ?>
                          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="exp-year">Expire Year:</label>
                      <select class="form-control" id="exp-year" data-stripe="exp_year">
                        <option value=""></option>
                        <?php $yr = date("Y"); ?>
                        <?php for($i=0; $i<11; $i++): ?>
                          <option value="<?php echo $yr + $i; ?>"><?php echo $yr + $i; ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                  </div>
                  <div id="step3" style="display:none;">
                    <div class="form-group row-xs-2">
                      <h4 class="text-center">If you are confirm, click checkout button.</h4>
                    </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="check_address();" id="next_button">Next >></button>
              <button type="button" class="btn btn-primary" onclick="back_address();" id="back_button" style="display:none;"><< Back</button>
              <button type="submit" class="btn btn-primary" id="checkout_button" style="display:none;">Checkout >></button>
                </form>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<script>
  function back_address2()
  {
      jQuery('#payment-errors2').html("");
      jQuery('#step21').css("display","block");
      jQuery('#step22').css("display","none");
      jQuery('#next_button2').css("display","inline-block");
      jQuery('#back_button2').css("display","none");
      jQuery('#checkout_button2').css("display","none");
      jQuery('#checkoutModalLabel2').html("Shipping Address");
  }

  function back_address()
  {
      jQuery('#payment-errors').html("");
      jQuery('#step1').css("display","block");
      jQuery('#step2').css("display","none");
      jQuery('#step3').css("display","none");
      jQuery('#next_button').css("display","inline-block");
      jQuery('#back_button').css("display","none");
      jQuery('#checkout_button').css("display","none");
      jQuery('#checkoutModalLabel').html("Shipping Address");
  }

  function check_address2()
  {
    var data =
    {
      'full_name' : jQuery('#full_name2').val(),
      'email' : jQuery('#email2').val(),
      'phone' : jQuery('#phone2').val(),
      'street' : jQuery('#street2').val(),
      'street2' : jQuery('#street22').val(),
      'city' : jQuery('#city2').val(),
      'state' : jQuery('#state2').val(),
      'zip_code' : jQuery('#zip_code2').val(),
      'country' : jQuery('#country2').val(),
    };
    jQuery.ajax({
      url : '/retman/admin/parsers/check_address.php',
      method : "POST",
      data : data,
      success : function(data)
      {
        if (data != "passed")
        {
          jQuery('#payment-errors2').html(data);
        }
        if (data == "passed")
        {
          jQuery('#payment-errors2').html("");
          jQuery('#step21').css("display","none");
          jQuery('#step22').css("display","block");
          jQuery('#next_button2').css("display","none");
          jQuery('#back_button2').css("display","inline-block");
          jQuery('#checkout_button2').css("display","inline-block");
          jQuery('#checkoutModalLabel2').html("Confirm Order");
        }
      },
      error : function(){alert("Something went Wrong");},
    });
  }

  function check_address()
  {
    var data =
    {
      'full_name' : jQuery('#full_name').val(),
      'email' : jQuery('#email').val(),
      'phone' : jQuery('#phone').val(),
      'street' : jQuery('#street').val(),
      'street2' : jQuery('#street2').val(),
      'city' : jQuery('#city').val(),
      'state' : jQuery('#state').val(),
      'zip_code' : jQuery('#zip_code').val(),
      'country' : jQuery('#country').val(),
    };
    jQuery.ajax({
      url : '/retman/admin/parsers/check_address.php',
      method : "POST",
      data : data,
      success : function(data)
      {
        if (data != "passed")
        {
          jQuery('#payment-errors').html(data);
        }
        if (data == "passed")
        {
          jQuery('#payment-errors').html("");
          jQuery('#step1').css("display","none");
          jQuery('#step2').css("display","block");
          jQuery('#step3').css("display","block");
          jQuery('#next_button').css("display","none");
          jQuery('#back_button').css("display","inline-block");
          jQuery('#checkout_button').css("display","inline-block");
          jQuery('#checkoutModalLabel').html("Enter your Card Details");
        }
      },
      error : function(){alert("Something went Wrong");},
    });
  }

  Stripe.setPublishableKey('<?php echo STRIPE_PUBLIC; ?>');

  function stripeResponseHandler(status, response)
  {
    var $form = $('#payment-form');
    if (response.error)
    {
      $form.find('.payment-errors').text(response.error.message);
      $form.find('button').prop('disabled', false);
    }
    else
    {
      var token = response.id;
      $form.append($('<input type="hidden" name="stripeToken" />').val(token));
      $form.get(0).submit();
    }
  }

  jQuery(function($)
  {
    $('#payment-form').submit(function(event)
    {
      var $form = $(this);
      $form.find('button').prop('disabled', true);
      Stripe.card.createToken($form, stripeResponseHandler);
      return false;
    });
  });
</script>

<?php include 'includes/footer.php';  ?>

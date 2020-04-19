<?php
  require_once '../core/init.php';
  $id = $_POST['id'];
  $id = (int)$id;
  $sql = "SELECT * FROM products WHERE id = '$id'";
  $result = $db->query($sql);
  $product = mysqli_fetch_assoc($result);
  $brand_id = $product['brand'];
  $sql = "SELECT brand FROM brand WHERE id = '$brand_id'";
  $brand_query = $db->query($sql);
  $brand = mysqli_fetch_assoc($brand_query);
  $editionstring = $product['editions'];
  $editionstring = rtrim($editionstring,',');
  $edition_array = explode(',', $editionstring);
?>
<!--Details Modal-->
<?php ob_start(); ?>
  <div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" type="button" onclick="closeModal()" aria-label="close" name="button">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title text-center"><?php echo $product['title']; ?></h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <span id="modal_errors" class="bg-danger"></span>
              <div class="col-sm-6 fotorama">
                <?php $photos = explode(',',$product['image']);
                  foreach ($photos as $photo):
                ?>
                  <img src="<?php echo $photo; ?>" alt="<?php echo $product['title']; ?>" class="details img-responsive">
                <?php endforeach; ?>
              </div>
              <div class="col-sm-6">
                <h4>Details</h4>
                <p><?php echo nl2br($product['description']); ?></p>
                <hr>
                <p>Price: $<?php echo $product['price']; ?></p>
                <p>Brand: <?php echo $brand['brand']; ?></p>
                <form action="add_cart.php" method="post" id="add_product_form">
                  <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                  <input type="hidden" name="available" id="available" value="">
                  <div class="form-group">
                    <div class="col-xs-3">
                      <label for="quantity">Quantity: </label>
                      <input type="number" class="form-control" id="quantity" name="quantity" min="0">
                    </div><br><br>
                  </div><br><br>
                  <div class="form-group">
                    <label for="edition">Edition: </label>
                    <select name="edition" id="edition" class="form-control">
                      <option value=""></option>
                      <?php
                        foreach ($edition_array as $string)
                        {
                          $string_array = explode(':', $string);
                          $edition = $string_array[0];
                          $available = $string_array[1];
                          if ($available > 0)
                          {
                            echo '<option value="'.$edition.'" data-available="'.$available.'">'.$edition.' ('.$available.' Available)</option>';
                          }
                          else if ($available == 0)
                          {
                            echo '<option class="text-danger">Out of Stock</option>';
                          }
                        }
                      ?>
                    </select>
                    <h6 class="text-center text-danger">*Important: Product must be returned within 3 days.</h6>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" onclick="closeModal()">Close</button>
          <button class="btn btn-warning" onclick="add_to_cart(); return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    jQuery('#edition').change(function()
    {
      var available  = jQuery('#edition option:selected').data("available");
      jQuery('#available').val(available);
    });

    $(function ()
    {
      $('.fotorama').fotorama({'loop' : true, 'autoplay' : true});
    });

    function closeModal()
    {
      jQuery('#details-modal').modal('hide');
      setTimeout(function()
      {
        jQuery('#details-modal').remove();
        jQuery('.modal-background').remove();
      },200);
    }

  </script>
<?php echo ob_get_clean(); ?>

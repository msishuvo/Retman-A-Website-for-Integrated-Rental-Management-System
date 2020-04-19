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

  //Delete Product
  if (isset($_GET['delete']))
  {
    $id = sanitize($_GET['delete']);
    $db->query("UPDATE products SET deleted = 1 WHERE id = '$id'");
    header('LOCATION: products.php');
  }

  $dbPath = '';
  $fileExt = array();
  $allowed = array();
  $fileSize = '';
  $mimeExt = array();
  if (isset($_GET['add']) || isset($_GET['edit']))
  {
    $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
    $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
    $title = ((isset($_POST['title']) && $_POST['title'] !='')?sanitize($_POST['title']):'');
    $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
    $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
    $category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
    $price = ((isset($_POST['price']) && $_POST['price'] !='')?sanitize($_POST['price']):'');
    $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] !='')?sanitize($_POST['list_price']):'');
    $description = ((isset($_POST['description']) && $_POST['description'] !='')?sanitize($_POST['description']):'');
    $editions = ((isset($_POST['editions']) && $_POST['editions'] !='')?sanitize($_POST['editions']):'');
    $editions = rtrim($editions,',');
    $saved_image = '';

    if (isset($_GET['edit']))
    {
      $edit_id = (int)$_GET['edit'];
      $productResults = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
      $product = mysqli_fetch_assoc($productResults);
      if (isset($_GET['delete_image']))
      {
        $imgi = (int)$_GET['imgi'] - 1;
        $images = explode(',',$product['image']);
        $image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgi];
        unlink($image_url);
        unset($images[$imgi]);
        $imageString = implode(',',$images);
        $db->query("UPDATE products SET image = '$imageString' WHERE id = '$edit_id'");
        header('LOCATION: products.php?edit='.$edit_id);
      }
      $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
      $title = ((isset($_POST['title']) && $_POST['title'] !='')?sanitize($_POST['title']):$product['title']);
      $brand = ((isset($_POST['brand']) && $_POST['brand'] !='')?sanitize($_POST['brand']):$product['brand']);
      $parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
      $parentResult = mysqli_fetch_assoc($parentQ);
      $parent = ((isset($_POST['parent']) && $_POST['parent'] !='')?sanitize($_POST['parent']):$parentResult['parent']);
      $price = ((isset($_POST['price']) && $_POST['price'] !='')?sanitize($_POST['price']):$product['price']);
      $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] !='')?sanitize($_POST['list_price']):$product['list_price']);
      $description = ((isset($_POST['description']) && $_POST['description'] !='')?sanitize($_POST['description']):$product['description']);
      $editions = ((isset($_POST['editions']) && $_POST['editions'] !='')?sanitize($_POST['editions']):$product['editions']);
      $editions = rtrim($editions,',');
      $saved_image = (($product['image'] != '')?$product['image']:'');
      $dbPath = $saved_image;
    }
    $editionsArray = array();
    if (!empty($editions))
    {
      $editionString = sanitize($editions);
      $editionString = rtrim($editionString,',');
      $editionsArray = explode(',',$editionString);
      $sArray = array();
      $qArray = array();
      $tArray = array();
      foreach ($editionsArray as $ss)
      {
        $s = explode(':',$ss);
        $sArray[] = $s[0];
        $qArray[] = $s[1];
        $tArray[] = $s[2];
      }
    }
    else
    {
      $editionsArray = array();
    }

    if ($_POST)
    {
      $errors = array();

      $required = array('title', 'brand', 'price', 'parent', 'child', 'editions');
      $allowed = array('png','jpg','jpeg','gif');
      $uploadPath = array();
      $tmpLoc = array();
      foreach ($required as $field)
      {
        if ($_POST[$field]=='')
        {
          $errors[] = 'All Fields with Astrisk are required';
          break;
        }
      }
      $photoCount = count($_FILES['photo']['name']);
      if ($photoCount > 0)
      {
        for ($i=0; $i < $photoCount; $i++)
        {
          $name = $_FILES['photo']['name'][$i];
          $nameArray = explode('.',$name);
          $fileName = $nameArray[0];
          $fileExt = $nameArray[1];
          $mime = explode('/',$_FILES['photo']['type'][$i]);
          $mimeType = $mime[0];
          $mimeExt = $mime[1];
          $tmpLoc[] = $_FILES['photo']['tmp_name'][$i];
          $fileSize = $_FILES['photo']['size'][$i];
          $uploadName = md5(microtime().$i).'.'.$fileExt;
          $uploadPath[] = BASEURL.'images/products'.$uploadName;
          if ($i != 0)
          {
            $dbPath .= ',';
          }
          $dbPath .= '/retman/images/products'.$uploadName;
          if ($mimeType != 'image')
          {
            $errors[] = 'File must be an image.';
          }
          /*
          if (!in_array($fileExt, $allowed))
          {
            $errors[] = 'The file extension must be a png or jpg or jpeg or gif.';
          }*/
          if ($fileSize > 15000000)
          {
            $errors[] = 'The file size must be under 15MB.';
          }
          /*
          if ($fileExt != $mimeExt && ($mimeType == 'jpeg' && $fileExt != 'jpg'))
          {
            $errors[] = 'The file extension does not match the file.';
          }*/
        }
      }
      if (!empty($errors))
      {
        echo display_error($errors);
      }
      else
      {
        //upload file and insert into database
        if ($photoCount > 0)
        {
          for ($i=0; $i < $photoCount; $i++)
          {
            move_uploaded_file($tmpLoc[$i],$uploadPath[$i]);
          }
        }

        $insertSql = "INSERT INTO products (title, price, list_price, brand, categories, editions, image, description) VALUES ('$title', '$price', '$list_price', '$brand', '$category', '$editions', '$dbPath', '$description')";
        if (isset($_GET['edit']))
        {
          $insertSql = "UPDATE products SET title = '$title', price = '$price', list_price = '$list_price', brand = '$brand', categories = '$category', editions = '$editions', image = '$dbPath', description = '$description' WHERE id = '$edit_id'";
        }
        $db->query($insertSql);
        header('LOCATION: products.php');
      }
    }
    ?>
    <h2 class="text-center"><?php echo ((isset($_GET['edit']))?'Edit':'Add a New'); ?> Product</h2>
    <form action="products.php?<?php echo ((isset($_GET['edit']))?'edit='.$edit_id:'add=1'); ?>" method="post" enctype="multipart/form-data">
      <div class="form-group col-md-3">
        <label for="title">Title*:</label>
        <input type="text" name="title" class="form-control" id="title" value="<?php echo $title; ?>">
      </div>
      <div class="form-group col-md-3">
        <label for="brand">Brand*:</label>
        <select class="form-control" id="brand" name="brand">
          <option value="" <?=(($brand == '')? ' selected':''); ?>></option>
          <?php while($b = mysqli_fetch_assoc($brandQuery)) :?>
            <option value="<?=$b['id'];?>" <?= (($brand == $b['id'])?' selected':'') ;?>><?php echo $b['brand']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="parent">Parent Category*:</label>
        <select class="form-control" id="parent" name="parent">
          <option value="" <?=(($parent == '')? ' select':''); ?>></option>
          <?php while($p = mysqli_fetch_assoc($parentQuery)) :?>
            <option value="<?=$p['id'];?>" <?= (($parent == $p['id'])?' selected':'') ;?>><?php echo $p['category']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="child">Child Category*:</label>
        <select class="form-control" id="child" name="child">
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="price">Price*:</label>
        <input type="text" id="price" name="price" class="form-control" value="<?= $price;?>">
      </div>
      <div class="form-group col-md-3">
        <label for="list_price">List Price:</label>
        <input type="text" id="list_price" name="list_price" class="form-control" value="<?= $list_price ;?>">
      </div>
      <div class="form-group col-md-3">
        <label>Quantity & Editions*:</label>
        <button type="button"  class="btn btn-default form-control" data-toggle="modal" data-target="#editionsModal" click="jQuery('#editionsModal').modal('toggle');return false;">Quantity & Sizes</button>﻿
      </div>
      <div class="form-group col-md-3">
        <label for="editions">Editions & Quantity Preview</label>
        <input type="text" class="form-control" name="editions" id="editions" value="<?= $editions ;?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <?php if($saved_image != ''): ?>
          <?php
            $imgi = 1;
            $images = explode(',',$saved_image);
          ?>
          <?php foreach ($images as $image) : ?>
            <div class="saved-image col-md-4">
              <img src="<?php echo $image; ?>" alt="saved image" /><br>
              <a href="products.php?delete_image=1&edit=<?php echo $edit_id; ?>&imgi=<?php echo $imgi; ?>" class="text-danger">Delete Image</a>
            </div>
          <?php
            $imgi++;
            endforeach;
          ?>
        <?php else: ?>
          <label for="photo">Product Photo:</label>
          <input type="file" name="photo[]" id="photo" class="form-control" multiple>
        <?php endif; ?>
      </div>
      <div class="form-group col-md-6">
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="6" class="form-control"><?= $description ;?></textarea>
      </div>
      <div class="form-group pull-right">
        <a href="products.php" class="btn btn-default">Cancel</a>
        <input type="submit" value="<?php echo ((isset($_GET['edit']))?'Edit':'Add'); ?> Product" class="btn btn-success">
      </div>
      <div class="clearfix">
      </div>

    </form>
    <!-- Modal -->
    <div class="modal fade" id="editionsModal" tabindex="-1" role="dialog" aria-labelledby="editionsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editionsModalLabel">Edition & Quantity</h4>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <?php for($i=1; $i <= 12; $i++): ?>
                <div class="form-group col-md-2">
                  <label for="edition<?= $i;?>">Edition:</label>
                  <input type="text" name="edition<?= $i;?>" id="edition<?= $i;?>" value="<?= ((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
                </div>
                <div class="form-group col-md-2">
                  <label for="qty<?= $i;?>">Quantity:</label>
                  <input type="text" name="qty<?= $i;?>" id="qty<?= $i;?>" value="<?= ((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
                </div>
                <div class="form-group col-md-2">
                  <label for="threshold<?= $i;?>">Inventory:</label>
                  <input type="number" name="threshold<?= $i;?>" id="threshold<?= $i;?>" value="<?= ((!empty($tArray[$i-1]))?$tArray[$i-1]:'');?>" min="0" class="form-control">
                </div>
              <?php endfor; ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="updateEditions();jQuery('#editionsModal').modal('toggle'); return false;">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <?php

  }
  else
  {
    $sql = "SELECT * FROM products WHERE deleted = 0";
    $presults = $db->query($sql);
    if (isset($_GET['featured']))
    {
      $id = (int) $_GET['id'];
      $featured = (int) $_GET['featured'];
      $featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
      $db->query($featuredSql);
      header('LOCATION: products.php');
    }
    ?>
    <h2 class="text-center">Products</h2>
    <a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product</a>
    <div class="clearfix"></div>
    <hr>
    <table class="table table-bordered table-condensed table-striped">
      <thead>
        <th></th>
        <th>Product</th>
        <th>Price</th>
        <th>Category</th>
        <th>Featured</th>
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
              <a href="products.php?edit=<?php echo $product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></sapn></a>
              <a href="products.php?delete=<?php echo $product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></sapn></a>
            </td>
            <td><?php echo $product['title']; ?></td>
            <td><?php echo money($product['price']); ?></td>
            <td><?php echo $category; ?></td>
            <td>
              <a href="products.php?featured=<?php echo (($product['featured']) == 0?'1':'0'); ?>&id=<?php echo $product['id'];?>" class="btn btn-xs btn-default">
                <sapn class= "glyphicon glyphicon-<?php echo (($product['featured'] == 1)?'minus':'plus');?>">
                </span>
              </a>
              &nbsp <?php echo (($product['featured'] == 1)?'Remove from Featured Product':'Add to Featured Product'); ?>
            </td>
            <td>0</td>
          </tr>
        <?php endwhile; ?>
      </tbody>

    </table>
    <?php
  }
  include 'includes/footer.php';
?>

<script>
  jQuery('document').ready(function()
  {
    get_child_options('<?php echo $category; ?>');
  });

</script>

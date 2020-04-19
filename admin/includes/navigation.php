<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="/retman/admin/index.php" class="navbar-brand">Retman - Administrator</a>
    <ul class="nav navbar-nav">
      <!--Menu Items-->
      <li><a href="index.php" alt="home">Dashboard</a></li>      
      <li><a href="/retman/cart.php" alt="home">Shopping Cart</a></li>
      <?php if(has_permission('admin')): ?>
      <li><a href="/retman/admin/brands.php">Brands</a></li>
      <?php else: ?>
      <li><a href="/retman/admin/orders.php">Previous Orders</a></li>
      <?php endif; ?>
      <?php if(has_permission('admin')): ?>
      <li><a href="/retman/admin/categories.php">Categories</a></li>
      <?php endif; ?>
      <?php if(has_permission('admin')): ?>
      <li><a href="/retman/admin/products.php">Products</a></li>
      <?php endif; ?>
      <?php if(has_permission('admin')): ?>
      <li><a href="/retman/admin/archived.php">Archived</a></li>
      <?php endif; ?>
      <?php if(has_permission('admin')): ?>
      <li><a href="/retman/admin/users.php">Users</a></li>
      <?php endif; ?>
      <li><a href="/retman/index.php" alt="home">Visit Site</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?php echo $user_data['first']." "; ?>!<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li>
            <a href="/retman/admin/change_password.php">Change Password</a>
          </li>
          <li>
            <a href="/retman/admin/logout.php">Logout</a>
          </li>
        </ul>
      </li>
      <!--
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category']; ?><span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="#"></a></li>
        </ul>
      </li>
      -->
    </ul>
  </div>
</nav>

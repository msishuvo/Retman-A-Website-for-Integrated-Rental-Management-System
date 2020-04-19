<?php
  $sql = "SELECT * FROM categories WHERE parent = 0";
  $pquery = $db->query($sql);
?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="index.php" class="navbar-brand">Retman - An Integrated Rental Management Module</a>
    <ul class="nav navbar-nav">
      <?php while ($parent = mysqli_fetch_assoc($pquery)) : ?>
        <?php
          $parent_id = $parent['id'];
          $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
          $cquery = $db->query($sql2);
        ?>
        <!--Menu Items-->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category']; ?><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <?php while ($child = mysqli_fetch_assoc($cquery)) : ?>
              <li><a href="category.php?cat=<?php echo $child['id']; ?>"><?php echo $child['category']; ?></a></li>
            <?php endwhile; ?>
          </ul>
        </li>
      <?php endwhile; ?>
      <?php if(is_logged_in()): ?>
        <li class="divider-vertical"><a href="/retman/admin/index.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
      <?php endif; ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li>
        <?php if (is_logged_in()): ?>
          <button class="btn btn-md btn-warning navbar-btn"><a href="/retman/admin/logout.php">Logout</a></button>
        <?php else: ?>
          <button class="btn btn-md btn-warning navbar-btn"><a href="/retman/admin/login.php">Login</a></button>
        <?php endif; ?>
      </li>
    </ul>
  </div>
</nav>

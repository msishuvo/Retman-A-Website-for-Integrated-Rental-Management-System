<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/retman/core/init.php';
  unset($_SESSION['SBUser']);
  header('LOCATION: /retman/index.php');
?>

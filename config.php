<?php
  define('BASEURL',$_SERVER['DOCUMENT_ROOT'].'/retman/');
  define('CART_COOKIE', 'SBWI72UClkwiqzz2tryk');
  define('CART_COOKIE_EXPIRE', time() + (86400*30));
  define('TAXRATE',0.015);

  define('CURRENCY', 'usd');
  define('CHECKOUTMODE', 'TEST');//CHANGE TEST TO LIVE

  if (CHECKOUTMODE == 'TEST')
  {
    define('STRIPE_PRIVATE', 'sk_test_5ZbkJ008qkQQ6pYwL1zJCsac');
    define('STRIPE_PUBLIC', 'pk_test_GuI0tBjzVR6SbzQrUlXMgIKW');
  }

  if (CHECKOUTMODE == 'LIVE')
  {
    define('STRIPE_PRIVATE', '');
    define('STRIPE_PUBLIC', '');
  }
?>

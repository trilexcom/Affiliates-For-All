<?php /*

Copyright (c) 2008 Metathinking Ltd.

This file is part of Affiliates For All.

Affiliates For All is free software: you can redistribute it and/or
modify it under the terms of the GNU General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

Affiliates For All is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public License
along with Affiliates For All.  If not, see
<http://www.gnu.org/licenses/>.

*/

require_once 'dummycart.inc';
place_order();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN";
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Test Shopping Cart</title>
</head>
<body>
  <h1>Order Placed</h1>

  <p>Order <?php echo $_GET['orderno'] ?> for $<?php echo $_GET['quantity'] * 5?> has been placed.

  <?php if($new_order) { ?>
    (This is a new order.)
  <?php } else { ?>
    (This order has already been sent to the affiliate system, so it will not be sent again.)
  <?php } ?>

  <p>You can now <a href="ship.php?orderno=<?php echo $_GET['orderno'] ?>">ship the order</a> or <a href="cancel.php?orderno=<?php echo $_GET['orderno'] ?>">cancel the order</a>.</p>

  </p>
</body>
</html>

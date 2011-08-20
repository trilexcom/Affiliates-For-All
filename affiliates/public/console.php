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

require_once '../lib/bootstrap.php';

$template = new Template('console');
$template->set('title', 'Affiliates For All: Affiliate Console');

$template->set('currency', $currency);
$template->set('link',
    $store_home.'?'.$affiliate_get_parameter.'='.$_SESSION['affiliate_id']);
$template->set('id', $_SESSION['affiliate_id']);

$db = new Database();
$stmt = $db->get_pdo()->query(
    'select sum(total), sum(commission) from orders where affiliate = ' .
    $_SESSION['affiliate_id']);

$row = $stmt->fetch();
$template->set('total_orders', $db->format_currency($row[0]));
$template->set('total_commission', $db->format_currency($row[1]));

$template->render();

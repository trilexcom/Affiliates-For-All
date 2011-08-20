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

$template = new Template('overview');
$template->set('title', "$affiliate_programme_name: Overview");

$template->set('currency', $currency);
$link = $store_home . '?' . $affiliate_referrer_parameter . '=' .
    $_SESSION['affiliate_id'];

$template->set('link', $link);
$template->set('link2', $link . '&' . $affiliate_data_parameter . '=your_data');

$template->set('id', $_SESSION['affiliate_id']);

$db = new Database();

$stmt = $db->get_pdo()->query(
    'select total, commission from affiliate_totals where affiliate = ' .
    $_SESSION['affiliate_id']);

$row = $stmt->fetch();
$template->set('total_orders', $row ? $db->format_currency($row[0]) : '0.00');
$template->set('total_commission',
    $row ? $db->format_currency($row[1]) : '0.00');

$pay_stmt = $db->get_pdo()->query(
    'select sum(amount) from payments where affiliate = ' .
        $_SESSION['affiliate_id']);

$pay_row = $pay_stmt->fetch();
$template->set('total_payments', $db->format_currency($pay_row[0]));
$template->set('total_payable', $db->format_currency($row[1] - $pay_row[0]));

$template->render();

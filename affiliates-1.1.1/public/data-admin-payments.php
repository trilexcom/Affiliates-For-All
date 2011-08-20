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

$admin_required = TRUE;
require_once '../lib/bootstrap.php';

$db = new Database();
$stmt = $db->get_pdo()->prepare(
    'select id, paypal, local_username, (
        select sum(commission) from orders
        where orders.affiliate=affiliates.id
            and orders.status in (\'refund\', \'refunded\', \'shipped\')
            and orders.date_entered < :date + interval 1 day
        ) as commission, (
            select sum(amount) from payments
            where payments.affiliate=affiliates.id
        ) as already_paid from affiliates');

$date = Database::format_date($_GET['end']);
$stmt->execute(array('date' => $date));
$rows = $stmt->fetchAll();

header('Content-Type: text/plain');
foreach($rows as $row) {
    $amount = sprintf('%2.2f', $row[3] - $row[4]);
    $id = preg_replace('/[^A-Za-z0-9]/', '', $row[2]);
    if(strlen($id) > 15)
        $id = substr($id, 0, 15);
    if($amount > 0)
        echo "${row[1]}\t$amount\t$currency_code\taff_${row[0]}_$id\t" .
            "Your affiliate commission to $date.  Thank you.\n";
}

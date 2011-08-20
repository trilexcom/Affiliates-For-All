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

$payments_per_page = 20;

function format_date($date) {
    $matches = array();
    $result = preg_match('/^([0-9]{4})([0-9]{2})([0-9]{2})$/', $date, $matches);

    // This shouldn't happen, but if someone tampers with the query string, we
    // shouldn't just crash:
    if($result < 1)
        return '2008-01-01';

    return $matches[1] . '-' . $matches[2] . '-' . $matches[3];
}

$db = new Database();
$stmt = $db->get_pdo()->prepare(
    'select * from payments where affiliate = :affiliate and ' .
        'date_entered > :start and date_entered < :end + interval 1 day ' .
        'order by date_entered limit ' . $payments_per_page . ' ' .
        'offset ' . $payments_per_page * $_GET['page']);

$restrictions = array(
    'affiliate' => $_SESSION['affiliate_id'],
    'start' => format_date($_GET['start']),
    'end' => format_date($_GET['end']));

$stmt->execute($restrictions);
$rows = $stmt->fetchAll();
$result = array();
$html = '';

$html .= '<tr>';
$html .= '  <th>Amount</th>';
$html .= '  <th>Date Payment Sent</th>';
$html .= '</tr>';

foreach($rows as $row) {
    $html .= '<tr>';
    $html .= "  <td>${row['amount']}</td>";
    $date = strtotime($row['date_entered']);
    $date = strftime('%b %d %Y', $date);
    $html .= "  <td>$date</td>";
    $html .= '</tr>';
}

$result['html'] = $html;

$stmt = $db->get_pdo()->prepare(
    'select count(*) from payments where affiliate = :affiliate and ' .
        'date_entered > :start and date_entered < :end + interval 1 day');

$stmt->execute($restrictions);
$row = $stmt->fetch();
$pages = (int) ceil($row[0] / $payments_per_page);
$result['pages'] = $pages;

echo json_encode($result);

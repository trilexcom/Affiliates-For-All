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
require_once 'gdgraph.php';

$days_back = 5;
$days_word = '5';
switch($_GET['days']) {
case '7':
    $days_back = 7;
    $days_word = gettext('seven');
    break;
case '30':
    $days_back = 30;
    $days_word = gettext('thirty');
    break;
case '90':
    $days_back = 90;
    $days_word = gettext('ninety');
    break;
}

$variable = 'Something';
$column = 'total';
switch($_GET['variable']) {
case 'commission':
    $variable = 'Commission';
    $column = 'commission';
    break;
case 'orders':
    $variable = 'Orders';
    $column = 'count';
    break;
}

if(isset($_GET['fromcache'])) {
    $db = new Database();
    $stmt = $db->get_pdo()->query(
        'select * from daily_orders where affiliate = ' .
        $_SESSION['affiliate_id'] . ' and ' .
        'date_sub(curdate(), interval 90 day) <= date_entered');

    $rows = $stmt->fetchAll();
    $days = array();
    foreach($rows as $row)
        $days[$row['date_entered']] = $row;

    $_SESSION['order_graph_cache'] = $days;
} else {
    $days = $_SESSION['order_graph_cache'];
}

$data = array();
for($day = 1 - $days_back; $day <= 0; $day++) {
    $timestamp = time() + $day * 60 * 60 * 24;
    $date_str = date('Y-m-d', $timestamp);
    $value = isset($days[$date_str]) ? $days[$date_str][$column] :0.0;
    $bar = array($value, 0xc0, 0xe0, 0xff);
    $bar_highlight = array($value, 0x80, 0xc0, 0xff);

    switch($days_back) {
    case 7:
        $key = date('D', $timestamp);
        break;
    case 30:
        $key = $day;
        if(date('w', $timestamp) == 1
            && $day != 0 /* If we print this label it gets chopped off. */) {

            $key = date('M j', $timestamp);
            $bar = $bar_highlight;
        }

        break;
    case 90:
        $key = $day;
        if(date('j', $timestamp) == 1
            && $day < -3 /* If we print these labels they get chopped off. */) {

            $key = date('M j', $timestamp);
            $bar = $bar_highlight;
        }

        break;
    }

    $data[$key] = $bar;
}

class Graph extends GDGraph {
    function _get_specs($data, $type) {
        $result = parent::_get_specs($data, $type);
        $max = $result['max_value'];
        $max = (int) ceil($max / 10.0) * 10;
        return array('min_value' => 0, 'max_value' => $max);
    }
}
$t_variable = gettext($variable);
$t_last = gettext('last');
$t_days = gettext('days');

$gdg = new Graph(250, 250, "$t_variable ($t_last $days_word $t_days)",
    255, 255, 255,
    0, 0, 0,
    0, 0, 0,
    false);

$gdg->bar_graph($data, '', '', $days_back == 7 ? 80 : 100, 5);

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

$logon_not_required = TRUE;
require_once '../lib/bootstrap.php';

function get_cookie($method, $args) {
    global $rpc_secret, $affiliate_referrer_parameter,
        $affiliate_data_parameter, $affiliate_cookie, $cookie_lifetime;

    $secret = $args[0];
    $get =& $args[1];
    $cookie =& $args[2];

    if($secret != $rpc_secret)
        return array();

    if(isset($get[$affiliate_referrer_parameter])) {
        $data = $get[$affiliate_referrer_parameter] . ',';
        if(isset($get[$affiliate_data_parameter]))
            $data .= substr($get[$affiliate_data_parameter], 0, 256);

        return array($affiliate_cookie, $data,
            time() + 60 * 60 * 24 * $cookie_lifetime, '/');
    } else {
        return array();
    }
}

function order_placed($method, $args) {
    global $rpc_secret, $affiliate_cookie, $commission_percent,
        $commission_fixed, $lifetime_revenue_share;

    $secret = $args[0];
    $get =& $args[1];
    $cookie =& $args[2];
    $order_no = $args[3];
    $amount = $args[4];
    $email = $args[5];
    $name = $args[6];
    $customer_id = $args[7];

    if($secret != $rpc_secret)
        return;

    $affiliate = null;
    $db = new Database();

    if($lifetime_revenue_share) {
        $stmt = $db->get_pdo()->prepare(
            'select affiliate, affiliate_data from orders ' .
            'where customer_id = :customer_id ' .
            'order by date_entered desc limit 1');

        $stmt->execute(array('customer_id' => $customer_id));
        $row = $stmt->fetch();
        if($row)
            $affiliate = $row;
    }

    if($affiliate == null && isset($cookie[$affiliate_cookie]))
        $affiliate = preg_split('/,/', $cookie[$affiliate_cookie], 2);

    if($affiliate != null) {
        $commission = $amount * $commission_percent / 100 + $commission_fixed;

        $row = $db->get_row_by_key('affiliates', 'id', $affiliate[0]);
        if($row) {
            $data = array(
                'id' => $order_no,
                'affiliate' => $affiliate[0],
                'affiliate_data' => $affiliate[1],
                'total' => $amount,
                'commission' => $commission,
                'status' => 'new',
                'customer_email' => $email,
                'customer_name' => $name,
                'customer_id' => $customer_id);

            $db->insert('orders', $data);
        }
    }
}

function order_shipped($method, $args) {
    global $rpc_secret;

    $secret = $args[0];
    $order_no = $args[1];

    if($secret != $rpc_secret)
        return;

    $db = new Database();
    $order = $db->get_row_by_key('orders', 'id', $order_no);
    if($order['status'] == 'new') {
        $db->update_by_key('orders', 'id', $order_no,
            array('status' => 'shipped'));
    }
}

function order_cancelled($method, $args) {
    global $rpc_secret;

    $secret = $args[0];
    $order_no = $args[1];

    if($secret != $rpc_secret)
        return;

    $db = new Database();
    $order = $db->get_row_by_key('orders', 'id', $order_no);
    if($order['status'] == 'new') {
        $db->update_by_key('orders', 'id', $order_no,
            array('status' => 'cancelled'));
    } else if($order['status'] == 'shipped') {
        $db->update_by_key('orders', 'id', $order_no,
            array('status' => 'refunded'));

        $new_order = array(
            'id' => $order['id'] . '-r',
            'affiliate' => $order['affiliate'],
            'affiliate_data' => $order['affiliate_data'],
            'status' => 'refund',
            'customer_email' => $order['customer_email'],
            'customer_name' => $order['customer_name'],
            'total' => -$order['total'],
            'commission' => -$order['commission']);

        $db->insert('orders', $new_order);
    }
}

$server = xmlrpc_server_create();
xmlrpc_server_register_method($server, 'get_cookie', 'get_cookie');
xmlrpc_server_register_method($server, 'order_placed', 'order_placed');
xmlrpc_server_register_method($server, 'order_shipped', 'order_shipped');
xmlrpc_server_register_method($server, 'order_cancelled', 'order_cancelled');
echo xmlrpc_server_call_method($server, $HTTP_RAW_POST_DATA, null);

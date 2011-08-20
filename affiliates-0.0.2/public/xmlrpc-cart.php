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

function get_cookie($method, $args) {
    global $rpc_secret, $affiliate_get_parameter, $affiliate_cookie,
        $cookie_lifetime;

    $secret = $args[0];
    $get =& $args[1];
    $cookie =& $args[2];

    if($secret != $rpc_secret)
        return array();

    if(isset($get[$affiliate_get_parameter])) {
        return array($affiliate_cookie, $get[$affiliate_get_parameter],
            time() + 60 * 60 * 24 * $cookie_lifetime, '/');
    } else {
        return array();
    }
}

function order_placed($method, $args) {
    global $rpc_secret, $affiliate_cookie, $commission_percent,
        $commission_fixed;

    $secret = $args[0];
    $get =& $args[1];
    $cookie =& $args[2];
    $order_no = $args[3];
    $amount = $args[4];

    if($secret != $rpc_secret)
        return;

    if(isset($cookie[$affiliate_cookie])) {
        $affiliate = $cookie[$affiliate_cookie];

        $db = new Database();

        $commission = $amount * $commission_percent / 100 + $commission_fixed;
        $data = array(
            'id' => $order_no,
            'affiliate' => $affiliate,
            'total' => $amount,
            'commission' => $commission);

        $db->insert('orders', $data);
    }
}

$server = xmlrpc_server_create();
xmlrpc_server_register_method($server, 'get_cookie', 'get_cookie');
xmlrpc_server_register_method($server, 'order_placed', 'order_placed');
echo xmlrpc_server_call_method($server, $HTTP_RAW_POST_DATA, null);

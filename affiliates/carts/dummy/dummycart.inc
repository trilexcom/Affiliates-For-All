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

require_once 'config.inc';
session_start();

function affiliate_call($method, $params) {
    global $rpc_secret, $affiliate_base;

    array_unshift($params, $rpc_secret);
    $request = xmlrpc_encode_request($method, $params);
    $context = stream_context_create(array('http' => array(
        'method' => "POST",
        'header' => "Content-Type: text/xml",
        'content' => $request)));

    $file = file_get_contents("$affiliate_base/xmlrpc-cart.php",
        false, $context);

    $response = xmlrpc_decode($file);

    return $response;
}

function get_cookie() {
    $response = affiliate_call('get_cookie', array($_GET, $_COOKIE));
    if (xmlrpc_is_fault($response)) {
        trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
    } else {
        if(count($response) > 0)
            call_user_func_array('setcookie', $response);
    }
}

function place_order() {
    global $new_order;

    // Don't place orders more than once.

    $orders = isset($_SESSION['orders']) ? $_SESSION['orders'] : array();
    if(isset($orders[$_GET['orderno']])) {
        $new_order = FALSE;
    } else {
        $new_order = TRUE;
        $orders[$_GET['orderno']] = TRUE;
        $_SESSION['orders'] = $orders;

        affiliate_call('order_placed', array($_GET, $_COOKIE, $_GET['orderno'],
            (string) ($_GET['quantity'] * 5)));
    }
}

get_cookie();

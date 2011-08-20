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

class Afa_Observer {
    private $url, $secret;

    public function __construct() {
        $this->url = Mage::getStoreConfig('afa/afa/url');
        $this->secret = Mage::getStoreConfig('afa/afa/secret');
    }

    private function affiliate_call($method, $params) {
        array_unshift($params, $this->secret);
        $request = xmlrpc_encode_request($method, $params);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, "{$this->url}/xmlrpc-cart.php");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        $contents = curl_exec($curl);
        curl_close($curl);

        if (!$contents)
            return FALSE;

        return xmlrpc_decode($contents);
    }

    public function set_affiliate_cookie($observer) {
        $response = $this->affiliate_call('get_cookie', array($_GET, $_COOKIE));
        if($response && !xmlrpc_is_fault($response) && count($response) > 0)
            call_user_func_array('setcookie', $response);

        return $this;
    }

    public function order_placed($observer) {
        $event = $observer->getEvent();
        $order = $event->getOrder();

        $this->affiliate_call('order_placed', array($_GET, $_COOKIE,
            (string) $order->getRealOrderId(),
            (string) $order->getData('subtotal'),
            $order->getData('customer_email'),
            $order->getCustomerName()));

        return $this;
    }

    public function model_saved($observer) {
        $event = $observer->getEvent();
        $order = $event->getOrder();

        if($order->getStatusLabel() == "Complete") {
            $this->affiliate_call('order_shipped',
                array((string) $order->getRealOrderId()));
        }

        return $this;
    }
}

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

class Database {
    public static $order_fields = 'id*, affiliate*, status*,
        customer_id, customer_name, customer_email, total*, commission*,
        date_entered*, affiliate_data';
    public static $order_headings = 'Order Number, Affiliate, Status,
        Cust ID, Cust Name, Cust Email, Total, Comm, Order Date,
        Campaign Data';
    public static $order_sizes = '15, 8, 8, 10, 20, 20, 6, 6, 10, 20';

    public static $payment_fields = 'id, affiliate*, amount*, date_entered*';
    public static $payment_headings = 'Payment Number, Affiliate, Amount,
        Payment Date';
    public static $payment_sizes = '6, 8, 6, 10';

    public static $affiliate_fields = 'id, local_username*, local_password*,
        title, first_name, last_name, email,
        address1, address2, address3, address4, postcode, country, phone,
        paypal, wizard_complete*, administrator*';
    public static $affiliate_headings = 'Affiliate Number, Username, Password,
        Title, First Name, Last Name, Email,
        Address 1, Address 2, Address 3, Address 4, Post/Zip Code, Country,
        Phone,
        Paypal, Wizard Complete, Administrator';
    public static $affiliate_sizes = '6, 20, 20, 4, 10, 10, 20,
        10, 10, 10, 10, 10, 20,
        15,
        20, 1, 1';

    public static $affiliate_short_fields = 'id, local_username,
        title, first_name, last_name, email';
    public static $affiliate_short_headings = 'Affiliate Number, Username,
        Title, First Name, Last Name, Email';

    private static $triggers = array();

    private $db;

    public static function format_currency($currency) {
        return sprintf('%2.2f', $currency);
    }

    public static function format_date($date) {
        $matches = array();
        $result = preg_match('/^([0-9]{4})([0-9]{2})([0-9]{2})$/',
            $date, $matches);

        // This shouldn't happen, but if someone tampers with the query string,
        // we shouldn't just crash:
        if($result < 1)
            return '2008-01-01';

        return $matches[1] . '-' . $matches[2] . '-' . $matches[3];
    }

    public static function format_date_time($date) {
        $matches = array();
        $result = preg_match('/^([0-9]{8})([0-9]{2})([0-9]{2})([0-9]{2})$/',
            $date, $matches);

        return Database::format_date($matches[1]) . ' ' .
            $matches[2] . ':' . $matches[3] . ':' . $matches[4];
    }

    public static function register_trigger(&$trigger) {
        array_push(Database::$triggers, $trigger);
    }

    public function __construct() {
        $this->db = $this->get_connection();
    }

    private function get_connection() {
        global $database_dsn, $database_username, $database_password;
	return new PDO($database_dsn, $database_username, $database_password,
	    array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
    }

    public function get_pdo() {
        return $this->db;
    }

    public function get_rows($table, $sort) {
        $stmt = $this->db->query("select * from $table order by $sort");
        return $stmt->fetchAll();
    }

    public function get_rows_by_key($table, $field, $value) {
        $stmt = $this->db->prepare(
            "select * from $table where $field = :value");

        $stmt->execute(array('value' => $value));
        return $stmt->fetchAll();
    }

    public function get_row_by_key($table, $field, $value) {
        $rows = $this->get_rows_by_key($table, $field, $value);

        if(count($rows) == 0)
            return null;

        return $rows[0];
    }

    public function insert($table, $values) {
        $key_list = '';
        $value_list = '';
        $comma = '';

        foreach(Database::$triggers as $trigger) {
            $trigger->insert($this, $table, $values);
        }

        foreach(array_keys($values) as $key) {
            $key_list = "$key_list$comma$key";
            $value_list = "$value_list$comma:$key";
            $comma = ', ';
        }

        $insert = "insert into $table ($key_list) values ($value_list)";
        $stmt = $this->db->prepare($insert);
        return $stmt->execute($values);
    }

    public function update_by_key($table, $field, $value, $values) {
        $updates = '';
        $comma = '';

        foreach(Database::$triggers as $trigger) {
            $trigger->update($this, $table, $field, $value, $values);
        }

        foreach(array_keys($values) as $key) {
            $updates = "$updates$comma$key=:$key";
            $comma = ', ';
        }

        $update_list = $values;
        $update_list['value'] = $value;

        $stmt = $this->db->prepare(
            "update $table set $updates where $field = :value");

        return $stmt->execute($update_list);
    }

    public function delete_by_key($table, $field, $value) {
        $stmt = $this->db->prepare(
            "delete from $table where $field = :value");

        $stmt->execute(array('value' => $value));
    }
}

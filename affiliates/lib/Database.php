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
    private $db;

    public static function format_currency($currency) {
        if($currency == '')
            return '0.00';

        return $currency;
    }

    public function __construct() {
        $this->db = $this->get_connection();
    }

    private function get_connection() {
        global $database_dsn, $database_username, $database_password;
        return new PDO($database_dsn, $database_username, $database_password);
    }

    public function get_pdo() {
        return $this->db;
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
        foreach(array_keys($values) as $key) {
            $key_list = "$key_list$comma$key";
            $value_list = "$value_list$comma:$key";
            $comma = ', ';
        }

        $insert = "insert into $table ($key_list) values ($value_list)";
        $stmt = $this->db->prepare($insert);
        return $stmt->execute($values);
    }
}

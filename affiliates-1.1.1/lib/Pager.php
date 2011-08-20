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

class Pager {
    const entries_per_page = 20;
    private $table, $fields, $full_fields, $column_heads, $db, $date_format,
        $affiliate_restriction, $date_restriction, $id_restriction, $id,
        $admin_mode, $editable, $order_by;

    public function __construct($table, $fields, $column_heads,
            $full_fields = '') {
        $this->table = $table;
        $this->fields = preg_split('/\s*,\s*/',
            preg_replace('/\\*/', '', $fields));

        if($full_fields == '') {
            $this->full_fields = $this->fields;
        } else {
            $this->full_fields = preg_split('/\s*,\s*/',
                preg_replace('/\\*/', '', $full_fields));
        }

        $this->column_heads = preg_split('/\s*,\s*/', $column_heads);
        $this->db = new Database();
        $this->date_format = '%b %d %Y %H:%M:%S';
        $this->affiliate_restriction = 'affiliate = :affiliate and ';
        $this->date_restriction = 'date_entered > :start and ' .
            'date_entered < :end + interval 1 day and ';
        $this->id_restriction = '';
        $this->id = '';
        $this->order_by = 'date_entered';
        $this->admin_mode = FALSE;
    }

    protected function get_restrictions() {
        $restrictions = array();

        if(!$this->admin_mode)
            $restrictions['affiliate'] = $_SESSION['affiliate_id'];

        if($this->date_restriction != '') {
            $restrictions['start'] = Database::format_date($_GET['start']);
            $restrictions['end'] = Database::format_date($_GET['end']);
        }

        if($this->id_restriction != '')
            $restrictions['id'] = $this->id;

        return $restrictions;
    }

    protected function get_data_query($offset, $limit) {
        // All the ...-restriction strings end with 'and'.  To avoid having a
        // trailing 'and' we add a final condition 'true' on the end of the
        // conditions.  This means that the list of conditions will always end
        // '... and true'.

        return
            'select * from '.$this->table.' where ' .
                $this->affiliate_restriction .
                $this->date_restriction .
                $this->id_restriction .
                'true ' .
                'order by '.$this->order_by.' ' .
                'limit '.$limit.' offset '.$offset;
    }

    protected function get_count_query() {
        return
            'select count(*) from '.$this->table.' where ' .
                $this->affiliate_restriction .
                'date_entered > :start and ' .
                'date_entered < :end + interval 1 day';
    }

    protected function execute($query, $params) {
        if(count($params) == 0) {
            return $this->db->get_pdo()->query($query);
        } else {
            $stmt = $this->db->get_pdo()->prepare($query);
            $stmt->execute($params);
            $rows = $stmt->fetchAll();
            return $rows;
        }
    }

    public function set_date_format($date_format) {
        $this->date_format = $date_format;
    }

    public function set_admin_mode() {
        $this->affiliate_restriction = '';
        $this->admin_mode = TRUE;
    }

    public function set_editable() {
        $this->editable = TRUE;
    }

    public function set_order_by($order_by) {
        $this->order_by = $order_by;
    }

    public function disable_date_restriction() {
        $this->date_restriction = '';
    }

    public function download() {
        header('Content-Type: text/plain');
        $tab = '';
        foreach($this->full_fields as $field) {
            echo $tab . $field;
            $tab = "\t";
        }
        echo "\n";

        $stmt = $this->get_data_query(0, 1000000000);
        $rows = $this->execute($stmt, $this->get_restrictions());

        foreach($rows as $row) {
            $tab = '';
            foreach($this->full_fields as $field) {
                echo $tab . $row[$field];
                $tab = "\t";
            }
            echo "\n";
        }
    }

    public function json($page_number) {
        $result = array();
        $html = '';

        $html .= '<tr>';
        foreach($this->column_heads as $field)
            $html .= "<th>$field</th>";

        if($this->editable)
            $html .= '<td>&nbsp;</td>';

        $html .= '</tr>';

        $stmt = $this->get_data_query(
            self::entries_per_page * $page_number, self::entries_per_page);

        $rows = $this->execute($stmt, $this->get_restrictions());
        foreach($rows as $row) {
            $html .= '<tr>';
            foreach($this->fields as $field) {
                if($field == 'date_entered') {
                    $date = strtotime($row[$field]);
                    $date = strftime($this->date_format, $date);
                    $html .= "  <td>$date</td>";
                } else {
                    $html .= "<td>${row[$field]}</td>";
                }
            }

            if($this->editable) {
                $html .= '<td>';
                $html .= "<img id='edit_${row[0]}' class='edit' " .
                    "src='images/edit.png'/>";
                $html .= "<img id='delete_${row[0]}' class='delete' " .
                    "src='images/remove.png'/>";
                $html .= '</td>';
            }

            $html .= '</tr>';
        }

        $result['html'] = $html;

        $stmt = $this->get_count_query();
        $rows = $this->execute($stmt, $this->get_restrictions());
        $pages = (int) ceil($rows[0][0] / self::entries_per_page);
        $result['pages'] = $pages == 0 ? 1 : $pages;

        echo json_encode($result);
    }

    public function json_single($id) {
        $result = array();

        $this->affiliate_restriction = '';
        $this->date_restriction = '';
        $this->id_restriction = $this->fields[0] . ' = :id and ';
        $this->id = $id;

        $stmt = $this->get_data_query(0, 1000000000);
        $rows = $this->execute($stmt, $this->get_restrictions());

        foreach($this->full_fields as $field)
            $result[$field] = $rows[0][$field];

        echo json_encode($result);
    }

    public function write($values) {
        $filtered_values = array();

        foreach($this->full_fields as $field)
            $filtered_values[$field] = $values[$field];

        if(isset($values['key'])) {
            $this->db->update_by_key($this->table, 'id', $values['key'],
                $filtered_values);
        } else {
            $this->db->insert($this->table, $filtered_values);
        }

        echo json_encode(TRUE);
    }

    public function delete($id) {
        $this->db->delete_by_key($this->table, 'id', $id);
        echo json_encode(TRUE);
    }
}

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

class Orders extends Template {
    private function make_status_selector($details) {
        $db = new Database();
        $rows = $db->get_rows('order_status', 'id');
        echo '<select id="details_'.$details[0].'" class="detailsfield">';
        foreach($rows as $row) {
            echo '<option value="'.$row[0].'">'.$row[0].'</option>';
        }
        echo '</select>';

        if($details[3])
            echo ' *';
    }

    protected function make_data_field($details) {
        if($details[0] == 'status') {
            echo $this->make_status_selector($details);
        } else if($details[0] == 'date_entered') {
            echo $this->make_date_selector($details, True);
        } else {
            parent::make_data_field($details);
        }
    }
}

$template = new Orders('admin-orders');

$template->set('fields', new Editor(
    Database::$order_fields, Database::$order_headings,
    Database::$order_sizes));

$template->set('title', 'Affiliates For All: All Orders');
$template->render();

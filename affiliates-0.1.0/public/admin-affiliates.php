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

class Affiliates extends Template {
    private function make_country_selector($details) {
        $db = new Database();
        $rows = $db->get_rows('countries', 'name');
        echo '<select id="details_'.$details[0].'" class="detailsfield">';
        foreach($rows as $row) {
            echo '<option value="'.$row[0].'">'.$row[1].'</option>';
        }
        echo '</select>';

        if($details[3])
            echo ' *';
    }

    protected function make_data_field($details) {
        if($details[0] == 'country') {
            $this->make_country_selector($details);
        } else if($details[0] == 'wizard_complete'
                || $details[0] == 'administrator') {
            $this->make_checkbox_selector($details);
        } else {
            parent::make_data_field($details);
        }
    }
}

$template = new Affiliates('admin-affiliates');

$template->set('fields', new Editor(
    Database::$affiliate_fields, Database::$affiliate_headings,
    Database::$affiliate_sizes));

$template->set('title', 'Affiliates For All: Affiliates');
$template->render();

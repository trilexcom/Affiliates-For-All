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

class Template {
    private $file, $show_menu, $variables, $admin;

    public static function get_ajax_key() {
        // This key is quoted in AJAX requests to protect against CSRF attacks.
        // We could use the session ID on its own, but hashing it provides
        // "defence in depth": if someone manages to find out the AJAX key,
        // they at least can't determine the session cookie.
        return sha1(session_id());
    }

    public static function check_ajax_key() {
        if($_GET['csrfkey'] != Template::get_ajax_key()) {
            echo 'CSRF check failed.';
            exit();
        }
    }

    public function __construct($file) {
        global $admin_required;

        $this->file = $file;
        $this->show_menu = true;
        $this->variables = array();
        $this->admin = isset($admin_required);

        $db = new Database();
        $result = $db->get_pdo()->query('select count(*) from banners');
        $result = $result->fetch();
        $this->offer_banners = $result[0] > 0;

        $this->set('key', Template::get_ajax_key());
    }

    public function suppress_menu() {
        $this->show_menu = false;
    }

    public function set($key, $value) {
        $this->variables[$key] = $value;
    }

    protected function make_date_selector($details, $time) {
        echo '<div id="details_'.$details[0].'" ' .
            'class="detailsdate detailsfield">';

        echo '<input class="date" type="text" size="12"> ';

        if($time) {
            echo '<input class="hours" type="text" size="2">:';
            echo '<input class="minutes" type="text" size="2">:';
            echo '<input class="seconds" type="text" size="2">';
        }

        if($details[3])
            echo ' *';

        echo '</div>';
    }

    protected function make_checkbox_selector($details) {
        echo '<input id="details_'.$details[0].'" class="detailsfield" ' .
            'type="checkbox">';

        if($details[3])
            echo ' *';
    }

    protected function make_data_field($details) {
        echo '<input id="details_'.$details[0].'" class="detailsfield" ' .
            'type="text" size="'.$details[2].'">';

        if($details[3])
            echo ' *';
    }

    public function render() {
        // PHP oddity: when an array is cast to an object, its keys become
        // the object's members.  This is very convenient because the templates
        // can then use the $v->foo syntax rather than the more clumsy
        // $v['foo'].

        $v = (object) $this->variables;

        require 'head.phtml';
        require $this->file . '.phtml';
        require 'tail.phtml';
    }
}

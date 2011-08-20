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

$db = new Database();
$template = new Template('admin-banners');

$banners = __('Banners');
$template->set('title', "$affiliate_programme_name: $banners");
$template->set('start', 'normal');

if(isset($_FILES['file'])) {
    $template->set('new_file', $_FILES['file']['name']);
    $template->set('new_name', $_POST['new_name']);
    $template->set('new_linktarget', $_POST['new_linktarget']);

    $row = $db->get_row_by_key('banners', 'name', $_POST['new_name']);
    if($row != null) {
        $template->set('start', 'duplicate');
    } else {
        $image = file_get_contents($_FILES['file']['tmp_name']);
        $db->insert('banners', array(
            'name' => $_POST['new_name'],
            'link_target' => $_POST['new_linktarget'],
            'enabled' => 1,
            'banner' => $image,
            'mime_type' => $_FILES['file']['type']));

        $template->set('start', 'success');
    }
} else {
    $template->set('new_file', '');
    $template->set('new_name', '');
    $template->set('new_linktarget', '');
}

$rows = $db->get_pdo()->query(
    'select id, name, link_target, enabled from banners order by id');

$rows = $rows->fetchAll();
$template->set('banners', $rows);

$slash = substr($store_home, -1) == '/' ? '' : '/';
$template->set('store_home', $store_home . $slash);

$template->render();

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

$logon_not_required = TRUE;
require_once '../lib/bootstrap.php';

Template::check_ajax_key();

$db = new Database();
$row = $db->get_row_by_key('affiliates', 'local_username', $_GET['user']);

if($row && $row['local_password'] == $_GET['password']) {
    echo json_encode('overview.php');
    $_SESSION['affiliate_id'] = $row['id'];
    if(!$row['wizard_complete'])
        $_SESSION['wizard_incomplete'] = TRUE;

    if($row['administrator']) {
        $_SESSION['administrator'] = TRUE;
        $_SESSION['administrator_id'] = $row['id'];
    } else {
        $_SESSION['administrator'] = FALSE;
        unset($_SESSION['administrator_id']);
    }
} else {
    echo json_encode(false);
}

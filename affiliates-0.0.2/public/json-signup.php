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

require_once '../lib/bootstrap.php';

$db = new Database();
$result = $row = $db->insert('affiliates', array(
    'local_username' => $_GET['user'],
    'local_password' => $_GET['password']));

if($result) {
    echo json_encode('overview.php');
    $row = $db->get_row_by_key('affiliates', 'local_username', $_GET['user']);
    $_SESSION['affiliate_id'] = $row['id'];
} else {
    echo json_encode(false);
}

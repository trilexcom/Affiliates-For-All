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

parse_str($_GET['details'], $details);

// Check the user isn't trying to change anything he isn't supposed to:

$junk = array_diff_key($details, array_fill_keys(array(
    'title', 'first_name', 'last_name', 'email', 'address1', 'address2',
    'address3', 'address4', 'postcode', 'country', 'phone'), true));

if(count($junk) == 0) {
    $db = new Database();
    $result = $db->update_by_key('affiliates',
        'id', $_SESSION['affiliate_id'], $details);

    echo json_encode($result ? true : false);
}

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

Template::check_ajax_key();

$pager = new Pager('affiliates', Database::$affiliate_short_fields,
    Database::$affiliate_short_headings, Database::$affiliate_fields);
$pager->set_admin_mode();
$pager->set_editable();
$pager->set_order_by('local_username');
$pager->disable_date_restriction();

if($_GET['format'] == 'json') {
    $pager->json($_GET['page']);
} else if($_GET['format'] == 'write') {
    $pager->write($_GET);
} else if($_GET['format'] == 'delete') {
    $pager->delete($_GET['key']);
} else {
    $pager->json_single($_GET['key']);
}

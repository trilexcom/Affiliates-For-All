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

$db = new Database();
$row = $db->get_row_by_key('banners', 'name', $_GET['name']);

if($row != null) {
  header('Content-Type: '.$row['mime_type']);
  print $row['banner'];
}

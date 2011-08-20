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

$template = new Template('banners');
$template->set('title', "$affiliate_programme_name: Banners");

$rows = $db->get_pdo()->query(
    'select id, name, link_target from banners where enabled order by id');

$rows = $rows->fetchAll();
$template->set('banners', $rows);

$slash = substr($store_home, -1) == '/' ? '' : '/';
$template->set('store_home', $store_home . $slash);

$dir = dirname($_SERVER['PHP_SELF']);
if($dir != '/') $dir .= '/';
$protocol = $https ? 'https' : 'http';
$template->set('banner_script',
    "$protocol://${_SERVER['HTTP_HOST']}${dir}servebanner.php?name=");

$template->set('refparam',
    $affiliate_referrer_parameter.'='.$_SESSION['affiliate_id']);

$template->set('dataparam', $affiliate_data_parameter);

$template->render();

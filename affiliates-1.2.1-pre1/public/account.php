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

$wizard_not_required = TRUE;
require_once '../lib/bootstrap.php';

$template = new Template('account');

$title = __('Account Settings');
$template->set('title', "$affiliate_programme_name: $title");

$template->set('terms', $terms_of_business);
$template->set('wizard', isset($_SESSION['wizard_incomplete']));

if(isset($_SESSION['wizard_incomplete']))
    $template->suppress_menu();

$db = new Database();
$stmt = $db->get_pdo()->query(
    'select * from affiliates where id = ' . $_SESSION['affiliate_id']);

$row = $stmt->fetch();
foreach($row as $key => $value)
    $template->set("user_$key", $value);

$stmt = $db->get_pdo()->query(
    'select * from countries order by name');

$template->set("countries", $stmt->fetchAll());

$template->render();

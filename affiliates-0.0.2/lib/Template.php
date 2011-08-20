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
    private $file, $show_menu, $variables;

    public function __construct($file) {
        $this->file = $file;
        $this->show_menu = true;
        $this->variables = array();
    }

    public function suppress_menu() {
        $this->show_menu = false;
    }

    public function set($key, $value) {
        $this->variables[$key] = $value;
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

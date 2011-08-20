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

class Editor {
    private $fields, $headings, $sizes;

    public function __construct($fields, $headings, $sizes) {
        $this->fields = preg_split('/\s*,\s*/', $fields);
        $this->headings = preg_split('/\s*,\s*/', $headings);
        $this->sizes = preg_split('/\s*,\s*/', $sizes);
    }

    public function get_field_descriptions() {
        $result = array();

        for($i = 0; $i < count($this->fields); $i++) {
            $name = $this->fields[$i];
            $required = strpos($name, '*') !== FALSE;
            $name = rtrim($name, '*');

            $field = array($name, $this->headings[$i], $this->sizes[$i],
                $required);

            array_push($result, $field);
        }

        return $result;
    }
}

<?php

    /**
    *   Copyright 2017 Simon Hamelin
    *
    *   Licensed under the Apache License, Version 2.0 (the "License");
    *   you may not use this file except in compliance with the License.
    *   You may obtain a copy of the License at
    *
    *   http://www.apache.org/licenses/LICENSE-2.0
    *
    *   Unless required by applicable law or agreed to in writing, software
    *   distributed under the License is distributed on an "AS IS" BASIS,
    *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    *   See the License for the specific language governing permissions and
    *   limitations under the License.
    **/

    $multith = null;

    $fp_explode = explode('/', $_SERVER['REQUEST_URI']);
    $racine = "";

    for($i = 1 ; $i < count($fp_explode) - 1 ; $i++) {
      $racine .= "../";
    }

    # If you want to change the position of the files, modify the lines below!
    # (replace "multith-php-master/multith" by what you want)
    require_once($racine . "multith-php-master/multith/Database/DatabaseType.php");
    require_once($racine . "multith-php-master/multith/Multith.php");

    $multith = new Multith;

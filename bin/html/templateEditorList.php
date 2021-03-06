<?php

/* 
 * Copyright (C) 2015 Pedro Pelaez <aaaaa976@gmail.com>
 * Sources https://github.com/PSF1/pharinix
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
if (!defined("CMS_VERSION")) { header("HTTP/1.0 404 Not Found"); die(""); }

if (!class_exists("commandTemplateEditorList")) {
    class commandTemplateEditorList extends driverCommand {

        public static function runMe(&$params, $debug = true) {
            $data = driverTools::lsDir("templates/pages/", "*.xml");
//            $resp = array();
//            foreach ($data["files"] as $file) {
//                $fInfo = driverTools::pathInfo($file);
//                $resp[] = $fInfo["name"];
//            }
            header("Content-type: application/json");
            echo driverCommand::run("toJson", $data["files"]);
        }

        public static function getHelp() {
            return array(
                "description" => "Echo a json list of templates. ['default', ...]}", 
                "parameters" => array(), 
                "response" => array()
            );
        }
    }
}
return new commandTemplateEditorList();
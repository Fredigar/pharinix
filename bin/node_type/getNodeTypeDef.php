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
if (!defined("CMS_VERSION")) {
    header("HTTP/1.0 404 Not Found");
    die("");
}

if (!class_exists("commandGetNodeTypeDef")) {
    class commandGetNodeTypeDef extends driverCommand {

        public static function runMe(&$params, $debug = true) {
            $nid = driverCommand::run("getNodeTypeId", array("name" => $params["nodetype"]));
            $nid = $nid["id"];
            $resp = array("name" => $params["nodetype"], "fields" => array());
            if ($nid !== false) {
                $sql = "SELECT * FROM `node_type_field` where `node_type` = $nid";
                $q = dbConn::get()->Execute($sql);
                while (!$q->EOF) {
                    $item = array();
                    $item['name'] = $q->fields['name'];
                    $item['type'] = $q->fields['type'];
                    $item['len'] = $q->fields['len'];
                    $item['required'] = $q->fields['required']=="1"?true:false;
                    $item['readonly'] = $q->fields['readonly']=="1"?true:false;
                    $item['locked'] = $q->fields['locked']=="1"?true:false;
                    $item['default'] = $q->fields['default'];
                    $item['label'] = $q->fields['label'];
                    $item['help'] = $q->fields['help'];
                    $item['multi'] = $q->fields['multi']=="1"?true:false;
                    $resp["fields"][] = $item;
                    $q->MoveNext();
                }
            }
            
            return $resp;
        }

        public static function getHelp() {
            return array(
                "description" => "Get array definition of node type.", 
                "parameters" => array(
                    "nodetype" => "Node type name",
                ), 
                "response" => array("nodetype" => "Array with node type definition.")
            );
        }
    }
}
return new commandGetNodeTypeDef();
<?php
namespace App\Models;

use Config\Core\Database;
use Exception;

class DBHelper extends Database {

    public static function getTableInfo(string $table) {
        try {
            global $db;
            $sqlGetInfoTable = $db->query("SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".self::$database."' AND TABLE_NAME = '{$table}'");
            return $sqlGetInfoTable->fetch_all(MYSQLI_ASSOC) ?? [];

        } catch (Exception $e) {
            return [];
        }
    }

    public static function getBindTypes($value) {
        switch($value) {
            case "varchar": return "s";
            case "int": return "i";
            case "bigint": return "i";
            case "double": return "d";
            case "datetime": return "s";
            case "text": return "s";
            case "longtext": return "s";
            case "enum": return "s";
            case "timestamp": return "s";
            default: return "";
        }
    }

    public static function insert(string $table, array $data): array|bool {
        try {
            /** Get Table Info */
            $tableInfo = self::getTableInfo(table: $table);
            if(empty($tableInfo)) {
                return false;
            }

            
            /** Parsing array column into key:value array */
            $dataReady = [];
            $bindTypes = "";
            foreach($tableInfo as $ti) {
                if(array_key_exists($ti['COLUMN_NAME'], $data)) {
                    $dataReady[ "`".$ti['COLUMN_NAME']."`" ] = $data[ $ti['COLUMN_NAME'] ];
                    $bindTypes .= self::getBindTypes($ti['DATA_TYPE']);
                }
            }

            $columns = implode(", ", array_keys($dataReady));
            $placeholder = implode(", ", array_fill(0, count($dataReady), "?"));

            /** Data */
            $params = [];
            $params[] = $bindTypes;
            foreach($dataReady as $key => $val) {
                $params[] = &$dataReady[$key];
            } 
            
            /** Insert new Record to table */
            global $db;
            if(empty($db)) {
                $db = self::getConnection();
            }

            $sqlInsert = $db->prepare("INSERT INTO {$table} ({$columns}) VALUES ({$placeholder})");
            call_user_func_array([$sqlInsert, "bind_param"], $params);
            if(!$sqlInsert->execute()) {
                return false;
            }


            // echo $bindTypes;
            return $dataReady;

        } catch (Exception $e) {
            if(ini_get("display_errors") == "1") {
                throw $e;
            }
            
            return false;
        }
    } 

    public static function update(string $table, array $data = [], array $where = []): bool {
        try {
            /** Get Table Info */
            $tableInfo = Self::getTableInfo(table: $table);
            if(empty($tableInfo)) {
                return false;
            }

            if(empty($data)) {
                return false;
            }

            if(empty($where)) {
                return false;
            }
            
            /** Parsing array column into key:value array */
            $dataReady = [];
            $whereReady = [];
            $bindTypes = "";
            $whereBind = "";
          
            foreach($tableInfo as $ti) {
                /** Foreach Data Column */
                if(array_key_exists($ti['COLUMN_NAME'], $data)) {
                    $dataReady[ "`".$ti['COLUMN_NAME']."`" ] = $data[ $ti['COLUMN_NAME'] ];
                    $bindTypes .= Self::getBindTypes($ti['DATA_TYPE']);
                }

                /** Foreach data where */
                if(array_key_exists($ti['COLUMN_NAME'], $where)) {
                    $whereReady[ $ti['COLUMN_NAME'] ] = $where[ $ti['COLUMN_NAME'] ];
                    $whereBind .= Self::getBindTypes($ti['DATA_TYPE']);
                }
            }


            $columns = implode(" = ?, ", array_keys($dataReady)) . " = ? ";
            $wheres = implode(" = ? AND ", array_keys($whereReady)) . "  = ? ";
            $params = [];
            $params[] = $bindTypes.$whereBind;
            foreach($dataReady as $key => $val) {
                $params[] = &$dataReady[$key];
            }

            foreach($whereReady as $wKey => $wVal) {
                $params[] = &$whereReady[$wKey];
            }

            /** Update Record */
            global $db;
            if(empty($db)) {
                $db = Self::getConnection();
            }

            $sqlUpdate = $db->prepare("UPDATE {$table} SET {$columns} WHERE {$wheres}");
            call_user_func_array([$sqlUpdate, "bind_param"], $params);
            if(!$sqlUpdate->execute()) {
                return false;
            }

            return true;

        } catch (Exception $e) {
            if(ini_get("display_errors") == "1") {
                throw $e;
            }

            return false;
        }
    } 

    public static function delete(string $table, array $where = []) {
        try {
            /** Get Table Info */
            $tableInfo = Self::getTableInfo(table: $table);
            if(empty($tableInfo)) {
                return false;
            }

            if(empty($where)) {
                return "Empty Where";
            }
            
            /** Parsing array column into key:value array */
            $whereReady = [];
            $bindTypes = "";
            $whereBind = "";
          
            foreach($tableInfo as $ti) {
                /** Foreach data where */
                if(array_key_exists($ti['COLUMN_NAME'], $where)) {
                    $whereReady[ $ti['COLUMN_NAME'] ] = $where[ $ti['COLUMN_NAME'] ];
                    $whereBind .= Self::getBindTypes($ti['DATA_TYPE']);
                }
            }


            $wheres = implode(" = ? AND ", array_keys($whereReady)) . "  = ? ";
            $params = [];
            $params[] = $bindTypes.$whereBind;
            foreach($whereReady as $wKey => $wVal) {
                $params[] = &$whereReady[$wKey];
            }

            /** Delete Record */
            $db = Self::getConnection();
            $sqlDelete = $db->prepare("DELETE FROM {$table} WHERE {$wheres}");
            call_user_func_array([$sqlDelete, "bind_param"], $params);
            if(!$sqlDelete->execute()) {
                return false;
            }

            return true;

        } catch (Exception $e) {
            if(ini_get("display_errors") == "1") {
                throw $e;
            }

            return false;
        }
    } 
}
<?php
class Connection
{
    public static function connect()
    {
        $connect = new mysqli("localhost", "root", "", "tienda");
        $connect->query("SET NAMES 'utf8'");
        return $connect;
    }
}
?>
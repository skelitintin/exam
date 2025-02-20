<?php

function get_connection()
{
    $server_name = "localhost";
    $user = "root";
    $password = "";
    $database = "exam_database";

    $conn = new mysqli($server_name, $user, $password, $database);

    if ($conn->connect_error) {
        die("Unable to Connect:  {$conn->connect_error}");
    }

    return $conn;
}

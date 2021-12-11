<?php
    $init = (object) [
        "ffmpeg_binary" => "ffmpeg", 
        "ffprobe_binary" => "ffprobe", 
        "ffmpeg_threads" => 2, 

        "db_properties" => (object) [
            "db_user" => "root",
            "db_password" => "root",
            "db_host" => "mysql",
            "db_database" => "fulptube",
            "db_connected" => false,
        ], 
    ];

    try
    {
        $__db = new PDO("mysql:host=" . $init->db_properties->db_host . ";dbname=" . $init->db_properties->db_database . ";charset=utf8mb4",
            $init->db_properties->db_user,
            $init->db_properties->db_password,
            [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
        $init->db_properties->db_connected = true;
    }
    catch(PDOException $e)
    {
        die("An error occured connecting to the database: " . $e->getMessage());
    }

    session_start();
?>
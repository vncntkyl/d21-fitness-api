<?php
date_default_timezone_set("Asia/Manila");
const DB_SERVER = '202.57.44.68';
const DB_USERNAME = 'oamsun';
const DB_PASSWORD = 'Oams@UN';
const DB_NAME = 'unmg_workplace';

const DEV_SERVER = 'localhost';
const DEV_USERNAME = 'root';
const DEV_PASSWORD = '';
const DEV_NAME = 'd21';

function getDbConfig($mode = "DEV")
{
    if ($mode === 'DEV') {
        return [
            'host' => DEV_SERVER,
            'username' => DEV_USERNAME,
            'password' => DEV_PASSWORD,
            'database' => DEV_NAME,
        ];
    }
    return [
        'host' => DB_SERVER,
        'username' => DB_USERNAME,
        'password' => DB_PASSWORD,
        'database' => DB_NAME,
    ];
}
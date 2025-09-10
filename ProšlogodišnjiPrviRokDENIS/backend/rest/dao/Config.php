<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

class Config
{

    public static function get_env($name, $default)
    {
        return isset($_ENV[$name]) && trim($_ENV[$name]) != "" ? $_ENV[$name] : $default;
    }
    public static function DATABASE_NAME()
    {

        return Config::get_env("DB_NAME", "final_exam");
    }

    public static function DATABASE_PORT()
    {
        return Config::get_env("DB_PORT", "3306");
    }

    public static function DATABASE_HOST()
    {
        return Config::get_env("DB_HOST", "localhost");
    }

    public static function DATABASE_USERNAME()
    {
        return Config::get_env("DB_USER", "root");
    }

    public static function DATABASE_PASSWORD()
    {
        return Config::get_env("DB_PASSWORD", "");
    }

    public static function JWT_SECRET()
    {
        return Config::get_env("JWT_SECRET", "extremelysecurekey");
    }
}
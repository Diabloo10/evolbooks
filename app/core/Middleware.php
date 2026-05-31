<?php

class Middleware
{

    public static function auth()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if(!isset($_SESSION['user_id'])){
            header("Location: /evol/public/auth/login");
            exit;
        }
    }


    public static function admin()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if(!isset($_SESSION['user_id'])){
            header("Location: /evol/public/auth/login");
            exit;
        }

        if($_SESSION['role'] !== 'admin'){
            header("Location: /evol/public/");
            exit;
        }
    }

}
<?php

class LoginSuccess
{
    public const LOGIN_SUCCESS = 1;

    public static function getSuccessMessage(int $code):string
    {
        switch ($code) {
            case self::LOGIN_SUCCESS;
            return "Connexion réussie";
            break;
        }
    }
}
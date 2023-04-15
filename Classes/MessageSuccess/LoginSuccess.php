<?php

class LoginSuccess
{
    public const LOGIN_SUCCESS = 1;

    public static function getSuccessMessage(int $code_success):string
    {
        switch ($code_success) {
            case self::LOGIN_SUCCESS;
            return "Connexion réussie";
            break;
        }
    }
}
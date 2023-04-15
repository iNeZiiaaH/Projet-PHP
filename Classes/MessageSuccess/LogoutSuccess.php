<?php

class LogoutSuccess
{
    public const LOGOUT_SUCCESS = 1;

    public static function getSuccessMessage(int $code_success):string
    {
        switch ($code_success) {
            case self::LOGOUT_SUCCESS;
            return "Déconnexion réussie";
            break;
        }
    }
}
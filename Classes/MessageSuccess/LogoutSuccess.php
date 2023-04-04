<?php

class LogoutSuccess
{
    public const LOGOUT_SUCCESS = 1;

    public static function getSuccessMessage(int $code):string
    {
        switch ($code) {
            case self::LOGOUT_SUCCESS;
            return "Déconnexion réussie";
            break;
        }
    }
}
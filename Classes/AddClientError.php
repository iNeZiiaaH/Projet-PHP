<?php

class ClientErro
{
    public const EMAIL_EXISTS = 1;

    public static function getErrorMessage(int $code): string
    {
        switch ($code) {
            case self::EMAIL_EXISTS:
                return "Un Client existe déjà avec cette adresse email";
                break;
        }
    }
}

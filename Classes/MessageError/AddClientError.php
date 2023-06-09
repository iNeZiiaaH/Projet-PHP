<?php

class ClientError
{
    public const EMAIL_EXISTS = 1;

    public static function getErrorMessage(int $code_erreur): string
    {
        switch ($code_erreur) {
            case self::EMAIL_EXISTS:
                return "Un Client existe déjà avec cette adresse email";
                break;
        }
    }
}

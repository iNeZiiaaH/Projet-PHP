<?php

class FactureError
{
    public const FACTURE_ERROR = 1;

    public static function getErrorMessage(int $code_erreur): string
    {
        switch ($code_erreur) {
            case self::FACTURE_ERROR:
                return "La Facture n'a pu être crée";
                break;
        }
    }
}
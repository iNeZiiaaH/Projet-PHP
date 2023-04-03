<?php

class FactureError
{
    public const FACTURE_ERROR = 1;

    public static function getErrorMessage(int $code): string
    {
        switch ($code) {
            case self::FACTURE_ERROR:
                return "La Facture n'a pu être crée";
                break;
        }
    }
}
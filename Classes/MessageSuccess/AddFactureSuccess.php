<?php

class FactureSuccess
{
    public const ADD_FACTURE_SUCCESS = 1;

    public static function getSuccessMessage(int $code_success): string
    {
        switch ($code_success) {
            case self::ADD_FACTURE_SUCCESS:
                return "Facture ajouter avec succès";
                break;
        }
    }
}

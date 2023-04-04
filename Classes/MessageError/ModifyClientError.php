<?php

class ModifyClientError
{
    public const MODIFY_CLIENT_ERROR = 1;

    public static function getErrorMessage(int $code): string
    {
        switch ($code) {
            case self::MODIFY_CLIENT_ERROR:
                return "Un Problème est survenue lors de la modification du client";
                break;
        }
    }
}
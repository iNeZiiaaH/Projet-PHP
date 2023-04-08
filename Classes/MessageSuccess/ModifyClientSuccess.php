<?php

class ModifyClientSuccess
{
    public const MODIFY_CLIENT_SUCCESS = 1;

    public static function getSuccessMessage(int $code_success): string
    {
        switch ($code_success) {
            case self::MODIFY_CLIENT_SUCCESS:
                return "Client modifier avec succés";
                break;
        }
    }
}

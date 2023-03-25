<?php

class DeleteClientSuccess
{
    public const DELETE_CLIENT_SUCCESS = 1;

    public static function getSuccessMessage(int $code): string
    {
        switch ($code) {
            case self::DELETE_CLIENT_SUCCESS:
                return 'Client supprimé';
                break;
        }
    }
}

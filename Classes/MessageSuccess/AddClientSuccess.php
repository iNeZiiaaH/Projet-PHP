<?php
class ClientSuccess
{
  public const ADD_CLIENT_SUCCESS = 1;

  public static function getSuccessMessage(int $code_success): string
  {
    switch ($code_success) {
      case self::ADD_CLIENT_SUCCESS:
        return "Ajout de client réussie";
        break;
    }
  }
}
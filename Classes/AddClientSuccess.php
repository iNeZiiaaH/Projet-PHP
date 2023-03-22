<?php

class ClientSuccess
{
  public const ADD_CLIENT_SUCCESS = 1;

  public static function getSuccessMessage(int $code): string
  {
    switch ($code) {
      case self::ADD_CLIENT_SUCCESS:
        return "Ajout de client réussie";
        break;
    }
  }
}
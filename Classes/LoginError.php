<?php

class LoginError
{
  public const LOGIN_INVALID = 1;
  public const CONNECTION_FAILED = 2;

  public static function getErrorMessage(int $code): string
  {
    switch ($code) {
      case self::LOGIN_INVALID:
        return "Login ou Mot de passe Incorrect";
        break;
      case self::CONNECTION_FAILED:
        return "Veuillez vous connecter pour accéder a cette page";
        break;
      default:
        return "Une erreur est survenue";
    }
  }
}

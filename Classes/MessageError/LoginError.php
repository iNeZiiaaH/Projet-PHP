<?php

class LoginError
{
  public const LOGIN_INVALID = 1;
  public const CONNECTION_FAILED = 2;
  public const PASSWORD_INVALID = 3;
  public const FILLING_THE_FIELDS = 4;

  public static function getErrorMessage(int $code_erreur): string
  {
    switch ($code_erreur) {
      case self::LOGIN_INVALID:
        return "Login incorrect";
        break;
      case self::CONNECTION_FAILED:
        return "Veuillez vous connecter pour accéder a cette page";
        break;
      case self::PASSWORD_INVALID:
        return "Mot de passe Incorrect";
      case self::FILLING_THE_FIELDS:
        return "Rentrer tous les champs pour vous connecter";  
      default:
        return "Une erreur est survenue";
    }
  }
}

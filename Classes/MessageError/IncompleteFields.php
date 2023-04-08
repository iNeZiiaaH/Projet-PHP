<?

class IncompleteFields
{
    public const INCOMPLETE_FIELDS = 1;

    public static function getErrorMessage(int $code_erreur): string
    {
        switch ($code_erreur) {
            case self::INCOMPLETE_FIELDS:
                return "Un Client existe déjà avec cette adresse email";
                break;
        }
    }
}
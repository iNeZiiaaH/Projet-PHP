<?php
class login
{

    private string $login;
    private string $password;
    private $pdo;

    public function __construct($login, $password, $pdo)
    {
        $this->login = $login;
        $this->password = $password;
        $this->pdo = $pdo;
    }

    public function authenticate()
    {

        $query = "SELECT pass FROM Utilisateur WHERE login = :login";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['login' => $this->login]);

        $user = $stmt->fetch();

        if ($user === false) {
            redirect('login.php?error=' . LoginError::LOGIN_INVALID);
        }

        $hashedPassword = $user['pass'];
        if (password_verify($this->password, $hashedPassword) === false) {
            redirect('login.php?error=' . LoginError::PASSWORD_INVALID);
        }

        $_SESSION['Connected'] = true;
        redirect('Accueil.php?success=' . LoginSuccess::LOGIN_SUCCESS);
    }
}

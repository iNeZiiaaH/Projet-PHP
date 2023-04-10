<?php
class ClientCrud
{
    private int $id;
    private string $nom;
    private string $email;
    private string $domaine;
    private string $adresse;
    private string $ville;
    private int $code_postal;
    private string $pays;
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getDomaine(): string
    {
        return $this->domaine;
    }
    public function getAdresse(): string
    {
        return $this->adresse;
    }
    public function getVille(): string
    {
        return $this->ville;
    }
    public function getCodePostal(): int
    {
        return $this->code_postal;
    }
    public function getPays(): string
    {
        return $this->pays;
    }

    public function ViewClient($clientId)
    {

            $query_view_client = "SELECT * FROM client WHERE id=:id";
            $stmt_view_client = $this->pdo->prepare($query_view_client);
            $stmt_view_client->execute([
                'id' => $clientId
            ]);
            $client = $stmt_view_client->fetch();

            //  condition si aucun client n'est trouvé
            if ($client === false) {
                http_response_code(404);
                exit('Client non trouvé');
            } else {
    
        // on définie les valeurs de chaque propriétés
        $this->id = $client['id'];
        $this->nom = $client['nom'];
        $this->email = $client['email'];
        $this->domaine = $client['domaine'];
        $this->adresse = $client['adresse'];
        $this->ville = $client['ville'];
        $this->code_postal = $client['code_postal'];
        $this->pays = $client['pays'];
        }
    }

    public function ModifyClient($id_client, $newEmail, $newNom, $newDomaine, $newAdresse, $newVille, $newCode_Postal, $newPays)
    {

        $id_client = $_GET['id'];
        $newEmail = $_POST['email'];
        $newNom = $_POST['nom'];
        $newDomaine = $_POST['domaine'];
        $newAdresse = $_POST['adresse'];
        $newVille = $_POST['ville'];
        $newCode_Postal = $_POST['code_postal'];
        $newPays = $_POST['pays'];

        $this->email = $newEmail;
        $this->nom = $newNom;
        $this->domaine = $newDomaine;
        $this->adresse = $newAdresse;
        $this->ville = $newVille;
        $this->code_postal = $newCode_Postal;
        $this->pays = $newPays;


        $stmt_modify_client = $this->pdo->prepare('UPDATE client SET email = ?, nom = ?, domaine = ?, adresse = ?, ville = ?, code_postal = ?, pays = ? WHERE id = ?');
        $result = $stmt_modify_client->execute([
            $this->getEmail(),
            $this->getNom(),
            $this->getDomaine(),
            $this->getAdresse(),
            $this->getVille(),
            $this->getCodePostal(),
            $this->getPays(),
            $id_client
        ]);

        if ($result) {
            redirect('ModifyClient.php?success=' . ModifyClientSuccess::MODIFY_CLIENT_SUCCESS . "&id=" . $id_client);
        } else {
            redirect('ModifyClient.php?error=' . ModifyClientError::MODIFY_CLIENT_ERROR);
        }
    }
    public function AddClient()
    {
        // On récupère les champs du formulaire en méthode post
        $this->email = $_POST['email'];
        $this->nom = $_POST['nom'];
        $this->domaine = $_POST['domaine'];
        $this->adresse = $_POST['adresse'];
        $this->ville = $_POST['ville'];
        $this->code_postal = $_POST['code_postal'];
        $this->pays = $_POST['pays'];

        // On vérifie si l'email existe déjà dans la base de données via la requête SQL
        $stmt_email = $this->pdo->prepare('SELECT COUNT(*) FROM client WHERE email = ?');
        $stmt_email->bindValue(1, $this->email, PDO::PARAM_STR);
        $stmt_email->execute();
        $count_email = $stmt_email->fetchColumn();

        //condition si un utilisateur existe deja , grace a la requête sql au dessus
        if ($count_email > 0) {
            redirect('Add-Client.php?error=' . ClientError::EMAIL_EXISTS);
        } else {

            // Ajouter le client à la base de données
            $stmt_add_client = $this->pdo->prepare('INSERT INTO client (email, nom, domaine, adresse, ville, code_postal, pays) VALUES (? , ? , ? , ? , ? , ? , ?)'); // requête SQL Pour insérer un nouveau user
            $stmt_add_client->bindValue(1, $this->email, PDO::PARAM_STR);
            $stmt_add_client->bindValue(2, $this->nom, PDO::PARAM_STR);
            $stmt_add_client->bindValue(3, $this->domaine, PDO::PARAM_STR);
            $stmt_add_client->bindValue(4, $this->adresse, PDO::PARAM_STR);
            $stmt_add_client->bindValue(5, $this->ville, PDO::PARAM_STR);
            $stmt_add_client->bindValue(6, $this->code_postal, PDO::PARAM_INT);
            $stmt_add_client->bindValue(7, $this->pays, PDO::PARAM_STR);
            // pas besoin de mettre des paramètres dans le execute car les valeurs sont déjà attribuer avec la méthode bondValue
            $stmt_add_client->execute();
            

            // Afficher un message de confirmation ajout de client
            redirect('Add-Client.php?success=' . ClientSuccess::ADD_CLIENT_SUCCESS);
        }
    }
}

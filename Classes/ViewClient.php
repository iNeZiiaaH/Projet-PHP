<?php
class Client
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

    public function afficherClients($clientId)
    {

        // condition pour que la reqête s'execute que si le client est renseigné
        if (isset($_GET['id'])) {

            $clientId = $_GET['id'];

            $query = "SELECT * FROM client WHERE id=:id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'id' => $clientId
            ]);
            $client = $stmt->fetch();

            //  condition si aucun client n'est trouvé
            if ($client === false) {
                http_response_code(404);
                exit('Client non trouvé');
            }
        }
            // on définie les valeurs de chaque propriétés
            $this->id = $client['id'];
            $this->nom = $client['nom'];
            $this->email = $client['email'];
            $this->domaine = $client['domaine'];
            $this->adresse = $client['adresse'];
            $this->ville = $client['ville'];
            $this->code_postal = $client['code_postal'];
            $this->pays = $client['pays'];
            ?>

            <div class="card d-flex mx-auto mt-5" style="width: 18rem;">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php $this->getNom(); ?></h5>
                    <p class="card-text"><?php echo $this->getEmail() ?></p>
                    <p class="card-text"><?php echo $this->getDomaine() ?></p>
                    <p class="card-text"><?php echo $this->getAdresse() ?></p>
                    <p class="card-text"><?php echo $this->getVille() ?></p>
                    <p class="card-text"><?php echo $this->getCodePostal() ?></p>
                    <p class="card-text"><?php echo $this->getPays() ?></p>
                    <a href="ModifyClient.php?id=<?php echo $this->getId(); ?>" class="btn btn-dark">Modifier Client</a>
                    <br></br>
                    <a href="DeleteClient.php?id=<?php echo $this->getId(); ?>" class="btn btn-dark">Supprimer Client</a>
                </div>
            </div>
<?php }
    
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
}

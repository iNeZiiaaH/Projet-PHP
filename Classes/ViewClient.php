<?php



class Client
{
    private $pdo;

    public function __construct($pdo)
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
            } ?>

            <div class="card d-flex mx-auto mt-5" style="width: 18rem;">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $client['nom']; ?></h5>
                    <p class="card-text"><?php echo $client['email'] ?></p>
                    <p class="card-text"><?php echo $client['domaine'] ?></p>
                    <p class="card-text"><?php echo $client['adresse'] ?></p>
                    <p class="card-text"><?php echo $client['ville'] ?></p>
                    <p class="card-text"><?php echo $client['code_postal'] ?></p>
                    <p class="card-text"><?php echo $client['pays'] ?></p>
                    <a href="ModifyClient.php?id=<?php echo $client['id']; ?>" class="btn btn-dark">Modifier Client</a>
                    <br></br>
                    <a href="DeleteClient.php?id=<?php echo $client['id']; ?>" class="btn btn-dark">Supprimer Client</a>
                </div>
            </div>

<?php }
    }
}

<?php

class Facture
{
    
    private DateTime $date_facture;
    private string $commentaire;
    private float $total;
    private int $client_id;
    private  $ligne_facture;


    public function __construct($date_facture, $commentaire, $total, $ligne_facture, $client_id)
    {
        $this->date_facture = new DateTime ($date_facture); // j'utilise la classe DateTime de php qui représente une date et une heure 
        $this->commentaire = $commentaire;
        $this->total = $total;
        $this->client_id = $client_id;
        $this->ligne_facture = $ligne_facture;
    }
    public function getDateFacture(): DateTime
    {
        return $this->date_facture;
    }
    public function setDateFacture(DateTime $date_facture): void
    {
        $this->date_facture = $date_facture;
    }
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }
    public function setCommentaire(string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }
    public function getTotal(): float
    {
        return $this->total;
    }
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }
    public function getClientId(): int
    {
        return $this->client_id;
    }
    public function setClientId(int $client_id): void
    {
        $this->client_id = $client_id;
    }
    public function getLigneFacture()
    {
        return $this->ligne_facture;
    }
    public function setLigneFacture($ligne_facture): void
    {
        $this->ligne_facture = $ligne_facture;
    }
    public function InsertFacture()
    {
        global $pdo; // J'accède a ma variable $pdo qui est en dehors de ma méthode 

        // Validation du formulaire 
        $this->client_id = $_POST['client_id'];
        $this->date_facture = DateTime::createFromFormat('Y-m-d', $_POST['date_facture']); // je transforme la chaine de caractère en un format de date grâce a l'instance de la classe DateTime
        $this->commentaire = $_POST['commentaire'];
        $this->total = $_POST['prix_total'];
        $this->ligne_facture = $_POST['lignes_facture'];


        // Insertion des données dans la table "facture"
        $query = "INSERT INTO Facture (numero_facture, date_facture, total, commentaire, client_id) VALUES (:numero_facture, :date_facture, :total, :commentaire, :client_id)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'numero_facture' => uniqid(), // génération d'un numéro de facture unique
            'date_facture' => $this->date_facture->format('Y-m-d'),
            'commentaire' => $this->commentaire,
            'client_id' => $this->client_id,
            'total' => $this->total
        ]);

        // Récupération de l'id de la dernière facture insérée avec la fonction lastInsertId 
        $id_facture = $pdo->lastInsertId();

        $this->total = 0;
        foreach ($this->ligne_facture as $lignes) {
            $description = $lignes['description'];
            $quantite = isset($lignes['quantite']) ? $lignes['quantite'] : 0; //(opérateur ternaire) Si la clé quantité n'est pas définie dans le tableau alors la quantité sera automatiquement à 0. J'ai fais cela pour prévenir d'une erreur si la clé quantité n'est pas définie.
            $prix_unitaire = isset($lignes['prix_unitaire']) ? $lignes['prix_unitaire'] : 0; 
            $prix_total = intVal($quantite) * intVal($prix_unitaire);

            $this->total += $prix_total;

            // Insertion des données dans la table "ligne_facture"
            $query = "INSERT INTO Ligne_Facture (description, quantite, prix_unitaire, prix_total, id_facture) VALUES (:description, :quantite, :prix_unitaire, :prix_total, :id_facture)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'description' => $description,
                'quantite' => $quantite,
                'prix_unitaire' => $prix_unitaire,
                'prix_total' => $prix_total,
                'id_facture' => $id_facture
            ]);
        }

        if ($id_facture == 0) {
            redirect('Facture.php?error=' . FactureError::FACTURE_ERROR);
        } else {
            redirect('Facture.php?success=' . FactureSuccess::ADD_FACTURE_SUCCESS);
        }
    }
}

<?php

class Statistique
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getClientDetails($client_id)
    {
        $query = 'SELECT client.nom, SUM(total) AS total_sum FROM Facture
                JOIN client ON Facture.client_id = client.id
                WHERE Facture.client_id = :client_id
                GROUP BY client.id';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'client_id' => $client_id
        ]);

        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = [
                'nom' => $row['nom'],
                'total_sum' => $row['total_sum']
            ];
        }

        return $results;
    }
}

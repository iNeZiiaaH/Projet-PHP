<?php
// Je récupère la classe tfpdf pour pouvoir crée une facture sous forme de PDF.
require_once 'tfpdf/tfpdf.php';

// Je récupère mes fonctions redirect et session error.
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

require_once __DIR__ . '/bdd-link/bdd-link.php';

if (isset($_GET['id'])) {
    $clientid = $_GET['id'];

    // Requête SQL pour selectionner toutes les colonnes de la table facture et aussi la colonne nom de la table client. J'utilise une jointure pour pouvoir récupérer ID spécifié 
    $query_Facture_Client = "SELECT Facture.*, Client.nom AS nom_client
    FROM Facture 
    INNER JOIN Client ON Facture.client_id = Client.id
    WHERE Facture.id = :id";
    $stmt_Facture_Client = $pdo->prepare($query_Facture_Client);
    $stmt_Facture_Client->execute([
        'id' => $clientid
    ]);

    if ($stmt_Factures_Clients = $stmt_Facture_Client->fetch()) {
        // J'instancie la classe tFPDF 
        $pdf = new tFPDF();
        
        // Ajoute une police Unicode (utilise UTF-8)
        $pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $pdf->SetFont('DejaVu', '', 14);

        // Définit la couleur
        $secondary_color = array(223, 227, 238);
        $pdf->AddPage();
        $pdf->Cell(40, 10, 'Facture pour : ' . $stmt_Factures_Clients['nom_client']); // ajout du nom du client
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Facture n°' . $stmt_Factures_Clients['numero_facture']); 

        // Ajout de contenu de la facture
        $pdf->Ln(); //pour sauter une ligne
        $pdf->Cell(0, 10, 'Date : ' . $stmt_Factures_Clients['date_facture']);
        $pdf->Ln();
        $pdf->Cell(0, 10, 'Total : ' . number_format($stmt_Factures_Clients['total'], 2, ',', ' ') . '€');
        $pdf->Ln();
        $pdf->Cell(0, 10, 'Commentaire : ' . $stmt_Factures_Clients['commentaire']);
        $pdf->Ln();

        // Ajout d'un tableau avec les lignes de la facture.
        $pdf->SetFont('DejaVu', '', 12);
        $pdf->SetFillColor($secondary_color[0], $secondary_color[1], $secondary_color[2]);
        $pdf->SetDrawColor(204, 204, 204);

        $pdf->Cell(90, 10, 'Description', 1, 0, 'L', true); // L= alignement sur la gauche
        $pdf->Cell(30, 10, 'Quantité', 1, 0, 'L', true);
        $pdf->Cell(30, 10, 'Prix unitaire', 1, 0, 'L', true);
        $pdf->Cell(30, 10, 'Total', 1, 1, 'L', true);

        $pdf->SetFont('DejaVu', '', 12);
        $pdf->SetFillColor(255, 255, 255);

        // Requête pour récupere les lignes de chaque facture.
        $query_Ligne_Facture = "SELECT * FROM Ligne_Facture WHERE id_facture = :id";
        $stmt_Ligne_Facture = $pdo->prepare($query_Ligne_Facture);
        $stmt_Ligne_Facture->execute(['id' => $stmt_Factures_Clients['id']]);
        $total_facture = 0;

        // Boucle pour ajouter chaque ligne de la facture sous forme de tableau. 
        while ($Ligne_Facture = $stmt_Ligne_Facture->fetch()) {
            $pdf->Cell(90, 10, $Ligne_Facture['description']);
            $pdf->Cell(30, 10, $Ligne_Facture['quantite']);
            $pdf->Cell(30, 10, number_format($Ligne_Facture['prix_unitaire'], 2, ',', ' ') . '€');
            $total_ligne = $Ligne_Facture['quantite'] * $Ligne_Facture['prix_unitaire'];
            $pdf->Cell(30, 10, number_format($total_ligne, 2, ',', ' ') . '€');
            $total_facture += $total_ligne;
            $pdf->Ln();
        }

        // Ajout du total de la facture.
        $pdf->Cell(150, 10, 'Total facture : ');
        $pdf->Cell(90, 10, number_format($total_facture, 2, ',', ' ') . '€');

        // Afficher la Facture sous formle de PDF dans un onglet grâce au 'I'.
        $pdf->Output('I', 'facture.pdf');
    }
}

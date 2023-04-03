<?php
require_once 'tfpdf/tfpdf.php';
require_once 'bdd-link/bdd-link.php';


if (isset($_GET['id'])) {
    $clientid = $_GET['id'];

    $query = "SELECT Facture.*, Client.nom AS nom_client
    FROM Facture 
    INNER JOIN Client ON Facture.client_id = Client.id
    WHERE Facture.id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'id' => $clientid
    ]);

    if ($stmt1 = $stmt->fetch()) {
        $pdf = new tFPDF();
        // Ajoute une police Unicode (utilise UTF-8)
        $pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $pdf->SetFont('DejaVu', '', 14);

        $pdf->AddPage();
        $pdf->Cell(40, 10, 'Facture pour : ' . $stmt1['nom_client']); // ajout du nom du client
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Facture n°' . $stmt1['numero_facture']);

        // Ajout de contenu
        $pdf->Ln(); //pour sauter une ligne
        $pdf->Cell(0, 10, 'Date : ' . $stmt1['date_facture']);
        $pdf->Ln();
        $pdf->Cell(0, 10, 'Total : ' . number_format($stmt1['total'], 2, ',', ' ') . '€');
        $pdf->Ln();
        $pdf->Cell(0, 10, 'Commentaire : ' . $stmt1['commentaire']);
        $pdf->Ln();

        // Ajout d'un tableau avec les lignes de la facture
        $pdf->Ln();
        $pdf->Cell(0, 10, 'Détail de la facture');
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Descripiton');
        $pdf->Cell(30, 10, 'Quantité');
        $pdf->Cell(30, 10, 'Prix unitaire');
        $pdf->Cell(30, 10, 'Total');
        $pdf->Ln();

        // Boucle pour ajouter chaque ligne de la facture
        $query2 = "SELECT * FROM Ligne_Facture WHERE id_facture = :id";
        $stmt2 = $pdo->prepare($query2);
        $stmt2->execute(['id' => $stmt1['id']]);
        $total_facture = 0;
        while ($row = $stmt2->fetch()) {
            $pdf->Cell(40, 10, $row['description']);
            $pdf->Cell(30, 10, $row['quantite']);
            $pdf->Cell(30, 10, number_format($row['prix_unitaire'], 2, ',', ' ') . '€');
            $total_ligne = $row['quantite'] * $row['prix_unitaire'];
            $pdf->Cell(30, 10, number_format($total_ligne, 2, ',', ' ') . '€');
            $total_facture += $total_ligne;
            $pdf->Ln();
        }

        // Ajout du total de la facture
        $pdf->Cell(100, 10, 'Total facture : ');
        $pdf->Cell(30, 10, number_format($total_facture, 2, ',', ' ') . '€');

        // Enregistrez le fichier et téléchargez-le
        $pdf->Output('I', 'facture.pdf');
    }
}

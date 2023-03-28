<?php


// requête pour récuperer le total de chaque facture 

// SELECT c.nom_client, SUM(lf.prix_total) AS chiffre_affaire
// FROM client 
// JOIN facture  ON c.client_id = f.client_id
// JOIN ligne_facture lf ON f.numero_facture = lf.id_facture
// GROUP BY c.client_id;
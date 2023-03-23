<?php

if (isset($_POST['modifier_client'])) {

    // Condition pour que les champs sois tous remplis sinon il ne peut pas envoyer la requête
    if (empty($_POST['email']) || empty($_POST['nom']) || empty($_POST['domaine']) || empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['code_postal']) || empty($_POST['pays'])) {
        echo 'Veuillez remplire tous les champs';
        exit;
    }

    $id_client = $_GET['id'];
    $email = $_POST['email'];
    $nom = $_POST['nom'];
    $domaine = $_POST['domaine'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $pays = $_POST['pays'];



    $stmt = $pdo->prepare('UPDATE client SET email = ?, nom = ?, domaine = ?, adresse = ?, ville = ?, code_postal = ?, pays = ? WHERE id = ?');
    $result = $stmt->execute([
        $email,
        $nom,
        $domaine,
        $adresse,
        $ville,
        $code_postal,
        $pays,
        $id_client
    ]);


    if (!$result) {
        echo "Erreur de la modification du client";
    } else {
        echo "Le client a été modifié";
    }
}

function updatePrixTotal() {
    var quantites = document.querySelectorAll("#quantite");
    var prix_unitaires = document.querySelectorAll("#prix_unitaire");
    var prix_total = 0;
    
    for (i = 0; i < quantites.length; i++) {
        prix_total += quantites[i].value * prix_unitaires[i].value;
    }
    document.getElementById("prix_total").value = prix_total;
}
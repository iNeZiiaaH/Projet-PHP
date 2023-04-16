function ajoutLigneFacture() {
    var lignesFacture = document.getElementById("lignes_facture");
    var nouvelleLigneFacture = document.createElement("div");
    nouvelleLigneFacture.classList.add("row", "row-cols-3");

    var index = lignesFacture.childElementCount; // on obtient le nombre de ligne actuel
    var labels = ["Description", "Quantité", "Prix unitaire"];
    var id = ["description", "quantite", "prix_unitaire"];

    for (var i = 0; i < labels.length; i++) {
        var colDiv = document.createElement("div");
        colDiv.classList.add("col");

        // Je vien crée les labels
        var label = document.createElement("label");
        label.classList.add("form-label");
        label.textContent = labels[i] + " :";

        // Je configure mes input
        var input = document.createElement("input");
        input.classList.add("form-control");
        input.type = i === 0 ? "text" : "number";
        // je configure l'attribut name, toLowerCase() = id est convertie en minuscule , il évite les problème de casse
        input.name = "lignes_facture[" + index + "][" + id[i].toLowerCase().replace("  ", "_") + "]";
        input.min = i === 1 ? 1 : 0; // opérateur terniare , renvoie faux si i n'est pas égale a 1
        input.required = true;
        input.id = id[i];
        input.onchange = updatePrixTotal;
        input.step = "0.01";

        // on crée les nouvelles lignes
        colDiv.appendChild(label);
        colDiv.appendChild(input);
        nouvelleLigneFacture.appendChild(colDiv);
    }

    lignesFacture.appendChild(nouvelleLigneFacture);
}
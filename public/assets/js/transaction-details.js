function addDestinationRow() {

    const container = document.getElementById("destination-field");

    const row = document.createElement("div");
    row.classList.add("destination-row");

    const label = document.createElement("label");
    label.textContent = "Compte destinataire : ";

    const input = document.createElement("input");
    input.type = "text";
    input.name = "compte_destination[]";

    const removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.textContent = "-";

    removeButton.addEventListener("click", function () {
        row.remove();
    });

    label.appendChild(input);
    row.appendChild(label);
    row.appendChild(removeButton);

    container.appendChild(row);
}

document.addEventListener("DOMContentLoaded", function () {

    const typeOperation = document.getElementById("type_operation");
    const clientDestination = document.getElementById("client_destination");
    const btnAdd = document.getElementById("btn-add");

    if (!typeOperation || !clientDestination) {
        return;
    }

    function verifierTypeOperation() {

        const isTransfer = typeOperation.value === "1";

        clientDestination.disabled = !isTransfer;

        const div = document.getElementById("frais-container");

        if (isTransfer) {

            div.innerHTML = "";

            const libelle = document.createElement("label");
            libelle.textContent = "Voulez-vous inclure les frais de transfert ?";

            const yesInput = document.createElement("input");
            yesInput.type = "radio";
            yesInput.name = "frais";
            yesInput.value = "1";

            const yesLabel = document.createElement("label");
            yesLabel.appendChild(yesInput);
            yesLabel.append(" Oui ");

            const noInput = document.createElement("input");
            noInput.type = "radio";
            noInput.name = "frais";
            noInput.value = "0";
            noInput.checked = true;

            const noLabel = document.createElement("label");
            noLabel.appendChild(noInput);
            noLabel.append(" Non");

            div.appendChild(libelle);
            div.appendChild(document.createElement("br"));
            div.appendChild(yesLabel);
            div.appendChild(noLabel);

            document.querySelectorAll('input[name="frais"]').forEach(radio => {

                radio.addEventListener("change", function () {

                    if (this.value === "1") {

                        const montant = document.getElementById("montant").value;

                        fetch(
                            `transaction/montant-a-payer?montant=${encodeURIComponent(montant)}&type_operation_id=${encodeURIComponent(typeOperation.value)}&numero=${encodeURIComponent(clientDestination.value)}`
                        )
                        .then(response => response.json())
                        .then(data => {

                            document.getElementById("montant-a-payer").textContent =
                                "Montant à payer : " + data.montant_a_payer;

                        });

                    } else {

                        document.getElementById("montant-a-payer").textContent = "";

                    }

                });

            });

        } else {

            div.innerHTML = "";
            clientDestination.value = "";
            document.getElementById("montant-a-payer").textContent = "";

        }
    }

    verifierTypeOperation();

    typeOperation.addEventListener("change", verifierTypeOperation);

    if (btnAdd) {
        btnAdd.addEventListener("click", addDestinationRow);
        btnAdd.addEventListener("click", function () {
            const destinationField = document.getElementById("client_destination");
            destinationField.disabled = true;
        });
    }

});
document.addEventListener("DOMContentLoaded", function () {
    const typeOperation = document.getElementById("type_operation");
    const clientDestination = document.getElementById("client_destination");

    if (!typeOperation || !clientDestination) {
        return;
    }

    function verifierTypeOperation() {
        const isTransfer = typeOperation.value === "1";
        clientDestination.disabled = !isTransfer;

        
        const div = document.getElementById("frais-container");
        
        if (isTransfer) {
            const libelle = document.createElement("label");
            libelle.textContent = "Voulez vous inclure les frais de transfert ?";
            
            const yesLabel = document.createElement("label");
            yesLabel.textContent = "Oui";
            const yesInput = document.createElement("input");
            yesInput.type = "radio";
            yesInput.name = "frais";
            yesInput.value = "1";
            
            const noLabel = document.createElement("label");
            noLabel.textContent = "Non";
            const noInput = document.createElement("input");
            noInput.type = "radio";
            noInput.name = "frais";
            noInput.value = "0";
            
            const br = document.createElement("br");

            div.innerHTML = "";
            div.appendChild(libelle);
            div.appendChild(yesLabel);
            div.appendChild(yesInput);
            div.appendChild(br);
            div.appendChild(noLabel);
            div.appendChild(noInput);
        } else {
            div.innerHTML = "";
        }

        if (!isTransfer) {
            clientDestination.value = "";
        }

        document.querySelectorAll('input[name="frais"]').forEach(radio => {
            radio.addEventListener('change', function() {

                if (this.value === "1") {

                    const montant = document.getElementById("montant").value;

                    fetch(`transaction/montant-a-payer?montant=${encodeURIComponent(montant)}&type_operation=${encodeURIComponent(typeOperation.value)}&numero=${encodeURIComponent(document.getElementById("client_destination").value)}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);

                            document.getElementById("montant-a-payer").textContent =
                                "Montant à payer : " + data.montant_a_payer;
                            
                                // const btnSubmit = document.getElementById("btn-submit");
                                // if (Number(data.montant_a_payer) > Number(montant)) {
                                //     btnSubmit.disabled = true;
                                // } else {
                                //     btnSubmit.disabled = false;
                                // }
                        });
                }

            });
        });
    }

    verifierTypeOperation();
    typeOperation.addEventListener("change", verifierTypeOperation);
});
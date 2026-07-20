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

            div.innerHTML = `
                <label class="mm-radio-title">
                    Inclure les frais de retrait ?
                </label>

                <div class="mm-radio-group">

                    <label class="mm-radio">
                        <input type="radio" name="frais" value="1">
                        <span>Oui</span>
                    </label>

                    <label class="mm-radio">
                        <input type="radio" name="frais" value="0" checked>
                        <span>Non</span>
                    </label>

                </div>
            `;

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

                    fetch(`transaction/montant-a-payer?montant=${encodeURIComponent(montant)}&type_operation=${encodeURIComponent(typeOperation.value)}&numero=${encodeURIComponent(document.getElementById("client_destination").value)}&destinations=${encodeURIComponent(document.getElementById('compte_destinations').value)}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById("montant-a-payer").textContent =
                                "Montant à payer (avec frais) : " + ((data && data.montant_a_payer) ? data.montant_a_payer.toFixed(2) : 0);
                        });
                } else {
                    document.getElementById("montant-a-payer").innerHTML = "";
                }

            });
        });
    }

    verifierTypeOperation();
    typeOperation.addEventListener("change", verifierTypeOperation);
});
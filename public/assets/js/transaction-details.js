document.addEventListener("DOMContentLoaded", function() {
    const type_operation = document.getElementById("type_operation");
    const client_destination = document.getElementById("client_destination");

    function verifierTypeOperation() {
        console.log("Valeur actuelle :", type_operation.value);

        if (type_operation.value == 1) {
            client_destination.disabled = false;
        } else {
            client_destination.disabled = true;
            client_destination.value = "";
        }
    }

    verifierTypeOperation();

    type_operation.addEventListener("change", verifierTypeOperation);
});
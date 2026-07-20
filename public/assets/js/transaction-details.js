document.addEventListener("DOMContentLoaded", function () {
    const typeOperation = document.getElementById("type_operation");
    const clientDestination = document.getElementById("client_destination");

    if (!typeOperation || !clientDestination) {
        return;
    }

    function verifierTypeOperation() {
        const isTransfer = typeOperation.value === "1";
        clientDestination.disabled = !isTransfer;

        if (!isTransfer) {
            clientDestination.value = "";
        }
    }

    verifierTypeOperation();
    typeOperation.addEventListener("change", verifierTypeOperation);
});
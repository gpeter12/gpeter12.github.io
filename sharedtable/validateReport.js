function validateForm() {
    console.info("Validating form!");
    if(document.getElementById("errorDescription").value.length > 8000){
        alert("HIBA! Nem írhatsz többet a hibaleírásba 8000 karakternél!");
        return false;
    }
    if(document.getElementById("errorLog").value.length > 200000){
        alert("HIBA! Nem írhatsz többet a log file helyére 200000 karakternél!");
        return false;
    }
    return true;
}
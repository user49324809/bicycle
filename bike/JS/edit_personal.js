//редактирвоание блока
function enableEdit() {
    document.getElementById("profileView").style.display = "none";
    document.getElementById("profileEdit").style.display = "block";
}

function cancelEdit() {
    document.getElementById("profileEdit").style.display = "none";
    document.getElementById("profileView").style.display = "block";
}

function saveEdit() {
    const newName = document.getElementById("nameInput").value;
    const newEmail = document.getElementById("emailInput").value;
    document.getElementById("nameDisplay").textContent = "Привет: " + newName;
    document.getElementById("emailDisplay").textContent = "Email: " + newEmail;
    document.getElementById("profileEdit").style.display = "none";
    document.getElementById("profileView").style.display = "block";
}

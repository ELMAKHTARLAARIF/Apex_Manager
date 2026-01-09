
const typeSelect = document.querySelector('select[name="type"]');
console.log(typeSelect);
const joueurFields = document.getElementById('joueur-fields');
const coachFields = document.getElementById('coach-fields');

function toggleFields() {
    if (typeSelect.value === 'joueur') {
        joueurFields.style.display = 'block';
        coachFields.style.display = 'none';
    } else if (typeSelect.value === 'coach') {
        joueurFields.style.display = 'none';
        coachFields.style.display = 'block';
    } else {
        joueurFields.style.display = 'none';
        coachFields.style.display = 'none';
    }
}
const modal = document.getElementById("deleteModal");
const confirmBtn = document.getElementById("confirmDeleteBtn");

let teamIdToDelete = null;
const message = document.querySelector(".message");
function openModal(teamId, teamName) {
    teamIdToDelete = teamId;
    modal.classList.add("show");
    message.textContent = `Are you sure you want to delete ${teamName} ?`;
}

function closeModal() {
    modal.classList.remove("show");
    teamIdToDelete = null;
}

confirmBtn.addEventListener("click", () => {
    if (!teamIdToDelete) return;

    window.location.href =
        `../Equipe/delete_Equipe.php?id=${teamIdToDelete}`;
});
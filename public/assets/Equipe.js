
const typeSelect = document.querySelector('select[name="type"]');
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
function openDeleteModal() {
    const modal = document.getElementById("deleteModal");
    console.log(modal);
    modal.style.display = "flex";
}

function closeModal() {
    document.getElementById("deleteModal").style.display = "none";
}
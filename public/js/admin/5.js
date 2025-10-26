document.addEventListener('DOMContentLoaded', function() {
    const btnUsers = document.getElementById('btnUsers');
    const btnDeleted = document.getElementById('btnDeleted');
    const usersTable = document.getElementById('usersTable');
    const deletedTable = document.getElementById('deletedTable');

    btnUsers.addEventListener('click', () => {
        usersTable.style.display = 'block';
        deletedTable.style.display = 'none';
        btnUsers.classList.replace('btn-outline-secondary', 'btn-primary');
        btnDeleted.classList.replace('btn-primary', 'btn-outline-secondary');
    });

    btnDeleted.addEventListener('click', () => {
        usersTable.style.display = 'none';
        deletedTable.style.display = 'block';
        btnDeleted.classList.replace('btn-outline-secondary', 'btn-primary');
        btnUsers.classList.replace('btn-primary', 'btn-outline-secondary');
    });
});

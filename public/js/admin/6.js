document.addEventListener('DOMContentLoaded', () => {
    const recoverModal = document.getElementById('recoverUserModal');
    recoverModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget; // Button that triggered the modal
        const userId = button.getAttribute('data-id');
        const userName = button.getAttribute('data-name');

        // Populate modal fields
        document.getElementById('recover_user_id').value = userId;
        document.getElementById('recoverUserNameHeader').textContent = userName;
        document.getElementById('recoverUserNameBody').textContent = userName;

        // Set form action dynamically if needed
        document.getElementById('recoverForm').action = `/admin/manage-users/recovery/${userId}`;
    });
});

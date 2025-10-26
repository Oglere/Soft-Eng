document.addEventListener('DOMContentLoaded', () => {
    const deleteModal = document.getElementById('deleteUserModal');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const userId = button.getAttribute('data-id');
        const userName = button.getAttribute('data-name');

        // Set user name in modal
        document.getElementById('deleteUserName').textContent = userName;
        document.getElementById('deleteUserNameBody').textContent = userName;

        // Set form action dynamically
        document.getElementById('deleteForm').action = `/admin/manage-users/delete/${userId}`;
    });
});

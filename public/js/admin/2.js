document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Get user data from button attributes
            const userId = this.dataset.id;
            const first = this.dataset.first;
            const last = this.dataset.last;
            const usn = this.dataset.usn;
            const email = this.dataset.email;
            const role = this.dataset.role.toLowerCase();
            const status = this.dataset.status;

            // Fill modal fields
            document.getElementById('edit_first_name').value = first;
            document.getElementById('edit_last_name').value = last;
            document.getElementById('edit_usn').value = usn;
            document.getElementById('edit_email').value = email;

            // Set dropdowns dynamically
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_status').value = status;

            // Dynamically set form action
            const form = document.getElementById('editUserForm');
            form.action = `/admin/manage-users/edit/${userId}`;
        });
    });
});

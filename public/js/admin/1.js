document.getElementById('addUserForm').addEventListener('submit', function(e) {
      e.preventDefault();
      document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
      let hasError = false;
      const fields = ['first_name', 'last_name', 'email', 'password', 'role'];
      fields.forEach(field => {
          const value = document.getElementById(field).value.trim();
          if (!value) {
              document.getElementById('error-' + field).style.display = 'block';
              hasError = true;
          }
      });
      if (!hasError) alert('Form submitted successfully! (for testing only)');
  });

  // Populate Edit Modal (Display Only)
const editButtons = document.querySelectorAll('.btn-edit');
editButtons.forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('edit_first_name').value = this.dataset.first;
        document.getElementById('edit_usn').value = this.dataset.usn;
        document.getElementById('edit_last_name').value = this.dataset.last;
        document.getElementById('edit_email').value = this.dataset.email;
        document.getElementById('edit_role').value = this.dataset.role;
        document.getElementById('edit_status').value = this.dataset.status;
    });
});

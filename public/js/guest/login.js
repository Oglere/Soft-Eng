document.getElementById('searchForm').addEventListener('submit', function(e) {
    const searchInput = document.getElementById('srch').value.trim();
    const fromYear = document.getElementById('from-year').value.trim();
    const toYear = document.getElementById('to-year').value.trim();
    const checkboxes = document.querySelectorAll('input[name="document_types[]"]:checked');

    // Validate that at least one input is filled
    if (!searchInput && !fromYear && !toYear && checkboxes.length === 0) {
        alert('Please fill at least one field to search.');
        e.preventDefault(); // Prevent form submission
    }
});

const checkboxes = document.querySelectorAll('.chkbx');
checkboxes.forEach(chkbx => {
    chkbx.addEventListener('click', (e) => {
        if (e.target.tagName !== 'INPUT') {
            const checkbox = chkbx.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
        }
        const checkbox = chkbx.querySelector('input[type="checkbox"]');
        chkbx.style.backgroundColor = checkbox.checked ? '#8e0404' : '';
        const label = chkbx.querySelector('label');
        label.style.color = checkbox.checked ? 'white' : '';
    });
});
// resources/js/guest/login.js
console.log("Login JS loaded");


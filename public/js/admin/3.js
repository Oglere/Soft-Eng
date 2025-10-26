document.addEventListener('DOMContentLoaded', function () {
    const rowsPerPage = 10;
    const table = document.querySelector('#usersTable table');
    if (!table) return;

    const tbody = table.querySelector('tbody');
    const allRows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.querySelector('td'));
    const searchInput = document.querySelector('input[name="search"]');
    const roleFilter = document.querySelector('select[name="filter"]');
    const filterForm = document.querySelector('.filter-form');
    const paginationWrapper = document.querySelector('.pagination-wrapper');
    let filteredRows = [...allRows];
    let currentPage = 1;

    const paginationContainer = document.createElement('nav');
    paginationContainer.classList.add('mt-3');
    const paginationList = document.createElement('ul');
    paginationList.classList.add('pagination', 'justify-content-center');
    paginationContainer.appendChild(paginationList);
    paginationWrapper.innerHTML = '';
    paginationWrapper.appendChild(paginationContainer);

    // 🧭 Show page function
    function showPage(page) {
        filteredRows.forEach(row => row.style.display = 'none');
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRows = filteredRows.slice(start, end);
        visibleRows.forEach(row => row.style.display = '');
    }

    // 🧮 Update pagination buttons
    function updatePagination() {
        paginationList.innerHTML = '';
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;

        const prev = document.createElement('li');
        prev.classList.add('page-item', currentPage === 1 ? 'disabled' : '');
        prev.innerHTML = `<a class="page-link" href="#">Previous</a>`;
        prev.addEventListener('click', e => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
                updatePagination();
            }
        });
        paginationList.appendChild(prev);

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.classList.add('page-item', i === currentPage ? 'active' : '');
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener('click', e => {
                e.preventDefault();
                currentPage = i;
                showPage(currentPage);
                updatePagination();
            });
            paginationList.appendChild(li);
        }

        const next = document.createElement('li');
        next.classList.add('page-item', currentPage === totalPages ? 'disabled' : '');
        next.innerHTML = `<a class="page-link" href="#">Next</a>`;
        next.addEventListener('click', e => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
                updatePagination();
            }
        });
        paginationList.appendChild(next);
    }

    // 🧩 Apply filters
    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const roleValue = roleFilter.value;

        filteredRows = allRows.filter(row => {
            const first = row.cells[0]?.textContent.toLowerCase() || '';
            const last = row.cells[1]?.textContent.toLowerCase() || '';
            const email = row.cells[2]?.textContent.toLowerCase() || '';
            const role = row.cells[3]?.textContent.toLowerCase() || '';

            const matchesSearch =
                first.includes(searchTerm) ||
                last.includes(searchTerm) ||
                email.includes(searchTerm);

            const matchesRole =
                !roleValue ||
                (roleValue === '1' && role.includes('admin')) ||
                (roleValue === '2' && role.includes('student')) ||
                (roleValue === '3' && role.includes('teacher'));

            return matchesSearch && matchesRole;
        });

        currentPage = 1;
        showPage(currentPage);
        updatePagination();

        if (filteredRows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">No users found</td></tr>`;
        } else {
            tbody.innerHTML = '';
            filteredRows.forEach(row => tbody.appendChild(row));
        }
    }

    // 🧠 Bind filter form
    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        applyFilters();
    });

    // Initialize
    applyFilters();
});
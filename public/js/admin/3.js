document.addEventListener('DOMContentLoaded', function () {
    const rowsPerPage = 10;
    const table = document.querySelector('table');
    if (!table) return; // safety check

    const tbody = table.querySelector('tbody');
    let rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.querySelector('td'));
    let totalPages = Math.ceil(rows.length / rowsPerPage) || 1;
    let currentPage = 1;

    // Create pagination container
    const paginationContainer = document.createElement('nav');
    paginationContainer.classList.add('mt-3');
    const paginationList = document.createElement('ul');
    paginationList.classList.add('pagination', 'justify-content-center');
    paginationContainer.appendChild(paginationList);
    table.parentElement.appendChild(paginationContainer);

    function createEmptyRow() {
        const tr = document.createElement('tr');
        const td = document.createElement('td');
        td.colSpan = table.querySelectorAll('thead th').length || 6;
        td.innerHTML = "&nbsp;";
        tr.appendChild(td);
        tr.classList.add('empty-row');
        return tr;
    }

    function showPage(page) {
        rows.forEach(row => row.style.display = 'none');
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRows = rows.slice(start, end);
        visibleRows.forEach(row => row.style.display = '');

        // Clean old fillers
        tbody.querySelectorAll('.empty-row').forEach(r => r.remove());

        // Add placeholders if needed
        const missingRows = rowsPerPage - visibleRows.length;
        for (let i = 0; i < missingRows; i++) {
            tbody.appendChild(createEmptyRow());
        }
    }

    function updatePagination() {
        paginationList.innerHTML = '';

        // Previous
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

        // Page numbers
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

        // Next
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

    // Initialize pagination
    showPage(currentPage);
    updatePagination();
});

document.querySelectorAll('input[name="document_types[]"]').forEach(chk => {
    chk.addEventListener('change', () => document.getElementById('searchForm').submit());
});

document.querySelectorAll('.category-card input[type="checkbox"]').forEach(chk => {
    chk.addEventListener('change', () => {
        document.getElementById('searchForm').submit();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');

    dateFrom.addEventListener('change', () => {
        dateTo.min = dateFrom.value;
    });
});

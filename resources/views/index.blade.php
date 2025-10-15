@extends('layout.header')

@section('content')
    <div class="contents">
        {{-- Brand section --}}
        <div class="brand">
            <img src="{{ asset('storage/images/DARA.png') }}" alt="DARA Logo" class="logo">
            <div class="brand-text">
                Digital Academic Repository Archives
            </div>
        </div>

        {{-- Search form --}}
        <form id="searchForm" action="{{ url('/results') }}" method="get">
            <div class="search">
                <input id="search" name="search" type="text" placeholder="Search by Title or Keywords...">
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-search">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                </button>
            </div>

            <!-- 🗓️ Date Range Picker -->
            <div class="date-range">
                <div class="date-field">
                    <label for="date_from">From:</label>
                    <input type="date" id="date_from" name="date_from">
                </div>
                <div class="date-field">
                    <label for="date_to">To:</label>
                    <input type="date" id="date_to" name="date_to">
                </div>
            </div>

            <!-- 📂 Categories -->
            <div class="categories">
                @foreach (['Case Study', 'Proposal', 'Thesis', 'Capstone', 'System Studies'] as $type)
                    <label class="category-card">
                        <input type="checkbox" name="document_types[]" value="{{ $type }}" hidden>
                        <img src="{{ asset('images/' . strtolower(str_replace(' ', '_', $type)) . '.png') }}" alt="{{ $type }}">
                        <span>{{ $type }}</span>
                    </label>
                @endforeach
            </div>
        </form>

    </div>
@endsection

<script src="{{ asset('js/guest/header.js') }}"></script>
<script>
document.querySelectorAll('.category-card input[type="checkbox"]').forEach(chk => {
    chk.addEventListener('change', () => {
        document.getElementById('searchForm').submit();
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');

    dateFrom.addEventListener('change', () => {
        dateTo.min = dateFrom.value; // set min of "to" based on "from"
    });
});
</script>
<script>
    // Auto-submit when category is toggled
    document.querySelectorAll('input[name="document_types[]"]').forEach(chk => {
        chk.addEventListener('change', () => document.getElementById('searchForm').submit());
    });

    // Set min date for "to" when "from" changes
    document.addEventListener('DOMContentLoaded', function () {
        const from = document.getElementById('date_from');
        const to = document.getElementById('date_to');
        from.addEventListener('change', () => {
            to.min = from.value;
        });
    });
</script>

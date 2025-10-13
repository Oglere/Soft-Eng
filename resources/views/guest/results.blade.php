@extends('layout.header')

@section('content')
<style>
    /* ---- General Layout ---- */
    body {
        font-family: 'Inter', sans-serif;
        background: #f8f9fa;
    }

    .results-container {
        display: flex;
        gap: 20px;
        padding: 40px 60px;
        align-items: flex-start;
    }

    .leftSide {
        max-width: 300px;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        position: sticky;
        top: 20px;
        height: fit-content;
    }

    .rightSide {
        flex: 1;
        padding: 20px 30px;
        border-radius: 12px;
        min-height: 400px;
    }

    /* ---- Search Box ---- */
    .search {
        display: flex;
        align-items: center;
        background: #f1f3f5;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .search input {
        flex: 1;
        border: none;
        background: none;
        padding: 12px 14px;
        font-size: 15px;
        outline: none;
    }

    .search button {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 14px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .search button:hover {
        background: #0056b3;
    }

    /* ---- Year Filter ---- */
    .date {
        margin-top: 20px;
    }

    .date input[type="number"] {
        width: 45%;
        padding: 8px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        outline: none;
        font-size: 14px;
        transition: border 0.3s;
    }

    .date input:focus {
        border-color: #007bff;
    }

    .date label {
        margin: 0 5px;
        font-weight: bold;
        color: #666;
    }

    /* ---- Checkbox Group ---- */
    .righttag {
        margin-top: 25px;
    }

    .righttag p {
        font-weight: 600;
        margin-bottom: 10px;
    }

    .chkbx {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .chkbx input {
        margin-right: 10px;
        transform: scale(1.2);
    }

    .chkbx label {
        font-size: 14px;
        color: #444;
        cursor: pointer;
        transition: color 0.2s;
    }

    .chkbx label:hover {
        color: #007bff;
    }

    /* ---- Result List ---- */
    .rightSide ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .rightSide a {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
    }

    .rightSide a:hover {
        text-decoration: underline;
    }

    .gr {
        display: flex;
        justify-content: space-between;
        margin-top: 8px;
        font-size: 13px;
        color: #555;
    }

    .left1, .right1 {
        width: 48%;
    }

    .left1 strong, .right1 strong {
        color: #333;
    }

    /* ---- Responsive ---- */
    @media (max-width: 992px) {
        .results-container {
            flex-direction: column;
            padding: 20px;
        }

        .leftSide {
            width: 100%;
            position: relative;
        }
    }

    .category-card {
        width: 100px !important;
        height: 100px !important;
        border: 2px solid #0c1c43;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        background-color: white;
        transition: 0.3s;
        cursor: pointer;
        position: relative;
    }

    .category-card img {
        width: 60px !important; /* Smaller size */
        height: 60px !important;
        object-fit: contain;
        margin-bottom: 8px;
        filter: grayscale(10%);
    }

</style>

<style>
    .results-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .result-item {
        display: flex;
        margin-bottom: 20px;
        flex-direction: column;
        align-items: flex-start;
    }

    .result-title {
        font-size: 18px;
        color: #1a0dab;
        text-decoration: none;
    }

    .result-title:hover {
        text-decoration: underline;
    }

    .result-meta {
        color: #4d5156;
        font-size: 13px;
        margin-top: 3px;
    }

    .no-results {
        text-align: center;
        padding: 40px;
        color: gray;
    }
</style>




<div class="results-container">
    {{-- Left side filter form --}}
    <div class="leftSide">
        <form id="searchForm" action="{{ url('/results') }}" method="get">
            <div class="search">
                <input id="search" name="search" type="text" placeholder="Search by Title or Keywords..."
                    value="{{ request('search') }}"
                >
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
                    <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="date-field">
                    <label for="date_to">To:</label>
                    <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
            </div>

            <!-- 📂 Categories -->
            <div class="categories">
                @foreach (['Case Study', 'Proposal', 'Thesis', 'Capstone', 'System Studies'] as $type)
                    <label class="category-card {{ in_array($type, (array) request('document_types')) ? 'active' : '' }}">
                        <input type="checkbox" name="document_types[]" value="{{ $type }}" hidden
                            {{ in_array($type, (array) request('document_types')) ? 'checked' : '' }}>
                        <img src="{{ asset('storage/images/' . strtolower(str_replace(' ', '_', $type)) . '.jpg') }}" alt="{{ $type }}">
                        <span>{{ $type }}</span>
                    </label>
                @endforeach
            </div>
        </form>
    </div>

    {{-- Right side results --}}
    <div class="rightSide">
        <ul class="results-list">
            @forelse ($results as $doc)
                <li class="result-item">
                    <a href="{{ url('/study/' . $doc->document_id) }}" class="result-title">
                        {{ $doc->title }}
                    </a>
                    <div class="result-meta">
                        <span>{{ url('/study/' . $doc->document_id) }}</span><br>
                        <span>Date Submitted: {{ $doc->created_at->format('F d, Y') }}</span> —
                        <span>Author: {{ $doc->author }} ({{ $doc->student_id ?? 'N/A' }})</span> —
                        <span>Category: {{ $doc->type }}</span>
                    </div>
                </li>
            @empty
                <li class="no-results">No results found.</li>
            @endforelse
        </ul>
    </div>
</div>

<script>
    // Optional: auto-submit form on filter change
    document.querySelectorAll('input[name="document_types[]"]').forEach(chk => {
        chk.addEventListener('change', () => document.getElementById('searchForm').submit());
    });
</script>

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

@endsection

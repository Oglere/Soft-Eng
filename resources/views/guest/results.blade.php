@extends('layout.header')
<link rel="stylesheet" href="{{ asset('css/guest/result.css') }}">

@section('content')
<div class="results-container">

    {{-- 🧭 Left Sidebar (Filters) --}}
    <aside class="leftSide shadow-sm">
        <form id="searchForm" action="{{ url('/results') }}" method="get">

            <!-- 🔍 Search Bar -->
            <div class="searchs">
                <input id="search" name="search" type="text" placeholder="Search by Title or Keywords..."
                    value="{{ request('search') }}">
                <button type="submit" title="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-search">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                </button>
            </div>

            <!-- 🗓️ Date Range Picker -->
            <div class="filter-section">
                <h4 class="filter-heading">Date Range</h4>
                <div class="date-ranges">
                    <div class="date-fields">
                        <label for="date_from">From</label>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="date-fields">
                        <label for="date_to">To</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>
            </div>

            <!-- 📂 Categories -->
            <div class="filter-section">
                <h4 class="filter-heading">Categories</h4>
                <div class="categoriess">
                    @foreach (['Case Study', 'Proposal', 'Thesis', 'Capstone', 'System Studies'] as $type)
                        <label class="category-cards {{ in_array($type, (array) request('document_types')) ? 'active' : '' }}">
                            <input type="checkbox" name="document_types[]" value="{{ $type }}" hidden
                                {{ in_array($type, (array) request('document_types')) ? 'checked' : '' }}>
                            <span>{{ $type }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </form>
    </aside>

    {{-- 📚 Right Section (Results) --}}
    <section class="results-content">
        <h2 class="results-heading">Search Results</h2>

        @if (count($results))
            <ul class="results-list">
                @foreach ($results as $doc)
                    <li class="result-item">
                        <a href="{{ url('/study/' . $doc->document_id) }}" class="result-title">
                            {{ $doc->title }}
                        </a>
                        <div class="result-meta">
                            <span>📅 {{ $doc->created_at->format('F d, Y') }}</span>
                            <span>👤 {{ $doc->author }} ({{ $doc->student_id ?? 'N/A' }})</span>
                            <span>🏷️ {{ $doc->type }}</span>
                        </div>
                        <a href="{{ url('/study/' . $doc->document_id) }}" class="result-link">
                            View Document →
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="no-results">
                <p>No results found. Try adjusting your search or filters.</p>
            </div>
        @endif
    </section>
</div>
@endsection

<style>
/* 🌐 Overall Layout */
.results-container {
    display: flex;
    gap: 30px;
    padding: 10px 70px;
    min-height: 50vh;
}

/* 🧭 Sidebar */
.leftSide {
    background: white;
    border: 1px solid #d8e0f0;
    border-radius: 12px;
    padding: 25px 20px;
    width: 300px;
    position: sticky;
    top: 100px;
    height: fit-content;
    box-shadow: 0 2px 8px rgba(12, 28, 67, 0.08);
}

.filter-section {
    margin-top: 25px;
}

.filter-heading {
    color: #0c1c43;
    font-weight: 600;
    font-size: 15px;
    margin-bottom: 10px;
    border-left: 4px solid #0c1c43;
    padding-left: 8px;
}

/* 🔍 Search */
.searchs {
    display: flex;
    align-items: center;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid #0c1c43;
    background-color: white;
}

.searchs input {
    flex: 1;
    padding: 12px 15px;
    border: none;
    outline: none;
    font-size: 15px;
}

.searchs button {
    background-color: #0c1c43;
    border: none;
    padding: 12px 18px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.searchs button:hover {
    background-color: #1b2d66;
}

.searchs button svg {
    stroke: white;
}

/* 🗓️ Date Range */
.date-ranges {
    display: flex;
    gap: 12px;
}

.date-fields {
    display: flex;
    flex-direction: column;
}

.date-fields label {
    font-size: 13px;
    color: #0c1c43;
    margin-bottom: 4px;
}

.date-fields input[type="date"] {
    border: 1.5px solid #0c1c43;
    border-radius: 6px;
    padding: 8px;
    font-size: 14px;
    color: #0c1c43;
    transition: 0.3s;
}

.date-fields input[type="date"]:hover,
.date-fields input[type="date"]:focus {
    background-color: #f0f5ff;
    border-color: #1b2d66;
}

/* 📂 Categories */
.categoriess {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.category-cards {
    border: 2px solid #0c1c43;
    border-radius: 8px;
    padding: 8px 10px;
    text-align: center;
    background: white;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    color: #0c1c43;
    transition: 0.3s;
    flex: 1 1 45%;
}

.category-cards:hover {
    background-color: #e6f0ff;
    transform: translateY(-3px);
}

.category-cards:has(input:checked),
.category-cards.active {
    background-color: #0c1c43;
    color: white;
    border-color: #0c1c43;
    box-shadow: 0 4px 8px rgba(12, 28, 67, 0.15);
}

/* 🧾 Results Section */
.results-content {
    flex: 1;
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 3px 10px rgba(12, 28, 67, 0.08);
}

.results-heading {
    font-size: 1.6rem;
    color: #0c1c43;
    font-weight: 700;
    border-bottom: 3px solid #0c1c43;
    padding-bottom: 10px;
    margin-bottom: 25px;
}

/* 🧩 Result Items */
.results-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.result-item {
    background-color: #f9fbff;
    border: 1px solid #e0e6f0;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    transition: 0.3s;
}

.result-item:hover {
    background-color: #eef3ff;
    border-color: #b9c7e6;
}

.result-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #0c1c43;
    text-decoration: none;
}

.result-title:hover {
    color: #1b2d66;
    text-decoration: underline;
}

.result-meta {
    font-size: 0.9rem;
    color: #555;
    margin: 0.6rem 0;
    display: flex;
    flex-wrap: wrap;
    gap: 1.2rem;
}

.result-link {
    font-size: 0.9rem;
    color: #007bff;
    font-weight: 500;
    text-decoration: none;
}

.result-link:hover {
    text-decoration: underline;
}

.no-results {
    text-align: center;
    padding: 2rem 0;
    color: #777;
    font-style: italic;
}


/* 📱 RESPONSIVE DESIGN */

/* 🧾 Medium screens (Tablets) */
@media (max-width: 992px) {
    .results-container {
        flex-direction: column;
        padding: 20px 40px;
    }

    .leftSide {
        position: static;
        width: 100%;
        order: 1;
        margin-bottom: 20px;
    }

    .results-content {
        order: 2;
        padding: 25px;
    }

    .date-ranges {
        flex-direction: column;
    }
}

/* 📱 Small screens (Mobile) */
@media (max-width: 600px) {
    .results-container {
        padding: 15px;
        gap: 15px;
    }

    .searchs input {
        font-size: 14px;
        padding: 10px;
    }

    .searchs button {
        padding: 10px 14px;
    }

    .filter-heading {
        font-size: 14px;
    }

    .category-cards {
        flex: 1 1 100%;
        font-size: 14px;
    }

    .results-heading {
        font-size: 1.3rem;
        text-align: center;
    }

    .result-item {
        padding: 15px;
    }

    .result-meta {
        flex-direction: column;
        gap: 6px;
    }

    .leftSide,
    .results-content {
        width: 100%;
        max-width: 350px;
        margin: 0 auto;
    }
    .date-fields input[type="date"] {
        font-size: 13px;
        padding: 6px;
    }
}

/* 📱 Very small devices */
@media (max-width: 400px) {
    .results-heading {
        font-size: 1.1rem;
    }

    .searchs input {
        font-size: 13px;
    }

    .results-content {
        padding: 20px;
    }

    .category-cards {
        padding: 6px 8px;
        font-size: 13px;
    }
}
</style>

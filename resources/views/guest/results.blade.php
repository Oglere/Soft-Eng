@extends('layout.header')
<link rel="stylesheet" href="{{ asset('css/guest/result.css') }}">

@section('content')
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
                        <img src="{{ asset('images/' . strtolower(str_replace(' ', '_', $type)) . '.png') }}" alt="{{ $type }}">
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
@endsection

<link rel="stylesheet" href="{{ asset('js/guest/result.js') }}">

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

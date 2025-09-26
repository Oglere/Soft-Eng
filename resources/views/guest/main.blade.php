@extends('layouts.header')

@section('content')

<div class="contents">

    <div class="brand">
        <img src="{{ asset('storage/images/DARA.png') }}" alt="DARA Logo" class="logo">
        <div class="brand-text">
            <h1 class="site-name">D A R A</h1>
            <p class="tagline">Digital Academic Repository and Archive</p>
        </div>
    </div>

    <form id="searchForm" action="/results" method="get">
        @csrf
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
    </form>


    <div class="categories">
        <div class="category-card">
            <img src="{{ asset('storage/images/case_study.jpg') }}" alt="Case Study">
            <span>Case Study</span>
        </div>
        <div class="category-card">
            <img src="{{ asset('storage/images/proposal.jpg') }}" alt="Proposal">
            <span>Proposal</span>
        </div>
        <div class="category-card">
            <img src="{{ asset('storage/images/thesis.jpg') }}" alt="Thesis">
            <span>Thesis</span>
        </div>
        <div class="category-card">
            <img src="{{ asset('storage/images/capston.jpg') }}" alt="Capstone">
            <span>Capstone</span>
        </div>
        <div class="category-card">
            <img src="{{ asset('storage/images/system_studies.jpg') }}" alt="System Studies">
            <span>System Studies</span>
        </div>
    </div>
</div>


@endsection

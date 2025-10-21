<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D.A.R.A Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
  <link rel="stylesheet" href="{{ asset('css/student/dashboard.css') }}">
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <h1>D.A.R.A</h1>

    <div class="navbar-right">
      <button>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
      </button>

      <div class="profile">
  
        <div class="profile-info">
          <p>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>

          <p>Student</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Layout -->
  <div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div>
        <div class="menu-section">
          <p class="menu-title">Menu</p>
          <div class="menu">
            <a href="<?php echo e(url('/student/dashboard')); ?>" class="active">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 10h4v11H3zM10 3h4v18h-4zM17 6h4v15h-4z" />
              </svg>
              Dashboard
            </a>
            <a href="<?php echo e(url('/student/submission')); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4" />
              </svg>
              Submit Studies
            </a>
            <a href="<?php echo e(url('/student/doc_status')); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 10h16M4 14h16M4 18h16" />
              </svg>
              Submitted Studies
            </a>
          </div>
        </div>

        <div class="menu-section">
          <p class="menu-title">Settings</p>
          <div class="menu">
            <a href="<?php echo e(url('/student/account_setting')); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 17.804A1 1 0 015 17V7a1 1 0 011-1h3.382a1 1 0 01.894.553l1.382 2.764a1 1 0 00.894.553H19a1 1 0 011 1v6a1 1 0 01-.121.496l-2.382 4.764a1 1 0 01-.894.553H6a1 1 0 01-.879-.496z" />
              </svg>
              Account
            </a>
           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
  @csrf
</form>

<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="inline-flex items-center gap-2">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
  </svg>
  Log out
</a>

          </div>
        </div>
      </div>
    </aside>

    <!-- Main -->
 <main class="main">
  <h2>Welcome, <?php echo e(auth()->user()->first_name); ?>! You have</h2>

  <div class="cards">
    <!-- Top row -->
    <div class="top-row">
      <a href="{{ route('student.doc_status') }}" class="card green">
        <p class="label">Submitted Studies</p>
        <p class="number">{{ $submittedStudies }}</p>
         <?xml version="1.0"?><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M480 128c0 8.188-3.125 16.38-9.375 22.62l-256 256C208.4 412.9 200.2 416 192 416s-16.38-3.125-22.62-9.375l-128-128C35.13 272.4 32 264.2 32 256c0-18.28 14.95-32 32-32c8.188 0 16.38 3.125 22.62 9.375L192 338.8l233.4-233.4C431.6 99.13 439.8 96 448 96C465.1 96 480 109.7 480 128z"/></svg>
      
      </a>

      <a href="{{ route('student.doc_status', ['status' => 'approved']) }}" class="card blue">
        <p class="label">Approved Studies</p>
        <p class="number">{{ $approvedStudies }}</p>
        <?xml version="1.0"?><svg data-name="Layer 1" id="Layer_1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title/><path d="M22.41,10.59,20.36,8.54V5.63a2,2,0,0,0-2-2H15.46l-2.05-2a2,2,0,0,0-2.82,0L8.54,3.64H5.63a2,2,0,0,0-2,2V8.54l-2,2.05A2,2,0,0,0,1,12a2,2,0,0,0,.58,1.41l2.06,2.05v2.91a2,2,0,0,0,2,2H8.54l2.05,2.05A2,2,0,0,0,12,23a2,2,0,0,0,1.41-.58l2.05-2.06h2.91a2,2,0,0,0,2-2V15.46l2.05-2.05a2,2,0,0,0,0-2.82Zm-4.05,4.05v3.72H14.64L12,21,9.36,18.36H5.64V14.64L3,12,5.64,9.36V5.64H9.36L12,3l2.64,2.64h3.72V9.36L21,12Z"/><polygon points="11 12.73 8.71 10.44 7.29 11.85 11 15.56 16.71 9.85 15.29 8.44 11 12.73"/></svg>
    
      </a>

      <a href="{{ route('student.doc_status', ['status' => 'pending']) }}" class="card orange">
        <p class="label">Pending Studies</p>
        <p class="number">{{ $pendingStudies }}</p>
<?xml version="1.0"?><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style></defs><title/><g data-name="83-book" id="_83-book"><path class="cls-1" d="M11,23H7.17A4.12,4.12,0,0,0,3,26.61,4,4,0,0,0,7,31h8"/><path class="cls-1" d="M3,27V5A4,4,0,0,1,7,1H29V13"/><circle class="cls-1" cx="23" cy="23" r="8"/><line class="cls-1" x1="27" x2="19" y1="23" y2="23"/></g></svg>  
      </a>
    </div>

    <!-- Bottom row -->
    <div class="bottom-row">
      <div class="spacer"></div> <!-- aligns "Revision" under Submitted+Approved -->
      <a href="{{ route('student.doc_status', ['status' => 'revision']) }}" class="card yellow">
        <p class="label">Revision(s) To Do</p>
        <p class="number">{{ $revisionsToDo }}</p>
        <?xml version="1.0"?><svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"><g id="book"><path d="M16,10.33c-2.21-.21-4.56-.33-7-.33V52c12.7,0,23,3.13,23,7" style="fill:none;stroke:#0a1c28;stroke-linejoin:round;stroke-width:2px"/><path d="M9,16H3V59H32V17c0-6.63-7.16-12-16-12V47c8.84,0,16,5.37,16,12" style="fill:none;stroke:#0a1c28;stroke-linejoin:round;stroke-width:2px"/><rect height="43" style="fill:none;stroke:#0a1c28;stroke-linejoin:round;stroke-width:2px" width="29" x="32" y="16"/><path d="M50,59,61,48H51a2,2,0,0,0-2,2v7a2,2,0,0,1-2,2" style="fill:none;stroke:#0a1c28;stroke-linejoin:round;stroke-width:2px"/><polygon points="46 30 46 13 38 13 38 30 42 28 46 30" style="fill:#0a1c28"/></g></svg>
   
      </a>
      <a href="{{ route('student.doc_status', ['status' => 'rejected']) }}" class="card red">
        <p class="label">Rejected Studies</p>
        <p class="number">{{ $rejectedStudies }}</p>
          <?xml version="1.0"?><svg viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><title/><g><path d="M48,0A48,48,0,1,0,96,48,48.0512,48.0512,0,0,0,48,0Zm0,84A36,36,0,1,1,84,48,36.0393,36.0393,0,0,1,48,84Z"/><path d="M64.2422,31.7578a5.9979,5.9979,0,0,0-8.4844,0L48,39.5156l-7.7578-7.7578a5.9994,5.9994,0,0,0-8.4844,8.4844L39.5156,48l-7.7578,7.7578a5.9994,5.9994,0,1,0,8.4844,8.4844L48,56.4844l7.7578,7.7578a5.9994,5.9994,0,0,0,8.4844-8.4844L56.4844,48l7.7578-7.7578A5.9979,5.9979,0,0,0,64.2422,31.7578Z"/></g></svg>
   
      </a>
    </div>
  </div>
</main>

  </div>
</body>
</html>

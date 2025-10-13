<div class="sidebar">
    <div class="menu-wrapper">
        <h2>Profile</h2>
    </div>
  <ul>
    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-house"></i> <span class="sidenav_name">Dashboard</span></a></li>
    <li><a href="{{ route('manageuser.index') }}"><i class="fas fa-users"></i> <span class="sidenav_name">Manage Users</span></a></li>
    <li><a href="{{ route('admin.storage') }}"><i class="fas fa-database"></i> <span class="sidenav_name">Storage</span></a></li>
    <li><a href="{{ route('admin.editacc') }}" class="disabled"><i class="fas fa-cog"></i> <span class="sidenav_name">Account Settings</span></a></li>
    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-sign-out-alt"></i> <span class="sidenav_name">Logout</span></a></li>
  </ul>
</div>

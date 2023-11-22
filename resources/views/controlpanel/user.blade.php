@php ($pageTitle = "User")
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item"><a href="/controlpanel/users">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">User</li>
  </ol>
</nav>

<div class="page-title">
	Users
</div>

@include('includes.footer')
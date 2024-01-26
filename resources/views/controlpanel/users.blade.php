@php ($pageTitle = "Users")
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item active" aria-current="page">Users</li>
  </ol>
</nav>

<div class="page-title">
	Users
</div>

<form class="cp-user-search" role="search">
  <input type="text" class="form-control" placeholder="Search Users" aria-label="Search Users" aria-describedby="searchHelp">
  <div id="searchHelp" class="form-text">Search by Username</div>
</form>

<table class="table control-panel-user-table">
  <thead>
    <tr>
      <th scope="col">User</th>
      <th scope="col">Email</th>
      <th scope="col">Registered</th>
      <th scope="col">Last Active</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($users as $u)
		<tr>
	      <td>
      		<div class="cp-list-member">
				<div class="cp-list-member-avatar">
					<a href="/controlpanel/user/{{ $u->username }}"><img src="{{asset('storage/avatars/' . $u->avatar)}}" /></a>
				</div>
				<div class="cp-list-member-meta">
					<h6><a href="/controlpanel/user/{{ $u->username }}">{{ $u->username }}</a></h6>
					<span>{{ $u->group }}</span>
				</div>
			</div>
		  </td>
	      <td>
	      	{{ $u->email }}
	      	@if ($u->email_verified_at != NULL)
	      		<i class="bi bi-patch-check"></i>
	      	@endif
	      </td>
	      <td>{{ $u->created_datetime }}</td>
	      <td>{{ $u->active_datetime }}</td>
	    </tr>
	@endforeach
  </tbody>
</table>

@include('includes.footer')
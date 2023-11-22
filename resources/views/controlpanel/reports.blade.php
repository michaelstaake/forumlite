@php ($pageTitle = "Reports")
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item active" aria-current="page">Reports</li>
  </ol>
</nav>

<div class="page-title">
	Reports
</div>

<ul class="list-group list-group-flush reports-all">
	<a href="#" class="list-group-item list-group-item-action notifications-item">
	  <h6>Reported User</h6>
	  <p>Exampleuser has commented on a discussion you are watching.</p>
	  <span>August 11th, 2023 at 4:44PM</span>
	</a>
	<a href="#" class="list-group-item list-group-item-action">
	  <h6>Reported Discussion</h6>
	  <p>Test has sent you a message titled "Something Random".</p>
	  <span>August 11th, 2023 at 4:44PM</span>
	</a>
	<a href="#" class="list-group-item list-group-item-action">
	  <h6>Reported Comment</h6>
	  <p>a_user has reported a comment.</p>
	  <span>August 11th, 2023 at 4:44PM</span>
	</a>
	<a href="#" class="list-group-item list-group-item-action">
	  <h6>Reported Message</h6>
	  <p>a_user has reported a comment.</p>
	  <span>August 11th, 2023 at 4:44PM</span>
	</a>
</ul>

@include('includes.footer')
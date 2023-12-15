@php ($pageTitle = "Categories")
@include('includes.header')

<div class="page-title">
	Categories
	@auth
        <div class="float-sm-end"><a class="btn btn-primary" href="newdiscussion" role="button"><i class="bi bi-pencil-square"></i> New Discussion</a></div><br>
    @endauth
</div>


		<div class="card forum-category-card">
			<div class="card-header">
				Example One
			</div>
			<ul class="list-group list-group-flush">
				<a href="category" class="list-group-item list-group-item-action">
					<h6><strong>Category A</strong></h6>
					<p>Categories are bold if signed in and it contains unread posts.</p>
					<span>118 discussions</span><span>37.2K comments</span><span>Most recent post on August 11th, 2023.</span>
				</a>
				<a href="category" class="list-group-item list-group-item-action">
					<h6>Category B</h6>
					<p>Just another category with a description. Woot!</p>
					<span>118 discussions</span><span>37.2K comments</span><span>Most recent post on August 11th, 2023.</span>
				</a>
			</ul>
		</div>

		<div class="card forum-category-card">
			<div class="card-header">
				Example Two
			</div>
			<ul class="list-group list-group-flush">
				<a href="category" class="list-group-item list-group-item-action">
					<h6>Category C</h6>
					<span>118 discussions</span><span>37.2K comments</span><span>Most recent post on August 11th, 2023.</span>
				</a>
				<a href="category" class="list-group-item list-group-item-action">
					<h6>Category D</h6>
					<p>You can have a description for a category, or you can choose not to. That's completely up to you.</p>
					<span>118 discussions</span><span>37.2K comments</span><span>Most recent post on August 11th, 2023.</span>
				</a>
			</ul>
		</div>




@include('includes.footer')
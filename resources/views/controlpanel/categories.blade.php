@php ($pageTitle = "Categories and Sections")
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categories and Sections</li>
  </ol>
</nav>

<div class="page-title">
	Categories and Sections
	<div class="float-sm-end"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sectionNewModal">New Section</button></div><br>
</div>

@foreach($sections as $s)
	<div class="card cp-category-card" id="{{ $s->slug }}">
		<div class="card-header">
			Section: <b>{{ $s->name }}</b> <i>({{ $s->slug }})</i> order {{ $s->order }}
			<div class="float-sm-end">
				<div class="dropdown">
					<button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-three-dots"></i>
					</button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sectionManageModal-{{ $s->id }}">Manage Section</a></li>
						<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sectionDeleteModal-{{ $s->id }}">Delete Section</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#categoryNewModal" data-bs-section="{{ $s->id }}">New Category</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card-body">
			
			<table class="table">
			  <tbody id="table-{{ $s->slug }}">
			   @foreach($categories as $c)
					@if ($c->section === "$s->id")
						<tr>
							<td>
								Category: <strong>{{ $c->name }}</strong>
								@if ($c->is_readonly != NULL)
									<i class="bi bi-lock"></i>
								@endif
								@if ($c->is_hidden != NULL)
									<i class="bi bi-eye-slash"></i>
								@endif
									<i>({{ $c->slug }})</i>
									order {{ $c->order }}
									<br>
									<p>{{ $c->description }}</p>
							</td>
					    	<td>
								<div class="float-sm-end">
									<div class="dropdown">
										<button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="bi bi-three-dots"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#categoryManageModal-{{ $c->id }}">Manage Category</a></li>
											<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#categoryDeleteModal-{{ $c->id }}">Delete Category</a></li>
										</ul>
									</div>
								</div>
							</td>
					    </tr>
					@endif
				</a>
				@endforeach
			  </tbody>
			</table>
		</div>
	</div>
	<br>
@endforeach

<!--<p>Drop and drop items to rearrange them, then click Save prior to making any other changes such as adding or editing sections or categories.</p>
<button type="button" class="btn btn-primary">Save</button>-->

<!-- #sectionNewModal -->
<div class="modal fade" id="sectionNewModal" tabindex="-1" aria-labelledby="sectionNewLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="{{ route('controlpanel.sectionNew') }}">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="sectionNewLabel">New Section</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        	<p>Sections are a top level organizational structure that contain categories.</p>
        	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="mb-3">
				<label for="name" class="form-label">Section Name</label>
				<input class="form-control" type="text" id="name" name="name">
			</div>
			<div class="mb-3">
				<label for="order" class="form-label">Order</label>
				<input class="form-control" type="number" id="order" name="order" aria-describedby="order_help" style="max-width:150px;" required>
				<div id="order_help" class="form-text">This field dictates the order in which this item will be displayed. Any number is valid, but if multiple items have the same order, the results may be unpredictable. Items are displayed smaller numbers first.</div>
			</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach($sections as $s)
<!-- #sectionManageModal -->
<div class="modal fade" id="sectionManageModal-{{ $s->id }}" tabindex="-1" aria-labelledby="sectionManageLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('controlpanel.sectionManage') }}" class="">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="sectionManageLabel">Manage Section</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" id="section_id" name="section_id" value="{{ $s->id }}" />
					<div class="mb-3">
						<label for="name" class="form-label">Name</label>
						<input class="form-control" type="text" id="name" name="name" value="{{ $s->name }}" >
					</div>
					<div class="mb-3">
						<label for="order" class="form-label">Order</label>
						<input class="form-control" type="number" id="order" name="order" value="{{ $s->order }}" aria-describedby="order_help" style="max-width:150px;" required>
						<div id="order_help" class="form-text">This field dictates the order in which this item will be displayed. Any number is valid, but if multiple items have the same order, the results may be unpredictable. Items are displayed smaller numbers first.</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- #sectionDeleteModal -->
<div class="modal fade" id="sectionDeleteModal-{{ $s->id }}" tabindex="-1" aria-labelledby="sectionDeleteLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('controlpanel.sectionDelete') }}" class="">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="sectionDeleteLabel">Delete Section</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete this section?</p>
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" id="section_id" name="section_id" value="{{ $s->id }}" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach

<!-- #categoryNewModal -->
<div class="modal fade" id="categoryNewModal" tabindex="-1" aria-labelledby="categoryNewLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="{{ route('controlpanel.categoryNew') }}">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="categorynNewLabel">New Category</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        	<p>Categories go within sections and contain discussions.</p>
        	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" name="section" id="section" value="" />
			<div class="mb-3">
				<label for="name" class="form-label">Name</label>
				<input class="form-control" type="text" id="name" name="name" required>
			</div>
			<div class="mb-3">
				<label for="description" class="form-label">Description</label>
				<textarea class="form-control" id="description" name="description"></textarea>
			</div>
			<div class="mb-3">
				<label for="order" class="form-label">Order</label>
				<input class="form-control" type="number" id="order" name="order" style="max-width:150px;" aria-describedby="order_help" required>
				<div id="order_help" class="form-text">This field dictates the order in which this item will be displayed. Any number is valid, but if multiple items have the same order, the results may be unpredictable. Items are displayed smaller numbers first.</div>
			</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach($categories as $c)
<!-- #categoryManageModal -->
<div class="modal fade" id="categoryManageModal-{{ $c->id }}" tabindex="-1" aria-labelledby="categoryManageLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('controlpanel.categoryManage') }}" class="">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="categoryManageLabel">Manage Section</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" id="category_id" name="category_id" value="{{ $c->id }}" />
					<div class="mb-3">
						<label for="name" class="form-label">Name</label>
						<input class="form-control" type="text" id="name" name="name" value="{{ $c->name }}" >
					</div>
					<div class="mb-3">
						<label for="description" class="form-label">Description</label>
						<textarea class="form-control" id="description" name="description">{{ $c->description }}</textarea>
					</div>
					<div class="mb-3">
						<label for="order" class="form-label">Order</label>
						<input class="form-control" type="number" id="order" name="order" value="{{ $c->order }}" style="max-width:150px;" aria-describedby="order_help" required>
						<div id="order_help" class="form-text">This field dictates the order in which this item will be displayed. Any number is valid, but if multiple items have the same order, the results may be unpredictable. Items are displayed smaller numbers first.</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- #categoryDeleteModal -->
<div class="modal fade" id="categoryDeleteModal-{{ $c->id }}" tabindex="-1" aria-labelledby="categoryDeleteLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('controlpanel.categoryDelete') }}" class="">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="categoryDeleteLabel">Delete Category</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete this category?</p>
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" id="category_id" name="category_id" value="{{ $c->id }}" />
					<div class="mb-3">
						<label for="do_what_with_discussions" class="form-label">And if so, what would you like to do with any discussions in this category?</label>
						<select class="form-select" id="do_what_with_discussions" name="do_what_with_discussions">
              				<option value="delete">Delete Discussions</option>
							@foreach ($categories as $cat)
								@if($cat->id != $c->id)
									<option value="{{ $cat->id }}">Move to: {{ $cat->name }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach

<script>
	const categoryNewModal = document.getElementById('categoryNewModal')
	if (categoryNewModal) {
		categoryNewModal.addEventListener('show.bs.modal', event => {
		const button = event.relatedTarget;
		const section = button.getAttribute('data-bs-section');
		const modalCategory = categoryNewModal.querySelector('#section');
		modalCategory.value = section;
		});
	}
</script>

@include('includes.footer')
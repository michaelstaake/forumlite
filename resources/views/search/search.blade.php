@php ($pageTitle = "Search")
@include('includes.header')

<div class="page-title">
	 Search
</div>

<div class="card search-form">
  <div class="card-body">
    <form method="post" action="{{ route('search.search') }}" class="" role="search">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <div class="row">
        <div class="col">
          <div class="input-group search-box">
            <input type="text text-lg" name="query" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="">
            <button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@include('includes.footer')
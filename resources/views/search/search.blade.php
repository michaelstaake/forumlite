@php ($pageTitle = "Search")
@include('includes.header')

<div class="page-title">
	 Search
</div>

<div class="card search-form">
  <div class="card-body">
    <form method="post" action="{{ route('search.showResults') }}" class="" role="search">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <input type="hidden" name="type" value="default" />
      <div class="row">
        <div class="col">
          <div class="input-group search-box">
            <input type="text text-lg" name="query" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="">
            <button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="checkSearchTitle" aria-describedby="checkSearchTitlesHelp">
            <label class="form-check-label" for="checkSearchTitle">
              Search Discussion Titles Only
            </label>
          </div>
          <div id="checkSearchTitlesHelp" class="form-text">By default, search includes discussion titles, discussion content, and comments. Selecting this option limits searches to discussion titles only.</div>
        </div>
        <div class="col">
          <div class="card">
            <div class="card-header">
              Categories
            </div>
            <div class="card-body">
              COMING SOON
              <div id="inputSearchCategoriesHelp" class="form-text">By default, all categories are searched. Pick categories here to override this behavior.</div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@include('includes.footer')
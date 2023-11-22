//@foreach($discussion as $d) @php ($pageTitle = $d->title)  @endforeach
//@php ($pageTitle = "Settings")

@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index">Home</a></li>
    <li class="breadcrumb-item"><a href="category">Category</a></li>
    <li class="breadcrumb-item active" aria-current="page">Discussion</li>
  </ol>
</nav>

<div class="page-title">
	 @foreach($discussion as $d) {{ $d->title }} @endforeach
	 @auth
        <div class="float-sm-end"><a class="btn btn-primary" href="newdiscussion" role="button"><i class="bi bi-pencil-square"></i> New Discussion</a></div><br>
    @endauth
</div>

<div class="row">
	<div class="col-9">
	</div>
	<div class="col-3">
        @include('includes.sidebar')
	</div>
</div>

@include('includes.footer')
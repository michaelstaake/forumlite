@php ($pageTitle = "Terms and Rules")

@include('includes.header')

<div class="page-title">
	Terms and Rules
</div>

<div class="row">
	<div class="col-9">
    <p>@foreach($content as $c) {{ $c->content}}  @endforeach</p>
	</div>
	<div class="col-3">
        @include('includes.sidebar')
	</div>
</div>

@include('includes.footer')
@php ($pageTitle = "Privacy Policy")

@include('includes.header')

<div class="page-title">
	Privacy Policy
</div>

<div class="row">
	<div class="col-9">
        <p>@foreach($content as $c) {{ $c->page}}  @endforeach</p>
	</div>
	<div class="col-3">
        @include('includes.sidebar')
	</div>
</div>

@include('includes.footer')
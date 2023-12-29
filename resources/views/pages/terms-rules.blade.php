@php ($pageTitle = "Terms and Rules")

@include('includes.header')

<div class="page-title">
	Terms and Rules
</div>

<div class="row">
	<div class="col">
    	<p>@foreach($content as $c) {!! $c->content !!}  @endforeach</p>
	</div>
</div>

@include('includes.footer')
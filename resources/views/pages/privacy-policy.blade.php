@php ($pageTitle = "Privacy Policy")

@include('includes.header')

<div class="page-title">
	Privacy Policy
</div>

<div class="row">
	<div class="col">
        <p>@foreach($content as $c) {!! $c->content !!}  @endforeach</p>
	</div>
</div>

@include('includes.footer')
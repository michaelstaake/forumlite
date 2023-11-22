@php ($pageTitle = "New Discussion")

@include('includes.header')

<script type="text/javascript" >
   $(document).ready(function() {
      $("#content").markItUp(mySettings);
   });
</script>

<div class="page-title">
	 New Discussion
</div>

<form method="post" action="{{ route('discussion.submit') }}" class="new-discussion-form">

  <input type="hidden" name="_token" value="{{ csrf_token() }}" />

  @if(isset($category))
    <div class="form-group mb-3">
      <label for="title">Category</label>
      <input type="hidden" class="form-control" name="category" value="@foreach($category as $cat){{ $cat->id }} @endforeach" required="required">
      <input type="text" class="form-control" name="" value="@foreach ($cat['section'] as $cs) {{ $cs->name }} @endforeach - @foreach($category as $cat){{ $cat->name }} @endforeach" disabled>
  </div>
  @else
      <div class="form-group mb-3">
        <label for="category">Category</label>
          <select class="form-select" name="category" aria-label="Category">
            <option selected disabled>Select a Category</option>
            @foreach($categories as $c)
            <option value="{{ $c->id }}">
              @foreach ($c['section'] as $cs) {{ $cs->name }} @endforeach - {{ $c->name }}</option>
            @endforeach
          </select>
      </div>
  @endif



  <div class="form-group mb-3">
      <label for="title">Title</label>
      <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="" required="required" autofocus>
  </div>

  <div class="form-group mb-3">
    <label for="content">Content</label>
    <textarea class="form-control" id="content" name="content" rows="10">{{ old('content') }}</textarea>
  </div>

  <button class="btn btn-lg btn-primary" type="submit">Submit</button>

</form>

@include('includes.footer')
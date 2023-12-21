@php ($pageTitle = "New Message")

@include('includes.header')

<script type="text/javascript" >
   $(document).ready(function() {
      $("#content").markItUp(mySettings);
   });
</script>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/messages">Messages</a></li>
    <li class="breadcrumb-item active" aria-current="page">New Message</li>
  </ol>
</nav>

<div class="page-title">
  New Message
</div>

<form method="post" action="{{ route('message.submit') }}" class="new-message-form">

  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  <input type="hidden" name="status" value="unread" />
  <input type="hidden" name="from" value="{{auth()->user()->id}}" />

  <div class="form-group mb-3" style="max-width:400px;">
      <label for="recipient">Recipient Username</label>
      <input type="text" class="form-control" name="to"
      @if (isset($recipient))
        value="{{ $recipient }}"
      @endif
      placeholder="" required="required" autofocus>
  </div>

  <div class="form-group mb-3" style="max-width:800px;">
      <label for="subject">Message Subject</label>
      <input type="text" class="form-control" name="subject" value="" placeholder="" required="required" autofocus>
  </div>

  <div class="form-group mb-3">
    <label for="content">Message Content</label>
    <textarea class="form-control" id="content" name="content" value="" rows="10"></textarea>
  </div>

  <button class="btn btn-lg btn-primary" type="submit">Submit</button>

</form>

<script type="text/javascript">
        var route = "{{ url('usersearch') }}";
        $('#search').typeahead({
            source: function (query, process) {
                return $.get(route, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            }
        });
    </script>

@include('includes.footer')
@foreach($member as $m) @php ($pageTitle = $m->username)  @endforeach
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item"><a href="/controlpanel/users">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $m->username }}</li>
  </ol>
</nav>

<div class="page-title">
    {{ $m->username }}
    @if ($m->is_banned == TRUE)
      <span class="badge bg-warning">Banned</span>
    @endif
    <div class="float-sm-end"><a class="btn btn-primary" href="/member/{{ $m->username }}" role="button"><i class="bi bi-binoculars"></i> View Profile</a></div><br>
</div>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        Discussions: <strong>{{ $m->numDiscussions }}</strong>&nbsp; &nbsp; &nbsp; Comments: <strong>{{ $m->numComments }}</strong>&nbsp; &nbsp; &nbsp;  Joined: <strong>{{ $m->dateTimeCreated }}</strong>&nbsp; &nbsp; &nbsp; Last Active: <strong>{{ $m->dateTimeActive }}</strong>
      </div>
    </div>
  </div>
</div>

<br>

<div class="row">
  <div class="col-3">
    
    @if ($m->group == "mod")
      <p>Group: <strong>Moderator</strong></p>
      <p><div id="group_help" class="form-text">Moderators have access to manage content, and limited permissions in terms of managing users, but control panel access is limited.</div></p>
    @elseif ($m->group == "admin")
    <p>Group: <strong>Administrator</strong></p>
      <p><div id="group_help" class="form-text">Administrators have full access to all functions of the forum.</div></p>
    @else
      <p>Group: <strong>Member</strong></p>
    @endif
    <p><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#changeGroupModal" aria-describedby="group_help">Change Group</button></p>
    <p><strong>Reset Password</strong></p>
    <p><div id="pw_help" class="form-text">Banned members will be limited to read-only access to the forum, but nothing is deleted.</div></p>
    <p><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#resetPasswordModal" aria-describedby="pw_help">Send Request</button></p>
    <p><strong>Ban</strong></p>
    <p><div id="ban_help" class="form-text">Banned members will be limited to read-only access to the forum, but nothing is deleted.</div></p>
    @if ($m->is_banned == TRUE)
      <p><button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#unbanModal" aria-describedby="ban_help">Unban Member</button></p>
    @else
      <p><button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#banModal" aria-describedby="nan_help">Ban Member</button></p>
    @endif
    
    <p><strong>Delete</strong></p>
    <p><div id="delete_help" class="form-text">Deleting a member also deletes all of their content, including discussions and comments.</div></p>
    <p><button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" aria-describedby="delete_help">Delete Member</button></p>
    
    
  </div>
  <div class="col-9">
    <div class="card">
      <div class="card-body">
        <form method="post" action="{{ route('controlpanel.settingsSubmit') }}" class="">
          <div class="row">
            <div class="col">
              <p><strong>Email</strong></p>
              <p><input type="text" class="form-control" aria-label="email" name="email" style="max-width: 350px;" value="" aria-describedby="email_help"></p>
              <div id="email_help" class="form-text">If you change the email here, it will NOT require email verification.</div>
            </div>
            <div class="col">
              <p><strong>Signature</strong></p>
              <p><textarea class="form-control" aria-label="signature" name="signature"></textarea></p>
              <p><strong>Location</strong></p>
              <p><input type="text" class="form-control" aria-label="location" name="location" style="max-width: 350px;" value=""></p>
            </div>
            <div class="col">
              <p><strong>Avatar</strong></p>
              <table class="table table-flush avatar-table">
                <tbody>
                  @foreach($avatars as $a)
                    <tr>
                      <td><input class="form-check-input" type="radio" name="avatar" value="{{ $a->filename }}" id="michael-default"
                        @if($m->avatar === $a->filename)
                          checked
                        @endif
                        ></td>
                      <td><img src="{{ asset('storage/avatars/') }}/{{ $a->filename }}" /></td>
                      @if($m->avatar === $a->filename)
                        <td>Current Avatar</td>
                      @else
                        @if($a->filename != $m->avatar->username.'-default.png')
                          <td><button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#avatarDeleteModal-{{ $a->filename }}">Delete</button></td>
                        @endif
                      @endif
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <hr>
          <button class="btn btn-primary" type="submit">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

@include('includes.footer')
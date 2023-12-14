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
    <p><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userModifyGroupModal" aria-describedby="group_help">Change Group</button></p>
    @if ($m->is_banned == TRUE)
      <p><strong>Unban</strong></p>
      <p><div id="ban_help" class="form-text">Member is currently banned and is limited to read-only access to the forum.</div></p>
    @else
      <p><strong>Ban</strong></p>
      <p><div id="ban_help" class="form-text">Banned members will be limited to read-only access to the forum, but nothing is deleted.</div></p>
    @endif
    @if ($m->is_banned == TRUE)
      <p><button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#userUnbanModal" aria-describedby="ban_help">Unban Member</button></p>
    @else
      <p><button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#userBanModal" aria-describedby="ban_help">Ban Member</button></p>
    @endif
    
    <p><strong>Delete</strong></p>
    <p><div id="delete_help" class="form-text">Deleting a member is permanent. You will not be able to delete a user that has any type of content associated with them, including discussions, comments, messages, and reports.</div></p>
    <p><button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#userDeleteModal" aria-describedby="delete_help">Delete Member</button></p>
    
    
  </div>
  <div class="col-9">
    <div class="card">
      <div class="card-body">
        <form method="post" action="{{ route('controlpanel.userSubmit') }}" class="">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <input type="hidden" id="username" name="username" value="{{ $m->username }}">
          <input type="hidden" id="user_id" name="user_id" value="{{ $m->id }}">
          <div class="row">
            <div class="col">
              <p><strong>Email</strong></p>
              <p><input type="text" class="form-control" aria-label="email" name="email" style="max-width: 350px;" value="{{ $m->email }}" aria-describedby="email_help"></p>
              <div id="email_help" class="form-text">If you change the email here, it will NOT require email verification.</div>
            </div>
            <div class="col">
              <p><strong>Signature</strong></p>
              <p><textarea class="form-control" aria-label="signature" name="signature">{{ $m->signature }}</textarea></p>
              <p><strong>Location</strong></p>
              <p><input type="text" class="form-control" aria-label="location" name="location" style="max-width: 350px;" value="{{ $m->location }}"></p>
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
                        @if($a->filename != $m->username.'-default.png')
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

@foreach($avatars as $a)
  	@if($a->filename != $m->username.'-default.png')
  	<!-- #avatarDeleteModal -->
  	<div class="modal fade" id="avatarDeleteModal-{{ $a->filename }}" tabindex="-1" aria-labelledby="avatarDeleteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="{{ route('controlpanel.userDeleteAvatar') }}" class="">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="avatarUploadLabel">Delete Avatar</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete avatar: {{ $a->filename }}</p>
              <input type="hidden" name="_token" value="{{ csrf_token() }}" />
              <input type="hidden" id="username" name="username" value="{{ $m->username }}">
              <input type="hidden" id="avatar" name="avatar" value="{{ $a->filename }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  	@endif
@endforeach

<!-- #userModifyGroupModal -->
<div class="modal fade" id="userModifyGroupModal" tabindex="-1" aria-labelledby="userModifyGroupLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="{{ route('controlpanel.userModifyGroup') }}" class="">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="userModifyGroupLabel">Modify User Group</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to change the user group for {{ $m->username }}?</p>
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <input type="hidden" id="username" name="username" value="{{ $m->username }}">
          <input type="hidden" id="user_id" name="user_id" value="{{ $m->id }}">
          <div class="mb-3">
            <label for="group" class="form-label">Group</label>
            <select class="form-select" id="group" name="group">
              <option value="member" 
              @if ($m->group == "member")
                selected
              @endif
              >Member</option>
              <option value="mod" 
              @if ($m->group == "mod")
                selected
              @endif
              >Moderator</option>
              <option value="admin" 
              @if ($m->group == "admin")
                selected
              @endif
              >Administrator</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- #userBanModal -->
<div class="modal fade" id="userBanModal" tabindex="-1" aria-labelledby="userBanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="{{ route('controlpanel.userBan') }}" class="">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="userBanLabel">Ban User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to ban {{ $m->username }}?</p>
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <input type="hidden" id="username" name="username" value="{{ $m->username }}">
          <input type="hidden" id="user_id" name="user_id" value="{{ $m->id }}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-warning">Ban</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- #userUnbanModal -->
<div class="modal fade" id="userUnbanModal" tabindex="-1" aria-labelledby="userUnbanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="{{ route('controlpanel.userUnban') }}" class="">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="userUnbanLabel">Unban User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to unban {{ $m->username }}?</p>
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <input type="hidden" id="username" name="username" value="{{ $m->username }}">
          <input type="hidden" id="user_id" name="user_id" value="{{ $m->id }}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-warning">Unban</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- #userDeleteModal -->
<div class="modal fade" id="userDeleteModal" tabindex="-1" aria-labelledby="userDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="{{ route('controlpanel.userDelete') }}" class="">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="userDeletenLabel">Delete User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this user?</p>
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <input type="hidden" id="username" name="username" value="{{ $m->username }}">
          <input type="hidden" id="user_id" name="user_id" value="{{ $m->id }}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

@include('includes.footer')
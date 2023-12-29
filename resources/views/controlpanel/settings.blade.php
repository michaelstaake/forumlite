@php ($pageTitle = "Settings")
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
  </ol>
</nav>

<div class="page-title">
	Settings
</div>

<ul class="nav nav-tabs" id="settingsTabs" role="tablist">
	<li class="nav-item" role="presentation">
		<button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="true">General Settings</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="pages-tab" data-bs-toggle="tab" data-bs-target="#pages-tab-pane" type="button" role="tab" aria-controls="pages-tab-pane" aria-selected="false">Pages</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="integration-tab" data-bs-toggle="tab" data-bs-target="#integration-tab-pane" type="button" role="tab" aria-controls="integration-tab-tab-pane" aria-selected="false">Integration</button>
	</li>
</ul>

<script type="text/javascript" >
   $(document).ready(function() {
      $("#termsContent").markItUp(mySettings);
	  $("#privacyContent").markItUp(mySettings);
   });
</script>

<form method="post" action="{{ route('controlpanel.settingsSubmit') }}" class="">

<input type="hidden" name="_token" value="{{ csrf_token() }}" />

<div class="tab-content" id="settingsTabsContent">
	<div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
		<br>
		<p><strong>General Settings</strong></p>
		<div class="mb-3 form-check">
			<input type="checkbox" class="form-check-input" id="can_register" name="can_register" value="yes" 
			@if($can_register == 'yes')
			checked
			@endif
			>
			<label class="form-check-label" for="can_register">Allow Registration</label>
		</div>
		<div class="mb-3 form-check">
			<input type="checkbox" class="form-check-input" id="can_signature" name="can_signature" value="yes" 
			@if($can_signature == 'yes')
			checked
			@endif
			>
			<label class="form-check-label" for="can_signature">Allow Signatures</label>
		</div>
		<p><strong>Maintenance Mode</strong></p>
		<p><select class="form-select" name="maintenance_mode" style="max-width:300px;" id="maintenanceMode">
			<option value="enabled" 
			@if($maintenance_mode == 'enabled')
			selected
			@endif
			>Enabled</option>
			<option value="disabled" 
			@if($maintenance_mode == 'disabled')
			selected
			@endif
			>Disabled</option>
		</select></p>
		<div class="mb-3">
			<label for="maintenance_message" class="form-label">Maintenance Mode Message</label>
			<input type="text" class="form-control" aria-describedby="maintenance_message_help" name="maintenance_message" value="{{ $maintenance_message }}" id="maintenanceMessage">
			<div id="maintenance_message_help" class="form-text">You can add a custom message here that will display if maintenance mode is enabled.</div>
		</div>
		<p><strong>Contact Link</strong></p>
		<p><select class="form-select" name="contact_type" style="max-width:300px;"  id="contactType">
			<option value="default" 
			@if($contact_type == 'default')
			selected
			@endif
			>Default Contact Page</option>
			<option value="custom"
			@if($contact_type == 'custom')
			selected
			@endif 
			>Custom Contact Link</option>
		</select></p>
		<div class="mb-3">
			<label for="contact_link" class="form-label">Default Contact Email</label>
			<input type="text" class="form-control" aria-describedby="contact_email_help" name="contact_email" value="{{ $contact_email }}"  id="contactEmail" style="max-width:300px;">
			<div id="contact_email_help" class="form-text">If you use the Default Contact Page, this is the email the contact form will submit to.</div>
		</div>
		<div class="mb-3">
			<label for="contact_link" class="form-label">Custom Contact Link</label>
			<input type="text" class="form-control" aria-describedby="contact_link_help" name="contact_link" value="{{ $contact_link }}"  id="contactLink">
			<div id="contact_link_help" class="form-text">If you wish to use a Custom Contact Link, enter the complete URL here, like https://www.example.com/contact.php</div>
		</div>
	</div>
	<div class="tab-pane fade" id="pages-tab-pane" role="tabpanel" aria-labelledby="pages-tab" tabindex="0">
		<br>
		<p>Here you can set the content for your <a href="/terms-rules" target="_blank">Terms and Rules</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a> pages. Forumlite requires users to check they agree to both upon registering and these links are always displayed in the footer as well.</p>
		<p><strong>Terms and Rules</strong></p>
		<p><textarea class="form-control" rows="10" name="terms_content" id="termsContent">{{ $terms_content }} </textarea></p>
		<p><strong>Privacy Policy</strong></p>
		<p><textarea class="form-control" rows="10" name="privacy_content" id="privacyContent">{{ $privacy_content }}</textarea></p>
	</div>
	<div class="tab-pane fade" id="integration-tab-pane" role="tabpanel" aria-labelledby="integration-tab" tabindex="0">
		<br>
		<p>Use the default header and footer or replace them with your own code to easily integrate your forum with the rest of your website or customize it.</p>
		<p><strong>Header</strong></p>
		<p><select class="form-select" style="max-width:300px;" name="header" id="headerSelect">
			<option value="default" 
			@if($header == 'default')
			selected
			@endif
			>Default</option>
			<option value="custom" 
			@if($header == 'custom')
			selected
			@endif
			>Custom</option>
		</select></p>
		<p><textarea class="form-control" rows="10" name="header_content" id="headerContent">{{ $header_content }}</textarea></p>
		<p><strong>Footer</strong></p>
		<p><select class="form-select" style="max-width:300px;" name="footer" id="footerSelect">
			<option value="default" 
			@if($footer == 'default')
			selected
			@endif
			>Default</option>
			<option value="custom" 
			@if($footer == 'custom')
			selected
			@endif
			>Custom</option>
		</select></p>
		<p><textarea class="form-control" rows="10" name="footer_content" id="footerContent">{{ $footer_content }}</textarea></p>
	</div>
</div>
<hr>
<p><button class="btn btn-primary" type="submit">Save</button></p>

</form>
	
<script>

const selectElementMaintenance = document.getElementById('maintenanceMode');
const inputElementMaintenance = document.getElementById('maintenanceMessage');
const selectElementContact = document.getElementById('contactType');
const inputElementContactLink = document.getElementById('contactLink');
const inputElementContactEmail = document.getElementById('contactEmail');

const selectElementHeader = document.getElementById('headerSelect');
const textareaElementHeader = document.getElementById('headerContent');
const selectElementFooter = document.getElementById('footerSelect');
const textareaElementFooter = document.getElementById('footerContent');

inputElementMaintenance.disabled = selectElementMaintenance.value === 'disabled';
inputElementContactLink.disabled = selectElementContact.value === 'default';

textareaElementHeader.disabled = selectElementHeader.value === 'default';
textareaElementFooter.disabled = selectElementFooter.value === 'default';

window.addEventListener('load', function() {
	if (selectElementMaintenance.value === 'disabled') {
		toggleInputArea('#maintenanceMessage', false);
	} else {
		toggleInputArea('#maintenanceMessage', true);
	}
	if (selectElementContact.value === 'default') {
		toggleInputArea('#contactLink', false);
		toggleInputArea('#contactEmail', true);
	} else {
		toggleInputArea('#contactLink', true);
		toggleInputArea('#contactEmail', false);
	}
	if (selectElementHeader.value === 'default') {
		toggleTextArea('#headerContent', false);
	} else {
		toggleTextArea('#headerContent', true);
	}
	if (selectElementFooter.value === 'default') {
		toggleTextArea('#footerContent', false);
	} else {
		toggleTextArea('#footerContent', true);
	}
});

selectElementMaintenance.addEventListener('change', function() {
  if (selectElementMaintenance.value === 'disabled') {
	toggleInputArea('#maintenanceMessage', false);
  } else {
	toggleInputArea('#maintenanceMessage', true);
  }
});

selectElementContact.addEventListener('change', function() {
  if (selectElementContact.value === 'default') {
	toggleInputArea('#contactLink', false);
	toggleInputArea('#contactEmail', true);
  } else {
	toggleInputArea('#contactLink', true);
	toggleInputArea('#contactEmail', false);
  }
});

selectElementHeader.addEventListener('change', function() {
  if (selectElementHeader.value === 'default') {
    toggleTextArea('#headerContent', false);
  } else {
    toggleTextArea('#headerContent', true);
  }
});

selectElementFooter.addEventListener('change', function() {
  if (selectElementFooter.value === 'default') {
    toggleTextArea('#footerContent', false);
  } else {
    toggleTextArea('#footerContent', true);
  }
});

function toggleInputArea(selector, state){
    let inputArea = document.querySelector(selector);
    if(state){
        inputArea.disabled = false;
        if(inputArea.hasAttribute("linked-data-copy")){
            let linkedData = document.querySelector('input[linked-data-from="'+selector+'"]');
            linkedData.remove();
            inputArea.removeAttribute("linked-data-copy");
        }
    }else{
        inputArea.disabled = true;
        inputArea.setAttribute("linked-data-copy", selector);
		inputArea.insertAdjacentHTML("afterend", `<input style="display:none;" name="${inputArea.name}" type="text" linked-data-from="${selector}" value="${inputArea.value}">`)
    }
}

function toggleTextArea(selector, state){
    let textArea = document.querySelector(selector);
    if(state){
        textArea.disabled = false;
        if(textArea.hasAttribute("linked-data-copy")){
            let linkedData = document.querySelector('textarea[linked-data-from="'+selector+'"]');
            linkedData.remove();
            textArea.removeAttribute("linked-data-copy");
        }
    }else{
        textArea.disabled = true;
        textArea.setAttribute("linked-data-copy", selector);
        textArea.insertAdjacentHTML("afterend", `<textarea style="display:none;" name="${textArea.name}" linked-data-from="${selector}">${textArea.value}</textarea>`)
    }
}
</script>

@include('includes.footer')
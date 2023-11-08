<form id="systemSettingsForm" action="{{ route('settings.edit_system') }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="row">
		<div class="col-md-8">
			<h3>System Settings</h3>
		</div>
		<div class="col-md-4 text-right">
			<button type="button" class="btn btn-default text-info" data-toggle="modal" data-target="#systemSettingsResetModal"><i class="fad fa-undo"></i> Reset</button>
			<button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Save</button>
		</div>
	</div>
	<hr>
    <div class="form-group">
        <input type="hidden" name="users_can_customize_ui" value="">
        <input id="usersCanCustomizeUI" type="checkbox" name="users_can_customize_ui" @if($systemSetting['users_can_customize_ui'] == '1') checked @endif data-bootstrap-switch value="1">
        <label for="usersCanCustomizeUI">Users can customize UI</label>
    </div>
    <div class="form-group">
        <input type="hidden" name="send_sms_notification" value="">
        <input id="sendSmsNotification" type="checkbox" name="send_sms_notification" @if($systemSetting['send_sms_notification'] == '1') checked @endif data-bootstrap-switch value="1">
        <label for="sendSmsNotification">Send SMS Notofication</label>
    </div>
    <div class="form-group">
        <input type="hidden" name="send_email_notification" value="">
        <input id="sendEmailNotification" type="checkbox" name="send_email_notification" @if($systemSetting['send_email_notification'] == '1') checked @endif data-bootstrap-switch value="1">
        <label for="sendEmailNotification">Send Email Notification</label>
    </div>
</form>
<div class="modal fade" id="systemSettingsResetModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-warning">@fa('fa fa-exclamation-triangle fa-lg') Alert</h4>
                <a href="javascript:void(0)" class="close" aria-hidden="true" data-dismiss="modal">&times;</a>
            </div>
            <div class="modal-body">
                <p class="text-left">
                    Are you sure do you want to <strong class="text-warning">RESET</strong> UI Settings to default?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="{{ route('settings.reset_system') }}" class="btn btn-primary">Yes</a>
            </div>
        </div>
    </div>
</div>
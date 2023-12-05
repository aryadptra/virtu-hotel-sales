<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4>WhatsApp Configuration</h4>
                        <h5>Please use your mobile phone in local format and no spaced, example : 6281941636578</h5>
                        <br>
                        <div class="form-group">
                            <label class="bold" for="whatsapp_url">API URL Endpoint : <i class="fa fa-question-circle"
                                    data-toggle="tooltip" data-title="Enter a mobile phone here"></i></label>
                            <br><input name="whatsapp_url" id="whatsapp_url" class="form-control"
                                value="<?php echo (get_option('whatsapp_url')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="bold" for="whatsapp_api_key">API Token: <i class="fa fa-question-circle"
                                    data-toggle="tooltip" data-title="Enter a mobile phone here"></i></label>
                            <br><input name="whatsapp_api_key" id="whatsapp_api_key" class="form-control"
                                value="<?php echo (get_option('whatsapp_api_key')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="bold" for="whatsapp_sender">Sender Number: <i class="fa fa-question-circle"
                                    data-toggle="tooltip" data-title="Enter a mobile phone here"></i></label>
                            <br><input name="whatsapp_sender" id="whatsapp_sender" class="form-control"
                                value="<?php echo (get_option('whatsapp_sender')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="bold" for="whatsapp_footer">Footer Message: <i class="fa fa-question-circle"
                                    data-toggle="tooltip" data-title="Enter your message"></i></label>
                            <br><textarea name="whatsapp_footer" id="whatsapp_footer" class="form-control"
                                rows="7"><?php echo (get_option('whatsapp_footer')); ?></textarea>
                        </div>

                        <div class="form-group">
                            <a href="#" onclick="save_settings(); return false;" id="btn-save-settings"
                                class="btn btn-success">Save Changes</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4>Test Messages</h4>
                        <h5>Please use your mobile phone in local format and no spaced, i.e: 081941636578</h5>
                        <br>
                        <div class="form-group">
                            <label class="bold" for="to">Destination Number : <i class="fa fa-question-circle"
                                    data-toggle="tooltip" data-title="Enter a mobile phone here"></i></label>
                            <br><input name="to" id="to" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="bold" for="msg">Message: <i class="fa fa-question-circle"
                                    data-toggle="tooltip" data-title="Enter your message"></i></label>
                            <br><textarea name="msg" id="msg" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <a href="#" id="btn-test-message" onclick="test_message(); return false;"
                                class="btn btn-success">Send Message</a>
                            <!-- <button type="submit" class="btn btn-success">Send Message</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>

<script>
function save_settings() {
    // Set button save settings disabled
    $('#btn-save-settings').attr('disabled', true);
    // Set button save settings text
    $('#btn-save-settings').text('Saving...');
    $.post(admin_url + 'whatsapp/save_settings', {
        whatsapp_url: $('#whatsapp_url').val(),
        whatsapp_api_key: $('#whatsapp_api_key').val(),
        whatsapp_sender: $('#whatsapp_sender').val(),
        whatsapp_footer: $('#whatsapp_footer').val(),
    }).done(function(response) {
        // Set button save settings text
        $('#btn-save-settings').text('Save Changes');
        // Set button save settings disabled
        $('#btn-save-settings').attr('disabled', false);
        alert_float('success', 'Settings saved');
    }).fail(function(data) {
        alert_float('danger', data.responseText);
    });
}

function test_message() {
    // Set button send message disabled
    $('#btn-test-message').attr('disabled', true);
    // Set button send message text
    $('#btn-test-message').text('Sending');
    $.post(admin_url + 'whatsapp/test_message', {
            to: $('#to').val(),
            msg: $('#msg').val(),
        }).done(function(response) {
            // Set button send message text
            $('#btn-test-message').text('Send Message');
            // Set button send message disabled
            $('#btn-test-message').attr('disabled', false);
            alert_float('success', 'Message sent');
        })
        .fail(function(data) {
            // Set button send message text
            $('#btn-test-message').text('Send Message');
            // Set button send message disabled
            $('#btn-test-message').attr('disabled', false);
            alert_float('danger', data.responseText);
        });
}
</script>
</body>

</html>
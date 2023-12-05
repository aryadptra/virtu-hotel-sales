<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>


<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4>Setup Template Message</h4>
                        <br>
                        <h5>Data yang dapat digunakan untuk template :</h5>
                        <div class="badge badge-warning">{{ company }}</div>
                        <div class="badge badge-warning">{{ invoice_number }}</div>
                        <div class="badge badge-warning">{{ invoice_link }}</div>
                        <div class="badge badge-warning">{{ invoice_total }}</div>
                        <div class="badge badge-warning">{{ invoice_due_date }}</div>
                    </div>
                </div>
                <div class="panel_s">
                    <div class="panel-body">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Invoice Created</a>
                            </li>
                            <li role="presentation">
                                <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Proposal Sent</a>
                            </li>
                            <li role="presentation">
                                <a href="#tab2" aria-controls="tab3" role="tab" data-toggle="tab">Payment Success</a>
                            </li>
                            <li role="presentation">
                                <a href="#tab2" aria-controls="tab4" role="tab" data-toggle="tab">New Leads</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Invoice Created</h4>
                                        <h5>Template message yang digunakan untuk mengirim pesan kepada klien ketika
                                            invoice dibuat</h5>
                                        <br>
                                        <div class="form-group">
                                            <label for="template_send_invoice">Template Message : </label>
                                            <textarea name="template_new_invoice" id="template_new_invoice" class="form-control" rows="20"><?php echo get_option('template_new_invoice'); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <a href="#" class="btn btn-success" id="btn-save-template-new-invoice" onclick="save_template_new_invoice(); return false;">Save Changes</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Test Messages</h4>
                                        <h5>Please use your mobile phone in local format and no spaced, i.e:
                                            081941636578</h5>
                                        <br>
                                        <div class="form-group">
                                            <label class="bold" for="to">Destination Number : <i class="fa fa-question-circle" data-toggle="tooltip" data-title="Enter a mobile phone here"></i></label>
                                            <br>
                                            <!-- Foreach client -->
                                            <select name="to" id="to-new-invoice" class="selectpicker" data-width="100%" data-none-selected-text="Select Client" data-live-search="true">
                                                <?php foreach ($clients as $client) { ?>
                                                    <option value="<?php echo $client['phonenumber']; ?>">
                                                        <?php echo $client['company']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <a href="#" id="btn-send-message-test-template-new-invoice" onclick="test_template_new_invoice(); return false;" class="btn btn-success">Send Message</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Proposal Sent</h4>
                                        <h5>Template message yang digunakan untuk mengirim pesan kepada klien ketika
                                            proposal dikirim melalui email</h5>
                                        <br>
                                        <div class="form-group">
                                            <label for="whatsapp_gateway_template_payment_success">Template
                                                Message : </label>
                                            <textarea name="whatsapp_gateway_template_payment_success" id="whatsapp_gateway_template_payment_success" class="form-control" rows="20"><?php echo get_option('whatsapp_gateway_template_payment_success'); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <a href="#" class="btn btn-success" id="btn-save-template-payment-success" onclick="save_template_payment_success(); return false;">Save
                                                Changes</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Test Messages</h4>
                                        <h5>Please use your mobile phone in local format and no spaced, i.e:
                                            081941636578</h5>
                                        <br>
                                        <div class="form-group">
                                            <label class="bold" for="to">Destination Number : <i class="fa fa-question-circle" data-toggle="tooltip" data-title="Enter a mobile phone here"></i></label>
                                            <br>
                                            <!-- Foreach client -->
                                            <select name="to" id="to-payment" class="selectpicker" data-width="100%" data-none-selected-text="Select Client" data-live-search="true">
                                                <?php foreach ($clients as $client) : ?>
                                                    <option value="<?= $client['phonenumber'] ?>"><?= $client['company'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <a href="#" id="btn-send-message-template-payment-success" onclick="send_whatsapp_template_payment_success(); return false;" class="btn btn-success">Send Message</a>
                                            <!-- <button type="submit" class="btn btn-success">Send Message</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Payment Success</h4>
                                        <h5>Template message yang digunakan untuk mengirim pesan kepada klien ketika
                                            berhasil melakukan pembayaran</h5>
                                        <br>
                                        <div class="form-group">
                                            <label for="whatsapp_gateway_template_payment_success">Payment
                                                Success</label>
                                            <textarea name="whatsapp_gateway_template_payment_success" id="whatsapp_gateway_template_payment_success" class="form-control" rows="20"><?php echo get_option('whatsapp_gateway_template_payment_success'); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <a href="#" class="btn btn-success" id="btn-save-template-payment-success" onclick="save_template_payment_success(); return false;">Save
                                                Changes</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Test Messages</h4>
                                        <h5>Please use your mobile phone in local format and no spaced, i.e:
                                            081941636578</h5>
                                        <br>
                                        <div class="form-group">
                                            <label class="bold" for="to">Destination Number : <i class="fa fa-question-circle" data-toggle="tooltip" data-title="Enter a mobile phone here"></i></label>
                                            <br>
                                            <!-- Foreach client -->
                                            <select name="to" id="to-payment" class="selectpicker" data-width="100%" data-none-selected-text="Select Client" data-live-search="true">
                                                <?php foreach ($clients as $client) : ?>
                                                    <option value="<?= $client['phonenumber'] ?>"><?= $client['company'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <a href="#" id="btn-send-message-template-payment-success" onclick="send_whatsapp_template_payment_success(); return false;" class="btn btn-success">Send Message</a>
                                            <!-- <button type="submit" class="btn btn-success">Send Message</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>

<!-- JS New Invoice -->
<script>
    function save_template_new_invoice() {
        // Set button to disable
        $('#btn-save-template-new-invoice').attr('disabled', true);
        $('#btn-save-template-new-invoice').text('Saving...');
        console.log($('#template_new_invoice').val());
        $.post(admin_url + 'whatsapp_gateway/save_template_new_invoice', {
            template_new_invoice: $('#template_new_invoice').val(),
        }).done(function(response) {
            alert_float('success', 'Data saved successfully');
            $('#btn-save-template-new-invoice').attr('disabled', false);
            $('#btn-save-template-new-invoice').text('Save Changes');
        }).fail(function(error) {
            alert_float('danger', 'Error saving data');
            $('#btn-save-template-new-invoice').attr('disabled', false);
            $('#btn-save-template-new-invoice').text('Save Changes');
        })
    }

    function test_template_new_invoice() {
        // Set button to disable
        $('#btn-send-message-test-template-new-invoice').attr('disabled', true);
        $('#btn-send-message-test-template-new-invoice').text('Sending...');
        console.log($('#to').val());
        $.post(admin_url + 'whatsapp_gateway/test_template_new_invoice', {
            to: $('#to-new-invoice').val()
        }).done(function(response) {
            alert_float('success', 'Message sent successfully');
            $('#btn-send-message-test-template-new-invoice').attr('disabled', false);
            $('#btn-send-message-test-template-new-invoice').text('Send Message');
        }).fail(function(error) {
            console.log(error);
            alert_float('danger', 'Message failed to send');
            $('#btn-send-message-test-template-new-invoice').attr('disabled', false);
            $('#btn-send-message-test-template-new-invoice').text('Send Message');
        });
    }
</script>

<!-- JS Payment Success -->
<script>
    function save_template_payment_success() {
        // Set button to disable
        $('#btn-save-template-payment-success').attr('disabled', true);
        $('#btn-save-template-payment-success').text('Saving...');
        $.post(admin_url + 'whatsapp_gateway/saveTemplatePaymentSuccess', {
            whatsapp_gateway_template_payment_success: $('#whatsapp_gateway_template_payment_success').val(),
        }).done(function(response) {
            alert_float('success', 'Data saved successfully');
            $('#btn-save-template-payment-success').attr('disabled', false);
            $('#btn-save-template-payment-success').text('Save Changes');
        });
    }

    function send_whatsapp_template_payment_success() {
        // Set button to disable
        $('#btn-send-message-template-payment-success').attr('disabled', true);
        $('#btn-send-message-template-payment-success').text('Sending...');
        $.post(admin_url + 'whatsapp_gateway/sendTestTemplatePaymentSuccess', {
                whatsapp_gateway_template_payment_success: $('#whatsapp_gateway_template_payment_success').val(),
            })
            .done(function(response) {
                alert_float('success', 'Message sent successfully');
                $('#btn-send-message-template-payment-success').attr('disabled', false);
                $('#btn-send-message-template-payment-success').text('Send Message');
                console.log(response)
            }).fail(function(error) {
                alert_float('danger', 'Message failed to send');
                $('#btn-send-message-template-payment-success').attr('disabled', false);
                $('#btn-send-message-template-payment-success').text('Send Message');
                console.log(error);
            });
    }
</script>

</body>

</html>
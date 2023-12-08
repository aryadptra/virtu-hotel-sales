<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="col-md-12">
            <div class="row">
                <div class="row _buttons tw-mb-2 sm:tw-mb-4">
                    <!-- <div class="col-md-8">
                        <a href="<?php echo admin_url('duitku_gateway/payment_method/syncronize') ?>" class="btn btn-primary pull-left new">
                            <i class="fa fa-refresh tw-mr-1"></i>
                            <?php echo _l('syncronize'); ?>
                        </a>
                    </div> -->
                </div>
                <div class="panel_s tw-mt-2 sm:tw-mt-4">
                    <div class="panel-body">
                        <h4 class="tw-mt-0 tw-font-semibold tw-text-lg">
                            Transactions
                        </h4>
                        <div class="panel-table-full">
                            <?php render_datatable([
                                _l('id'),
                                _l('payment_method'),
                                _l('payment_name'),
                                _l('payment_image'),
                                _l('total_fee'),
                            ], 'duitku_payment_methods'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function() {
        initDataTable('.table-duitku_payment_methods', window.location.href);
    });
</script>
</body>

</html>
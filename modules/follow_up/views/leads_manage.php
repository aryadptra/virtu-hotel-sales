<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row _buttons tw-mb-2 sm:tw-mb-4">
            <div class="col-md-8">
                <a href="#" class="btn btn-primary pull-left new">
                    <i class="fa-regular fa-plus tw-mr-1"></i>
                    <?php echo _l('follow_up'); ?>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body panel-table-full">
                        <?php render_datatable([
                            _l('number'),
                            _l('name'),
                        ], 'follow_up'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function() {
        initDataTable('.table-follow_up', window.location.href);
    });
</script>
</body>

</html>
<div role="tabpanel" class="tab-pane" id="lead_follow_up">
    <div class="row _buttons tw-mb-2 sm:tw-mb-4">
        <div class="col-md-8">
            <a href="#" class="btn btn-primary pull-left new">
                <i class="fa-regular fa-plus tw-mr-1"></i>
                <?php echo _l('follow_up'); ?>
            </a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <table class="table dt-table table-projects" data-order-col="2" data-order-type="desc">
                <thead>
                    <tr>
                        <th class="th-project-number">Number</th>
                        <th class="th-project-name">Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($follow_up as $data) {
                    ?>
                        <tr>
                            <td><?= $data['id'] ?></td>
                            <td><?= $data['name'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
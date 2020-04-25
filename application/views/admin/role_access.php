
<!-- Begin Page Content -->
    <div class="card shadow mb-4 mx-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Role : <?= $role['role'] ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?= $this->session->flashdata('message'); ?>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Access</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $n = 1;
                            foreach ($menu as $m) :
                        ?>
                            <tr>
                                <th scope="row"><?= $n ?></th>
                                <td><?= $m['menu'] ?></td>
                                <td>
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" <?= check_access($role['id_role'], $m['id_menu']);?> data-role="<?= $role['id_role']; ?>" data-menu="<?= $m['id_menu']; ?>">
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            $n ++;
                            endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- end content -->

<!-- End of Main Content -->


<script>
    $('.form-check-input').on('click', function() {
        const menu_id = $(this).data('menu');
        const role_id = $(this).data('role');

        $.ajax({
            url: '<?= base_url('Admin/change_access') ?>',
            type: 'POST',
            data: {
                menu_id: menu_id,
                role_id: role_id
            },
            success: function() {
                document.location.href = "<?= base_url('Admin/role_access/'); ?>" +role_id;
            }
        });
    });
</script>

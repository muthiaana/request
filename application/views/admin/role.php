
<!-- Begin Page Content -->
    <div class="card shadow mb-4 mx-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">List of users</h6> -->
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#Modal">Add Role</a>
                <?= form_error('menu', '<div class="alert alert-danger" role="alert">','</div>'); ?>
                <?= $this->session->flashdata('message'); ?>
                
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $n = 1;
                            foreach ($role as $r) :
                        ?>
                            <tr>
                                <th scope="row"><?= $n ?></th>
                                <td><?= $r['role'] ?></td>
                                <td>
                                    <a href="<?= base_url('Admin/role_access/'). $r['id_role']; ?>" class="badge badge-primary">Access</a>
                                    &nbsp;
                                    <a href="<?= base_url('Admin/role_delete/'). $r['id_role']; ?>" class="badge badge-danger">Delete</a>
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


<!-- modal -->
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Add New Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form method="POST" action="<?= base_url('Admin/role'); ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role">Role Name</label>
                            <input type="text" class="form-control" id="role" name="role" placeholder="Menu Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- modal -->
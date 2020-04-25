<!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message'); ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="<?= base_url('User/change_pass');?>" >
                    <div class="form-group">
                        <label for="oldpass">Current Password</label>
                        <input type="password" class="form-control" id="oldpass" name="oldpass" placeholder="Enter your current password">
                        <?= form_error('oldpass','<small class="text-danger pl-3">','</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="newpass">New Password</label>
                        <input type="password" class="form-control" id="newpass" name="newpass" placeholder="New Password">
                        <?= form_error('newpass','<small class="text-danger pl-3">','</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="newpass2">Confirm Password</label>
                        <input type="password" class="form-control" id="newpass2" name="newpass2" placeholder="Confirm New Password">
                        <?= form_error('newpass2','<small class="text-danger pl-3">','</small>'); ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->

<!-- End of Main Content -->
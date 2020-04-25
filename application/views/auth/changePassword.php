<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h2 text-gray-900">Change Password For</h1>
                                    <h5 class="mb-4"><?= $this->session->userdata('reset_email'); ?></h5>
                                    <?= $this->session->flashdata('message'); ?>
                                </div>

                                <form class="user" method="POST" action="<?= base_url('Auth/changePassword'); ?>">

                                    <div class="form-group">
                                      <input type="password" class="form-control form-control-user" id="pass1" name="pass1" placeholder="New Password">
                                      <?= form_error('pass1','<small class="text-danger pl-3">','</small>'); ?>
                                    </div>

                                    <div class="form-group">
                                      <input type="password" class="form-control form-control-user" id="pass2" name="pass2" placeholder="Confirm Password">
                                      <?= form_error('pass2','<small class="text-danger pl-3">','</small>'); ?>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                      Change Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
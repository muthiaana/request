<!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message'); ?>
            </div>
        </div>
        <!-- card -->
            <div class="card mb-3 col-lg-12">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/img/profile/') . $user['image'];  ?>" class="card-img" alt="Profile Image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $user['name'] ?></h5>
                            <p class="card-text"><?= $user['username'] ?></p>
                            <p class="card-text">Member Since : 
                                <small class="text-muted"><?= date('d F Y',strtotime($user['date_created'])); ?></small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <!-- end card -->

    </div>
<!-- /.container-fluid -->

<!-- End of Main Content -->
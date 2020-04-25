<!-- Begin Page Content -->
    <div class="container-fluid">   

        <div class="row">
            <div class="col-lg">
                <?= form_open_multipart('User/edit') ?>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                          <input type="username" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="name" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
                          <?= form_error('name','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">
                            picture
                        </div>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="<?= base_url('assets/img/profile/').$user['image'] ?>" class="img-thumbnail">
                                </div>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
            </div>
        </div>

    </div>
<!-- /.container-fluid -->

<!-- End of Main Content -->

<script>
    $('.custom-file-input').on('change', function() {
        let filename = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass('selected').html(filename);
    });
</script>
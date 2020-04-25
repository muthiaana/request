<!-- Begin Page Content -->
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-lg">
                <form method="POST" action="<?= base_url('Menu/menu_edit/').$menu['id_menu'] ?>">
                    <div class="form-group row">
                        <label for="menu" class="col-sm-2 col-form-label">Menu Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="menu" name="menu" value="<?= $menu['menu']; ?>">
                          <?= form_error('menu','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="icon" class="col-sm-2 col-form-label">icon</label>
                        <div class="col-sm-10">
                          <input type="icon" class="form-control" id="icon" name="icon" value="<?= $menu['icon']; ?>">
                          <?= form_error('icon','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
<!-- /.container-fluid -->

<!-- End of Main Content -->
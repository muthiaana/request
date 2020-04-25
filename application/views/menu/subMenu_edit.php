<!-- Begin Page Content -->
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-lg">
                <form method="POST" action="<?= base_url('Menu/submenu_edit/').$menuid['id_sub'] ?>">
                    
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Sub Menu Title" value="<?= $menuid['title'] ?>">
                        <?= form_error('title','<small class="text-danger pl-3">','</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="id_menu">Parent Menu</label>
                        <select name="id_menu" id="id_menu" class="form-control">
                            <option value="">select parent menu..</option>
                            <?php foreach ($menu as $m) :?>
                                <option value="<?=$m['id_menu']; ?>"><?=$m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_menu','<small class="text-danger pl-3">','</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="url">Url</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Url" value="<?= $menuid['url'] ?>">
                        <?= form_error('url','<small class="text-danger pl-3">','</small>'); ?>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" checked>
                            <label for="is_active" class="form-check-label">Status</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg">
                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
<!-- /.container-fluid -->

<!-- End of Main Content -->
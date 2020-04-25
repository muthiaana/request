<!-- Begin Page Content -->
	<div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <?= form_error('menu', '<div class="alert alert-danger" role="alert">','</div>'); ?>
                <?= $this->session->flashdata('message'); ?>
                
                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add Menu</a>
                
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Action</th>
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
                                <td><?= $m['icon'] ?></td>
                                <td>
                                    <a href="<?= base_url('Menu/menu_edit/'). $m['id_menu']; ?>" class="badge badge-primary">Edit</a>
                                    &nbsp;
                                    <a href="<?= base_url('Menu/menu_delete/'). $m['id_menu']; ?>" class="badge badge-danger">Delete</a>
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
<!-- /.container-fluid -->


<!-- End of Main Content -->

<!-- modal -->
    <div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form method="POST" action="<?= base_url('menu'); ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="menu">Menu Name</label>
                            <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name">
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="Icon Class">
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
 <!-- Begin Page Content -->
	<div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
            	<?php if (validation_errors()) : ?>
            		<div class="alert alert-danger" role="alert">
            			<?= validation_errors() ?>
            		</div>
            	<?php endif; ?>
                
                <?= $this->session->flashdata('message'); ?>
                
                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">Add SubMenu</a>
                
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Title</th>
                            <th scope="col">Parent Menu</th>
                            <th scope="col">Url</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $n = 1;
                            foreach ($subMenu as $sm) :
                        ?>
                            <tr>
                                <th scope="row"><?= $n ?></th>
                                <td><?= $sm['title'] ?></td>
                                <td><?= $sm['menu'] ?></td>
                                <td><?= $sm['url'] ?></td>
                                <td><?= $sm['status'] ?></td>
                                <td>
                                    <a href="<?= base_url('Menu/submenu_edit/'). $sm['id_sub']; ?>" class="badge badge-primary">Edit</a>
                                    &nbsp;
                                    <a href="<?= base_url('Menu/submenu_delete/'). $sm['id_sub']; ?>" class="badge badge-danger">Delete</a>
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
    <div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="newSubMenuModalLabel">Add New SubMenu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form method="POST" action="<?= base_url('menu/subMenu'); ?>">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Sub Menu Title">
                        </div>

						<div class="form-group">
							<label for="id_menu">Parent Menu</label>
							<select name="id_menu" id="id_menu" class="form-control">
								<option value="">Select Menu</option>
								<?php foreach ($menu as $m) :?>
									<option value="<?=$m['id_menu']; ?>"><?=$m['menu']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
                            <label for="url">Url</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Url">
                        </div>

                        <div class="form-group">
                        	<div class="form-check">
                        		<input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" checked>
                        		<label for="is_active" class="form-check-label">Status</label>
                        	</div>
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
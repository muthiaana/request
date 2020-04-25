<div class="container-fluid">
<form action="<?php echo base_url("KategoriMasalah/submit"); ?>" method="POST">
	
	<div class="form-group">
      <label >kategori</label>
      <input type="text" name="id_kat_masalah" class="form-control" placeholder="ID" value="<?php echo(isset($data_masalah[0]->id_kat_masalah)? $data_masalah[0]->id_kat_masalah:''); ?>"" readonly>
    </div>

	<div class="form-group">
      <label >kategori Masalah</label>
      <input type="text" name="kategorimasalah" class="form-control" placeholder="KategoriMasalah" value="<?php echo(isset($data_masalah[0]->kategorimasalah)? $data_masalah[0]->kategorimasalah:''); ?>">
    </div>
    
<button type="submit" class="btn btn-primary" href="<?php echo base_url("KategoriMasalah/show_list_masalah"); ?>">Submit</button>	
</form>
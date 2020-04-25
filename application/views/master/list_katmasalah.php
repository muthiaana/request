<div class="container-fluid">
<body>
<table class="table">

<br>
<a type="button" class="btn btn-success" href="<?php  echo base_url(); ?>KategoriMasalah/index">Add Request
</a>

<br>
<br>

	<tr>
		<th>No</th>
		<th>Kategori Masalah</th>
		<th>Nama Kategori Masalah</th>
		<th>Action</th>
	</tr>

<?php
$no=1;
foreach ($master as $value) {
	
?>
	<tr>
		<td><?php echo $no++;?></td>
		<td><?php echo $value->id_kat_masalah;?></td>
		<td><?php echo $value->kategorimasalah;?></td>
		<td>
			<a class="btn btn-warning btn-link" href="<?php echo site_url('KategoriMasalah/hapus_masalah/').$value->id_kat_masalah;?>" onclick="return confirm('Are you sure?')">Hapus</a>
			<a class="btn btn-info btn-link" href="<?php echo site_url('KategoriMasalah/edit_masalah/').$value->id_kat_masalah;?>">Edit</a>
		</td>
	</tr>
<?php } ?>

</tr>
</table>
</body>
</div>

<!-- <div class="container-fluid">
<body>
<table class="table">
	<tr>
		<th>No</th>
		<th>Kategori Masalah</th>
		<th>Nama Kategori Masalah</th>
	</tr>
<?php
$no=1;
foreach ($master as $value) {
	
?>	
	<tr>
		<td><?php echo $no++;?></td>
		<td><?php echo $value->id_kat_masalah;?></td>
		<td><?php echo $value->kategorimasalah;?></td>
		<td>
			<a class="btn btn-warning btn-link" href="<?php echo site_url('C_insertuser/hapus_user/').$value->iduser;?>" onclick="return confirm('Are you sure?')">Hapus</a>
			<a class="btn btn-info btn-link" href="<?php echo site_url('C_insertuser/edit_user/').$value->namauser;?>">Edit</a>
		</td>
	</tr>
<?php } ?>

</tr>
</table>
</body>
</div>
 -->
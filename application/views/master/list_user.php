<div class="container-fluid">
<body>
<table class="table">

<br>
<a type="button" class="btn btn-success" href="<?php  echo base_url(); ?>NewUser/index">Add
</a>
<br>
<br>

	<tr>
		<th>No</th>
		<th>Id User</th>
		<th>Nama</th>
		<th>Username</th>
		<th>Image</th>
		<th>Tanggal Input</th>
		<th>Action</th>
	</tr>
<?php
$no=1;
foreach ($master as $value) {
	
?>	
	<tr>
		<td><?php echo $no++;?></td>
		<td><?php echo $value->id_user;?></td>
		<td><?php echo $value->name;?></td>
		<td><?php echo $value->username;?></td>
		<td><?php echo $value->image;?></td>
		<td><?php echo $value->date_created;?></td>
		<td>
			<a class="btn btn-warning btn-link" href="<?php echo site_url('NewUser/hapus_user/').$value->id_user;?>" onclick="return confirm('Are you sure?')">Delete</a>
			<a class="btn btn-info btn-link" href="<?php echo site_url('NewUser/edit_user/').$value->id_user;?>">Edit</a>
		</td>
	</tr>
<?php } ?>

</tr>
</table>
</body>
</div>
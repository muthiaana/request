<div class="container-fluid">
<body>
<table class="table">
		<?php 
			if($this->session->userdata('id_role') != 3)
			{

		?>
<br>
<a type="button" class="btn btn-primary" href="<?php  echo base_url(); ?>Request/index">Add Request
</a>


<br>
<br>
		<?php } ?>
	<tr>
		<th>No</th>
		<th>No Tiket</th>
		<th>Nama User</th>
		<th>Keterangan Masalah</th>
		<th>kategori Masalah</th>
        <th>Tanggal</th> 
        <th>Prioritas</th>
		<th>Status</th>
        <th>IT Support</th>
        <th>Barang</th>
        <th>Started</th>
        <th>Finished</th>
        <th>Action</th>
	</tr>

<?php
$no=1;
foreach ($Request as $value) {
	
?>
	<tr>
		<td><?php echo $no++;?></td>
		<td><?php echo $value->NoTiket;?></td>
		<td><?php echo $value->username;?></td>
        <td><?php echo $value->ketmasalah;?></td>
		<td><?php echo $value->kategorimasalah;?></td>
		<td><?php echo $value->tanggal;?></td>
		<td><?php echo $value->prioritas;?></td>
	 	<td><?php echo $value->Status;?></td>
	 	<td align="center">
		 	 <?php 
		 	 if ($value->idIT =='') {
		 	 		 echo "-";
		 	 }
		 	 else{
		 	 		 echo $value->idIT;
		 	 }
		 	?>
	 	</td>
	 	<td align="center">
	 	 	<?php 
	 	 	if ($value->stok ==''){
	 	 			echo "-";
	 	 	}
	 	 	else{
	 	 			echo $value->stok;;
	 	 	}
	 	 	?>
	 	 		
	 	</td>
	 	<td align="center">
	 	 	<?php 
	 	 	if ($value->Started_at ==''){
	 	 			echo "-";
	 	 	}
	 	 	else{
	 	 			echo $value->Started_at;;
	 	 	}
	 	 	?>
	 	 		
	 	 </td>

	 	<td align="center">
	 	 	<?php 
	 	 	if ($value->Finished_at ==''){
	 	 			echo "-";
	 	 	}
	 	 	else{
	 	 			echo $value->Finished_at;;
	 	 	}
	 	 	?>
	 	 		
	 	 </td>
		 <td>
	 		<?php 
			if($this->session->userdata('id_role') == 1)
			{

			?>

			<div class="dropdown"> 
				<button class="btn btn-outline-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action
				</button> 
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
					<?php 

					if ($value->Status == 'Normal') {


					?>
						<a class="dropdown-item" href="<?php echo site_url('Request/edit_request/').$value->NoTiket;?>">
							<i class="fa fa-edit"></i>
							Edit
						</a>
						<?php } ?>
						<a class="dropdown-item" href="<?php echo site_url('Request/hapus_request/').$value->NoTiket;?>" onclick="return confirm('are you sure?')">
							<i class="fa fa-remove"></i>
						Delete
						</a>
				</div>
				<?php } ?>
			</div>

			<?php 
				if($this->session->userdata('id_role') == 3 && $value->Status !='Sudah Dikerjakan')
				{

			?>

			<div class="dropdown">
				<button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>

					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

						 <?php 
						 	 if ($value->Status =='Sedang Dikerjakan') {
						 	 		 
						 	?> 
						<a class="dropdown-item" href="<?php echo site_url('Request/finish_request/').$value->NoTiket;?>">
							<i class="fa fa-edit"></i>Finish</a>
						<?php } 
							if ($value->Status =='Normal') {
							
						?>
						<a class="dropdown-item" href="<?php echo site_url('Request/start_request/').$value->NoTiket;?>">
							<i class="fa fa-edit"></i>
							Sedang Dikerjakan
						</a>
						<?php } ?>
					</div>
			</div>
			<?php 
				} ?>

		</td>
<?php } ?>

	</tr>	
</table>
</body>
</div>

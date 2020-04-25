<div class="container-fluid">
	<div class="row">
		<div class="col-lg">
			<form method="POST" id="form">


                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label"><span style="color: red;">*</span> Nama User</label>
                    <div class="col-sm-10">
                      <input type="text" name="username" class="form-control" placeholder="Nama User" id="disabledInput" disabled="" value="<?php echo $this->session->userdata('username')?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat" class="col-sm-2 col-form-label"><span style="color: red;">*</span>Keterangan Masalah</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="kategorimasalah" name="kategorimasalah">
                  </div>
              </div>

                <div class="form-group row">
                    <label for="divisi" class="col-sm-2 col-form-label"><span style="color: red;">*</span> Division</label>
                    <div class="col-sm-10">
                    	<select name="divisi" id="id_kat_masalah" class="form-control">
	                        <option value="">Select Kategori Masalah</option>
	                        <?php foreach ($id_kat_masalah as $d) :?>
	                            <option value="<?=$d['id_kat_masalah']; ?>"><?=$d['kategorimasalah']; ?></option>
	                        <?php endforeach; ?>
	                    </select>
                    </div>
                </div>

               <div class="form-group row">
                    <label for="jk" class="col-sm-2 col-form-label"><span style="color: red;">*</span> Gender</label>
                    <div class="col-sm-10">
                        <select name="prioritas" id="prioritas" class="form-control">
                            <option value="">Select Prioritas</option>
                                <option value="male">Tidak Mendesak</option>
                                <option value="female">Mendesak</option>
                                <option value="female">Sangat Mendesak</option>
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-2"></div>

                    <div class="col-sm-10 text-right">
                        <span><span style="color: red;">*</span> Required</span>
                    </div>
                </div>

			</form>
		</div>
	</div>
</div>

<script>
    loadData();

	$('#form').validate({
      	ignore: "",
      	rules: {
        	katmasalah: { 
        		required : true
        	},
            prioritas: { 
                required : true
            },
        	jk: { 
        		required : true
        	},
        	alamat: { 
        		required : true
        	},
        	divisi: { 
        		required : true
        	},
        	jabatan: { 
        		required: true
        	},
        	gaji: { 
        		required : true,
        		number : true
        	},
      	},
      	messages: {
            nama: {
            	required : "Name is required."
            },
            email: {
            	required : "Email is required."
            },
            tgl_lahir: {
            	required : "Date birth is required."
            },
            jk: {
            	required : "Gender is required."
            },
            alamat: {
            	required : "Address is required."
            },
            divisi: {
            	required : "Division is required."
            },
            jabatan: {
            	required : "Position is required."
            },
            gaji: {
            	required : "Salary is required."
            },
        },
      	errorElement: "p",
      	highlight: function (element, errorClass, validClass) {
          	$(element).addClass(errorClass); //.removeClass(errorClass);
          	$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
          	$(element).removeClass(errorClass); //.addClass(validClass);
          	$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function (error, element) {
        	error.insertAfter(element).addClass('h6');
        }
    });

    $('#modalSave').on('click', function() {
    	event.preventDefault();

    	if ($('#form').valid()) {
    		var dataform = $('#form').serializeArray();
    		var id = $('#universalModal').data('nip');
            console.log('modalsave '+id);
    		$.ajax({
                url: "<?php echo base_url('Admin/saveKaryawan/');?>"+id,
                type: "POST",
                data: dataform,
                dataType: "JSON",
                success: function(data, status) {
                    if (data.Error == false) {
                        swal.fire({
                            title    : 'Success',
                            html     : '<h5>'+ data.Pesan +'</h5>',
                            icon     : 'success',
                            animation: true
                        }).then((result) => {
                            tbllistuser.ajax.reload(null,true);
                            $('#universalModal').modal('hide');
                        });
                    }
                    else {
                        swal.fire({
                            title    : 'Cannot insert data',
                            html     : '<h5>'+ data.Pesan +'</h5>',
                            icon     : 'error',
                            animation: true
                        }).then((result) => {
                            tbllistuser.ajax.reload(null,true);
                            // $('#universalModal').modal('hide');
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal.fire({
                        title    : textStatus,
                        html     : '<h5>'+ errorThrown +'</h5>',
                        icon     : 'error',
                        animation: true
                    }).then((result) => {
                        tbllistuser.ajax.reload(null,true);
                        // $('#universalModal').modal('hide');
                    });
                }
            });
    	}
    	else{
    		swal.fire({
                title    : "Data not valid",
                text     : 'Please fill up all required filed',
                icon     : 'error',
                animation: true
            })
    	}
    })

    function loadData(){
        var id = $('#universalModal').data('nip');
        if (id != 0) {
            $.getJSON("<?php echo base_url('Admin/getKaryawanByNip/');?>"+id,function (data) {
                $('#nip').val(data[0].nip);
                $('#nama').val(data[0].nama);
                $('#email').val(data[0].email);
                $('#email').attr('disabled', true);
                
                $('#tempat_lahir').val(data[0].tempat_lahir);
                $('#tgl_lahir').val(data[0].tgl_lahir).trigger('change');

                $("#jk").val(data[0].jenis_kelamin).trigger('change');
                $('#alamat').val(data[0].alamat);
                
                $("#divisi").val(data[0].id_divisi).trigger('change');
                $("#jabatan").val(data[0].id_jabatan).trigger('change');

                $('#gaji').val(data[0].gaji_pokok);
            });
        }
    }
</script>
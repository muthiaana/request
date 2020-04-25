<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <form method="POST" id="form">

                <div class="form-group row">
                    <label for="id_kat_masalah" class="col-sm-2 col-form-label">ID </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="id_kat_masalah" name="id_kat_masalah" disabled placeholder="ID will be add automaticly">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Kategori Masalah</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="kategorimasalah" name="kategorimasalah">
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
            id_kat_masalah: { 
                required : true
            },
            kategorimasalah: { 
                required : true
            },
        },
        messages: {
            kategorimasalah: {
                required : "Nama barang dibutuhkan."
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
        console.log('test'); 
        event.preventDefault();

        if ($('#form').valid()) {
            console.log('test'); 
            var dataform = $('#form').serializeArray();
            var id = $('#universalModal').data('id_kat_masalah');
            $.ajax({
                url: "<?php echo base_url('kategoriMasalah/saveMasalah/');?>"+id,
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
                            tblMasalah.ajax.reload(null,true);
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
                            tblMasalah.ajax.reload(null,true);
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
                        tblMasalah.ajax.reload(null,true);
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
        var id = $('#universalModal').data('id_kat_masalah');
        if (id != 0) {
            $.getJSON("<?php echo base_url('kategoriMasalah/getMasalahByID/');?>"+id,function (data) {
                $('#id_kat_masalah').val(data[0].id_kat_masalah);
                $('#kategorimasalah').val(data[0].kategorimasalah);
            });
        }
    }
</script>
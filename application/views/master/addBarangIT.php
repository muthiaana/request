<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <form method="POST" id="form">

                <div class="form-group row">
                    <label for="NoStok" class="col-sm-2 col-form-label"><span style="color: red;">*</span>  No Stok</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="NoStok" name="NoStok" disabled placeholder="ID will be add automaticly">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="barang" class="col-sm-2 col-form-label"> Barang</label>
                    <div class="col-sm-10">
                        <select name="idBarang" id="idBarang" class="form-control">
                            <option value="">Select Barang</option>
                            <?php foreach ($barang as $d) :?>
                                <option value="<?=$d['idBarang']; ?>"><?=$d['namaBarang']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jumlah" class="col-sm-2 col-form-label">Stok</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="jumlah" name="jumlah">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tipeTransaksi" class="col-sm-2 col-form-label"><span style="color: red;">*</span> Tipe Transaksi</label>
                    <div class="col-sm-10">
                        <select name="tipeTransaksi" id="tipeTransaksi" class="form-control">
                            <option value="">Select Tipe Transaksi</option>
                                <option value="1">Keluar</option>
                                <option value="2">Masuk</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="Keterangan" name="Keterangan">
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
            idBarang: { 
                required : true
            },
            // namaBarang: { 
            //     required : true
            // },
            jumlah: { 
                required : true
            },
            tipeTransaksi: { 
                required : true
            },
            Keterangan: { 
                required : true
            },
        },
        messages: {
            // namaBarang: {
            //     required : "Nama barang dibutuhkan."
            // },
            jumlah: {
                required : "Jumlah perlu diisi."
            },
            tipeTransaksi: {
                required : "Tipe Transaksi perlu diisi."
            },
            Keterangan: {
                required : "Keterangan perlu diisi."
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
        if (event.handled !== true) {
            event.handled = true;
            if ($('#form').valid()) {
                var dataform = $('#form').serializeArray();
                var id = $('#universalModal').data('NoStok');
                $.ajax({
                    url: "<?php echo base_url('Master/saveBarang/');?>"+id,
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
                                tblBarang.ajax.reload(null,true);
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
                                tblBarang.ajax.reload(null,true);
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
                            tblBarang.ajax.reload(null,true);
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
        }
    })

    function loadData(){
        var id = $('#universalModal').data('NoStok');
        if (id != 0) {
            $.getJSON("<?php echo base_url('Master/getBarangByID/');?>"+id,function (data) {
                $('#idBarang').val(data[0].idBarang);
                // $('#namaBarang').val(data[0].namaBarang);
                $('#jumlah').val(data[0].jumlah);
                $('#tipeTransaksi').val(data[0].tipeTransaksi);
                $('#Keterangan').val(data[0].Keterangan)
                // $('#saldo').val(data[0].saldo)
            });
        }
    }
</script>
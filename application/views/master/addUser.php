<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <form method="POST" id="form">

                <div class="form-group row">
                    <label for="id_user" class="col-sm-2 col-form-label">ID User</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="id_user" name="id_user" disabled placeholder="ID will be add automaticly">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="name" name="name">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="username" name="username">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="divisi" class="col-sm-2 col-form-label"><span style="color: red;">*</span> Divisi</label>
                    <div class="col-sm-10">
                        <select name="id_divisi" id="id_divisi" class="form-control">
                            <option value="">Select Divisi</option>
                            <?php foreach ($divisi as $d) :?>
                                <option value="<?=$d['id_divisi']; ?>"><?=$d['nama_divisi']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_role" class="col-sm-2 col-form-label"><span style="color: red;">*</span> Role</label>
                    <div class="col-sm-10">
                        <select name="id_role" id="id_role" class="form-control">
                            <option value="">Select Role</option>
                            <?php foreach ($role as $d) :?>
                                <option value="<?=$d['id_role']; ?>"><?=$d['role']; ?></option>
                            <?php endforeach; ?>
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
            id_user: { 
                required : true
            },
            name: { 
                required : true
            },
            username: { 
                required : true
            },
            password: { 
                required : true
            },
            id_role: { 
                required : true
            },
            id_divisi: { 
                required : true
            },
            date_created: { 
                required : true
            },

        },
        messages: {
            name: {
                required : "Nama barang dibutuhkan."
            },
            username: {
                required : "Jumlah perlu diisi."
            },
            password: {
                required : "Tipe Transaksi perlu diisi."
            },
            id_role: {
                required : "id_role perlu diisi."
            },
            id_divisi: {
                required : "id_divisi perlu diisi."
            },            
            date_created: {
                required : "id_role perlu diisi."
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
            var dataform = $('#form').serializeArray();
            var id = $('#universalModal').data('id_user');
            $.ajax({
                url: "<?php echo base_url('NewUser/saveUser/');?>"+id,
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
                            tblUser.ajax.reload(null,true);
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
                            tblUser.ajax.reload(null,true);
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
                        tblUser.ajax.reload(null,true);
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
        var id = $('#universalModal').data('id_user');
        if (id != 0) {
            $.getJSON("<?php echo base_url('NewUser/getUserByID/');?>"+id,function (data) {
                $('#id_user').val(data[0].id_user);
                $('#name').val(data[0].name);
                $('#username').val(data[0].username);
                $('#jumlah').val(data[0].jumlah);
                $('#password').val(data[0].password);
                $('#id_role').val(data[0].id_role);
                $('#id_divisi').val(data[0].id_divisi);
                $('#date_created').val(data[0].date_created)
            });
        }
    }
</script>
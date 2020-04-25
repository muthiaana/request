
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
<!-- <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script> -->
<style>
    .dt-buttons{
        margin-top: 20px;
    }
    #tblUser_filter{
        margin-top: 20px;
    }
</style>
<!-- Begin Page Content -->
    <div class="mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover dataTables" id="tblUser" width="100%">
                    <thead>
                        <tr>
                            <th>ID User</th>
                            <th>Nama User</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>Tanggal Buat</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- end content -->

</div>
<!-- End of Main Content -->


<script>
    var tblUser = $('#tblUser').DataTable( {
        "responsive" : true,
        "ajax" : {
            "url" : "<?php echo base_url('NewUser/getUser');?>",
            "type": "POST"
        },
        "columns": [
            { data: "id_user"},
            { data: "name"},
            { data: "username"},
            { data: "password"},
            { data: "id_role",

                render: function(data, type, row) {
                    var id = row.id_role
                    if (id == 1) {
                        return 'Admin';
                    }
                    else if (id == 2) {
                        return 'Karyawan';
                    }
                    else if (id == 3) {
                        return 'IT Support';
                    }
                    else{
                        return '-';
                    // else if (id == 4) {
                    //     return 'Marketing';
                    }
                } 
            },
            { data: "id_divisi",
                render: function(data, type, row) {
                    var id = row.id_divisi
                    if (id == 1) {
                        return 'Direktur';
                    }
                    else if (id == 2) {
                        return 'Sekretaris';
                    }
                    else if (id == 3) {
                        return 'Operasional';
                    }
                    else if (id == 4) {
                        return 'Marketing';
                    }
                    else if (id == 5) {
                        return 'Accounting';
                    }
                    else if (id == 6) {
                        return 'Finance';
                    }
                    else if (id == 7) {
                        return 'Costing';
                    }
                    else if (id == 8) {
                        return 'Kwitansi';
                    }
                    else if (id == 9) {
                        return 'Piutang';
                    }
                    else if (id == 10) {
                        return 'HRD & GA';
                    }
                    else if (id == 11) {
                        return 'Admin Operasional';
                    }
                    else if (id == 12) {
                        return 'Admin Biaya';
                    }
                    else if (id == 13) {
                        return 'System Management';
                    }
                    // else if (id == 3) {
                    //     return 'Operasional';
                    // }
                    else{
                        return '-';
                    }
                }
            },
            { data: "status"},
            { data: "date_created"},
        ],
        "buttons":[
            {
                extend : 'excel',
                oriented : 'potrait',
                pageSize : 'A4',
                text : '<i class="fas fa-file-excel"></i> Excel',
                title : 'List of User',
                className: 'btn btn-success'
            }, 
            {
                extend : 'pdf',
                oriented : 'potrait',
                pageSize : 'A4',
                text : '<i class="fas fa-file-pdf"></i> PDF',
                title : 'List of User',
                className: 'btn btn-danger'
            }
        ],
        "language": {
            "decimal": ",",
            "thousands": ".",
        },
        "dom": '<"toolbar list">Brti'
    });

    $("div.list").html(
        '<button id="add" class="btn btn-primary">Add</button>&nbsp;'+
        '<button id="edit" class="btn btn-info">Edit</button>&nbsp;'+
        '<button id="delete" class="btn btn-danger">Delete</button>'
    );

    tblUser.on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            tblUser.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#add').click(function(){
        // console.log('test'); 
        $('#modalbody').html("");
        $('#modalheader').addClass('bg-primary text-white');
        $('#modaldialog').addClass('modal-md');
        $('#modaltitle').addClass('white');
        $('#universalModal').modal({backdrop: 'static', keyboard: false})  
        $('#modaltitle').html('Add User');

        $('#modalbody').load("<?php echo base_url("NewUser/addNewUser");?>");
                console.log('test');
        $('#universalModal').data('id_user', 0);
        $('#universalModal').modal('show');
    });

    $('#edit').click(function(){
        // console.log('tes');
        var rows = tblUser.rows('.selected').indexes();
        if (rows.length < 1) {
            swal.fire("Information",'Please select a row',"warning");
        } 
        var data    = tblUser.rows(rows).data();
        // console.log('data');    
        var id_user= data[0].id_user;
        
        $('#modalbody').html("");
        $('#modalheader').addClass('bg-primary text-white');
        $('#modaldialog').addClass('modal-md');
        $('#modaltitle').addClass('white');
        $('#universalModal').modal({backdrop: 'static', keyboard: false})  
        $('#modaltitle').html('Edit User');
        $('#modalbody').load("<?php echo base_url("NewUser/addNewUser/");?>");

        $('#universalModal').data('id_user', id_user);
        $('#universalModal').modal('show');
    });


    $('#delete').click(function(){
        var rows = tblUser.rows('.selected').indexes();
        if (rows.length < 1) {
            swal.fire("Information",'Please select a row',"warning");
            return;
        }

        var data = tblUser.rows(rows).data();
        var id_user = data[0].id_user;
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            animation: true,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                deleteUser(id_user);
            }
        })
    });

    function deleteUser(id_user){
        $.ajax({
            url : "<?php echo base_url('NewUser/deleteUser/');?>"+id_user,
            type:"POST",
            dataType:"JSON",
            success:function(event, data){
                Swal.fire(
                    'Deleted!',
                    'Data Has been deleted.',
                    'success'
                );
                tblUser.ajax.reload(null,true);
            },                    
            error: function(jqXHR, textStatus, errorThrown){        
                swal.fire("Information",textStatus+' Save : '+errorThrown,"warning");
            }
        });
    }
</script>


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
<style>
    .dt-buttons{
        margin-top: 20px;
    }
    #tbllistuser_filter{
        margin-top: 20px;
    }
</style>
<!-- Begin Page Content -->
    <div class="mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover dataTables" id="tbllistuser" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Tiket</th>
                            <th>Nama User</th>
                            <th>Keterangan Masalah</th>
                            <th>kategori Masalah</th>
                            <th>Tanggal</th> 
                            <th>Prioritas</th>
                            <th>IT Support</th>
                            <th>Start</th>
                            <th>Finish</th>
                            <th>Action</th>
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
    var tbllistuser = $('#tbllistuser').DataTable( {
        "responsive" : true,
        "ajax" : {
            "url" : "<?php echo base_url('Admin/getKaryawan');?>",
            "type": "POST"
        },
        "columns": [
            { data: "nip"},
            { data: "nama"},
            { data: "email" },
            { data: "alamat"},
            { data: "tgl_masuk", 
                render : function(data, type, row) {
                    var date = row.tgl_masuk
                    return timeConvert_DD_M_YYYY(date);
                }
            },
            { data: "id_divisi",
                render: function(data, type, row) {
                    var id = row.id_divisi
                    if (id == 1) {
                        return 'mobile';
                    }
                    else if (id == 2) {
                        return 'web';
                    }
                    else if (id == 3) {
                        return 'desktop';
                    }
                    else{
                        return '-';
                    }
                }
            },
            { data: "id_jabatan",
                render: function(data, type, row) {
                    var id = row.id_jabatan
                    if (id == 1) {
                        return 'CEO';
                    }
                    else if (id == 2) {
                        return 'Consultant';
                    }
                    else if (id == 3) {
                        return 'Project Manager';
                    }
                    else if (id == 4) {
                        return 'Staff';
                    }
                    else{
                        return '-';
                    }
                }
            },
            { data: "gaji_pokok",
                render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp.' )
            },
            { data: "code",
                createdCell : function(td, cellData, rowData, row, col) {
                    var qr = row.code
                    var id = rowData.nip
                    console.log()
                    $(td).attr('id', 'qrcode'+id)
                    // qrcode.makeCode(qr)
                }
            },
            { data: "tempat_lahir"},
            { data: "tgl_lahir"},
            { data: "jenis_kelamin"},
            // { data: null,
            //     searchable  : false,
            //     orderable   : false,
            //     render      : function (data, type, row) {
            //       var id = row.nip
            //         return  '<button id="edit" onClick="edit('+id+')" class="btn btn-info">Edit</button>&nbsp;';
            //     }
            // }
        ],
        "buttons":[ 
            {
                extend : 'excel',
                oriented : 'potrait',
                pageSize : 'A4',
                text : '<i class="fas fa-file-excel"></i> Excel',
                title : 'List of Employee',
                className: 'btn btn-success'
            }, 
            {
                extend : 'pdf',
                oriented : 'potrait',
                pageSize : 'A4',
                text : '<i class="fas fa-file-pdf"></i> PDF',
                title : 'List of Employee',
                className: 'btn btn-danger'
            }
        ],
        "language": {
            "decimal": ",",
            "thousands": ".",
        },
        dom: {
            button: {
                className: 'btn'
            }
        } ,
        "dom": '<"toolbar list">fBrti'
    });

    $("div.list").html(
        '<button id="add" class="btn btn-primary">Add</button>&nbsp;'+
        '<button id="edit" class="btn btn-info">Edit</button>&nbsp;'+
        '<button id="delete" class="btn btn-danger">Delete</button>'
    );

    tbllistuser.on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            tbllistuser.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#add').click(function(){
        $('#modalbody').html("");
        $('#modalheader').addClass('bg-primary text-white');
        $('#modaldialog').addClass('modal-lg');
        $('#modaltitle').addClass('white');
        $('#universalModal').modal({backdrop: 'static', keyboard: false})  
        $('#modaltitle').html('Add Karyawan');
        $('#modalbody').load("<?php echo base_url("Admin/addKaryawan");?>");
        
        $('#universalModal').data('nip', 0);
        // $('.modal-footer').html('');
        // $('.modal-footer').html('<button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button><button type="button" class="btn btn-danger" id="savefrm" disabled >Save</button>');
        $('#universalModal').modal('show');
    });

    $('#edit').click(function(){
        var rows = tbllistuser.rows('.selected').indexes();
        if (rows.length < 1) {
            swal.fire("Information",'Please select a row',"warning");
        } 
        var data    = tbllistuser.rows(rows).data();
        var nip     = data[0].nip;
        
        $('#modalbody').html("");
        $('#modalheader').addClass('bg-primary text-white');
        $('#modaldialog').addClass('modal-lg');
        $('#modaltitle').addClass('white');
        $('#universalModal').modal({backdrop: 'static', keyboard: false})  
        $('#modaltitle').html('Edit Karyawan');
        $('#modalbody').load("<?php echo base_url("Admin/addKaryawan/");?>");

        $('#universalModal').data('nip', nip);
        $('#universalModal').modal('show');
    });


    $('#delete').click(function(){
        var rows = tbllistuser.rows('.selected').indexes();
        if (rows.length < 1) {
            swal.fire("Information",'Please select a row',"warning");
            return;
        }

        var data = tbllistuser.rows(rows).data();
        var nip = data[0].nip;
        var email = data[0].email;
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
                deleteKaryawan(nip, email);
            }
        })
    });

    function deleteKaryawan(nip,email){
        $.ajax({
            url : "<?php echo base_url('Admin/deleteKaryawan/');?>"+nip,
            type:"POST",
            data: { 
                email: email 
            },
            dataType:"JSON",
            success:function(event, data){
                Swal.fire(
                    'Deleted!',
                    'Data Has been deleted.',
                    'success'
                );
                tbllistuser.ajax.reload(null,true);
            },                    
            error: function(jqXHR, textStatus, errorThrown){        
                swal.fire("Information",textStatus+' Save : '+errorThrown,"warning");
            }
        });
    }
</script>
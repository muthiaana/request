
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
<style>
    .dt-buttons{
        margin-top: 20px;
    }
    #tblBarang_filter{
        margin-top: 20px;
    }
</style>
<!-- Begin Page Content -->
    <div class="mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover dataTables" id="tblBarang" width="100%">
                    <thead>
                        <tr>
                            <th>NoStok</th>
                            <th>IdBarang</th>
                            <!-- <th>NamaBarang</th> -->
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Tipe Keterangan</th>
                            <th>Keterangan</th>
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
    var tblBarang = $('#tblBarang').DataTable( {
        "responsive" : true,
        "ajax" : {
            "url" : "<?php echo base_url('Master/getBarangIT');?>",
            "type": "POST"
        },
        "columns": [
            { data: "NoStok"},
            { data: "idBarang"},
            // { data: "namaBarang"},
            { data: "jumlah"},
            { data: "tanggalInput"},
            { data: "tipeTransaksi",
                render: function(data, type, row) {
                    var id = row.tipeTransaksi
                    if (id == 1) {
                        return 'Keluar';
                    }
                    else if (id == 2) {
                        return 'Masuk';
                    }
                    else{
                        return '-';
                    // else if (id == 4) {
                    //     return 'Marketing';
                    }
                } 
            },
            { data: "Keterangan"},
        ],
        "buttons":[
            {
                extend : 'excel',
                oriented : 'potrait',
                pageSize : 'A4',
                text : '<i class="fas fa-file-excel"></i> Excel',
                title : 'List of Barang',
                className: 'btn btn-success'
            }, 
            {
                extend : 'pdf',
                oriented : 'potrait',
                pageSize : 'A4',
                text : '<i class="fas fa-file-pdf"></i> PDF',
                title : 'List of Barang',
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

    tblBarang.on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            tblBarang.$('tr.selected').removeClass('selected');
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
        $('#modaltitle').html('Add Barang');

        $('#modalbody').load("<?php echo base_url("Master/addBarang");?>");
                // console.log('test');
        $('#universalModal').data('NoStok', 0);
        $('#universalModal').modal('show');
    });

    $('#edit').click(function(){
        // console.log('tes');
        var rows = tblBarang.rows('.selected').indexes();
        if (rows.length < 1) {
            swal.fire("Information",'Please select a row',"warning");
        } 
        var data    = tblBarang.rows(rows).data();
        // console.log('data');    
        var NoStok= data[0].NoStok;
        
        $('#modalbody').html("");
        $('#modalheader').addClass('bg-primary text-white');
        $('#modaldialog').addClass('modal-md');
        $('#modaltitle').addClass('white');
        $('#universalModal').modal({backdrop: 'static', keyboard: false})  
        $('#modaltitle').html('Edit Barang IT');
        $('#modalbody').load("<?php echo base_url("Master/addBarang/");?>");

        $('#universalModal').data('NoStok', NoStok);
        $('#universalModal').modal('show');
    });


    $('#delete').click(function(){
        var rows = tblBarang.rows('.selected').indexes();
        if (rows.length < 1) {
            swal.fire("Information",'Please select a row',"warning");
            return;
        }

        var data = tblBarang.rows(rows).data();
        var NoStok = data[0].NoStok;
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
                deleteBarangIT(NoStok);
            }
        })
    });

    function deleteBarangIT(NoStok){
        $.ajax({
            url : "<?php echo base_url('Master/deleteBarangIT/');?>"+NoStok,
            type:"POST",
            dataType:"JSON",
            success:function(event, data){
                Swal.fire(
                    'Deleted!',
                    'Data Has been deleted.',
                    'success'
                );
                tblBarang.ajax.reload(null,true);
            },                    
            error: function(jqXHR, textStatus, errorThrown){        
                swal.fire("Information",textStatus+' Save : '+errorThrown,"warning");
            }
        });
    }
</script>

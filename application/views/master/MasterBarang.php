
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
    #tblMasterBarang_filter{
        margin-top: 20px;
    }
</style>
<!-- Begin Page Content -->
    <div class="mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover dataTables" id="tblMasterBarang" width="100%">
                    <thead>
                        <tr>
                            <th>IdBarang</th>
                            <th>NamaBarang</th>
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
    var tblMasterBarang = $('#tblMasterBarang').DataTable( {
        "responsive" : true,
        "ajax" : {
            "url" : "<?php echo base_url('Master/getmasterBarangIT');?>",
            "type": "POST"
        },
        "columns": [
            { data: "idBarang"},
            { data: "namaBarang"},
        ],
        "dom": '<"toolbar list">Brti'
    });

    $("div.list").html(
        '<button id="add" class="btn btn-primary">Add</button>&nbsp;'+
        '<button id="edit" class="btn btn-info">Edit</button>&nbsp;'+
        '<button id="delete" class="btn btn-danger">Delete</button>'
    );

    tblMasterBarang.on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            tblMasterBarang.$('tr.selected').removeClass('selected');
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

        $('#modalbody').load("<?php echo base_url("Master/addMasterBarang");?>");
                // console.log('test');
        $('#universalModal').data('idBarang', 0);
        $('#universalModal').modal('show');
    });

    $('#edit').click(function(){
        // console.log('tes');
        var rows = tblMasterBarang.rows('.selected').indexes();
        if (rows.length < 1) {
            swal.fire("Information",'Please select a row',"warning");
        } 
        var data    = tblMasterBarang.rows(rows).data();
        // console.log('data');    
        var idBarang= data[0].idBarang;
        
        $('#modalbody').html("");
        $('#modalheader').addClass('bg-primary text-white');
        $('#modaldialog').addClass('modal-md');
        $('#modaltitle').addClass('white');
        $('#universalModal').modal({backdrop: 'static', keyboard: false})  
        $('#modaltitle').html('Edit Master Barang IT');
        $('#modalbody').load("<?php echo base_url("Master/addMasterBarang/");?>");

        $('#universalModal').data('idBarang', idBarang);
        $('#universalModal').modal('show');
    });


    $('#delete').click(function(){
        var rows = tblMasterBarang.rows('.selected').indexes();
        if (rows.length < 1) {
            swal.fire("Information",'Please select a row',"warning");
            return;
        }

        var data = tblMasterBarang.rows(rows).data();
        var idBarang = data[0].idBarang;
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
                deleteBarangIT(idBarang);
            }
        })
    });

    function deleteBarangIT(idBarang){
        $.ajax({
            url : "<?php echo base_url('Master/deleteMasterBarangIT/');?>"+idBarang,
            type:"POST",
            dataType:"JSON",
            success:function(event, data){
                Swal.fire(
                    'Deleted!',
                    'Data Has been deleted.',
                    'success'
                );
                tblMasterBarang.ajax.reload(null,true);
            },                    
            error: function(jqXHR, textStatus, errorThrown){        
                swal.fire("Information",textStatus+' Save : '+errorThrown,"warning");
            }
        });
    }
</script>

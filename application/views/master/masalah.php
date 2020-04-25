
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
    #tblMasalah_filter{
        margin-top: 20px;
    }
</style>
<!-- Begin Page Content -->
    <div class="mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover dataTables" id="tblMasalah" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kategori Masalah</th>
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
    var tblMasalah = $('#tblMasalah').DataTable({
        // console.log('test');
        "responsive" : true,
        "ajax" : {
            "url" : "<?php echo base_url('KategoriMasalah/getKatMasalah');?>",
            "type": "POST"
        },
        "columns": [
            { data: "id_kat_masalah"},
            { data: "kategorimasalah"},
        ],
        // "buttons":[
        //     {
        //         extend : 'excel',
        //         oriented : 'potrait',
        //         pageSize : 'A4',
        //         text : '<i class="fas fa-file-excel"></i> Excel',
        //         title : 'List of Barang',
        //         className: 'btn btn-success'
        //     }, 
        //     {
        //         extend : 'pdf',
        //         oriented : 'potrait',
        //         pageSize : 'A4',
        //         text : '<i class="fas fa-file-pdf"></i> PDF',
        //         title : 'List of Barang',
        //         className: 'btn btn-danger'
        //     }
        // ],
        // "language": {
        //     "decimal": ",",
        //     "thousands": ".",
        // },
        "dom": '<"toolbar list">Brti'
    });

    $("div.list").html(
        '<button id="add" class="btn btn-primary">Add</button>&nbsp;'+
        '<button id="edit" class="btn btn-info">Edit</button>&nbsp;'+
        '<button id="delete" class="btn btn-danger">Delete</button>'
    );


    tblMasalah.on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            tblMasalah.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });


    $('#add').click(function(){
        $('#modalbody').html("");
        $('#modalheader').addClass('bg-primary text-white');
        $('#modaldialog').addClass('modal-md');
        $('#modaltitle').addClass('white');
        $('#universalModal').modal({backdrop: 'static', keyboard: false})  
        $('#modaltitle').html('Add Kategori Masalah');

        $('#modalbody').load("<?php echo base_url("KategoriMasalah/addMasalahKat");?>");
                console.log('test');
        $('#universalModal').data('id_kat_masalah', 0);
        $('#universalModal').modal('show');
    });

    $('#edit').click(function(){
        console.log('tes');
        var rows = tblMasalah.rows('.selected').indexes();
        if (rows.length < 1) {
            swal.fire("Information",'Please select a row',"warning");
        } 
        var data    = tblMasalah.rows(rows).data();
        // console.log('data');    
        var id_kat_masalah = data[0].id_kat_masalah;
        
        $('#modalbody').html("");
        $('#modalheader').addClass('bg-primary text-white');
        $('#modaldialog').addClass('modal-md');
        $('#modaltitle').addClass('white');
        $('#universalModal').modal({backdrop: 'static', keyboard: false})  
        $('#modaltitle').html('Edit Kategori Masalah');
        $('#modalbody').load("<?php echo base_url("KategoriMasalah/addMasalahKat/");?>");

        $('#universalModal').data('id_kat_masalah', id_kat_masalah);
        $('#universalModal').modal('show');
    });


    $('#delete').click(function(){
        var rows = tblMasalah.rows('.selected').indexes();
        if (rows.length < 1) {
            swal.fire("Information",'Please select a row',"warning");
            return;
        }

        var data = tblMasalah.rows(rows).data();
        var id_kat_masalah = data[0].id_kat_masalah;
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
                deleteMasalah(id_kat_masalah);
            }
        })
    });

    function deleteMasalah(id_kat_masalah){
        $.ajax({
            url : "<?php echo base_url('KategoriMasalah/deleteMasalah/');?>"+id_kat_masalah,
            type:"POST",
            dataType:"JSON",
            success:function(event, data){
                Swal.fire(
                    'Deleted!',
                    'Data Has been deleted.',
                    'success'
                );
                tblMasalah.ajax.reload(null,true);
            },                    
            error: function(jqXHR, textStatus, errorThrown){        
                swal.fire("Information",textStatus+' Save : '+errorThrown,"warning");
            }
        });
    }
</script>

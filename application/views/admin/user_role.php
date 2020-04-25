<!-- Begin Page Content -->
    <div class="mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbllistuser" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created</th>
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


<!-- End of Main Content -->

<script>
    var tbllistuser = $('#tbllistuser').DataTable( {
        "ajax" : {
            "url" : "<?php echo base_url('Admin/getUserRole');?>",
            "type": "POST"
        },
        "columns": [
            { data: "id_user"},
            { data: "name"},
            { data: "username" },
            { data: "id_role",
                render : function(data, type, row) {
                    var role = row.id_role
                    if (role == 1) {
                        return 'Admin';
                    }
                    else if(role == 2){
                        return 'Karyawan';
                    }
                    else{
                        return '-';
                    }
                }
            },
            { data: "status", 
                render : function(data, type, row) {
                    var status = row.status
                    if(status == 1){
                        return 'Active';
                    }
                    else{
                        return 'Non-active';
                    }
                }
            },
            { data: "date_created",
                render : function(data, type, row) {
                    var date = row.date_created
                    return timeConverter(date);
                }
            },
            { data: null,
                searchable  : false,
                orderable   : false,
                render      : function (data, type, row) {
                  var id = row.id_user
                    return  '<button id="edit" onClick="edit('+id+')" class="btn btn-info">Edit</button>&nbsp;';
                }
            }
        ],
        "language": {
            "decimal": ",",
            "thousands": ".",
        },
        "dom": '<"toolbar list">frti'
    });

    $("div.list").html(
        // '<button id="add" class="btn btn-primary">Add</button>&nbsp;'+
        // '<button id="edit" class="btn btn-info">Edit</button>&nbsp;'
        // '<button id="delete" class="btn btn-danger onclick="deleteov()">Delete</button>'
    );

    tbllistuser.on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            tbllistuser.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    function edit(id){
        // console.log(id);
    }

    function timeConverter(UNIX_timestamp){
        var a = new Date(UNIX_timestamp * 1000);
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
        return time;
    }
</script>
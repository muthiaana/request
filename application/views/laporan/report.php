<div class="container-fluid mb-4">

    <div class="row mb-4">
        <?= $this->session->flashdata('message'); ?>
        <div class="col-12 text-center">
            <h1>Attendance & Salary Report</h1>
        </div>
    </div>
    
    <form action="<?= base_url('Report/print') ?>" method="POST">
        
        <input type="text" class="form-control" id="id_role" name="id_role" hidden value="<?= $user['id_role'] ?>">

        <div class="form-group row">
            <label for="nip" class="col-2 col-form-label">Employee</label>
            <div class="col-10">
                <select name="nip" id="nip" class="form-control" required>
                    <option value="">Select Employee</option>
                    <?php foreach ($employee as $e) :?>
                        <option value="<?=$e['nip']; ?>"><?=$e['nama']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        
        <div class="form-group row mb-4">
            <label for="tgl_masuk" class="col-2 col-form-label">Join Date</label>
            <div class="col-10">
              <input type="text" class="form-control" id="tgl_masuk" name="tgl_masuk" readonly placeholder="Join Date will be add automaticly">
            </div>
        </div>

        <div class="form-group row mb-4">
            <label for="range" class="col-2 col-form-label">Date Range</label>
            <div class="col-5">
              <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" required>
            </div>
            <div class="col-5">
              <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" required>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <button class="btn btn-primary col-lg-12">Print</button>
            </div>
        </div>
    </form>
</div>

</div>

<script>
    $('#nip').change(function(){
        var nip = $(this).children('option:selected').val();
        getData(nip);
    });

    function getData(nip) {
        if (nip != 0) {
            $.getJSON("<?php echo base_url('Report/getKaryawanByNip/');?>"+nip,function (data) {
                $('#email').val(data[0].email);
                $("#tgl_masuk").val(timeConvert_DD_MMM_YYYY(data[0].tgl_masuk));

                var id_jabatan = data[0].id_jabatan;
                $.getJSON("<?php echo base_url('Report/getPostition/');?>"+id_jabatan,function (data) {
                    $("#jabatan").val(data[0].nama_jabatan);
                });
            });
        }
    }
</script>
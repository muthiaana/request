<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <form method="POST" id="form">


                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Periode Transaksi</label>
                  <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-5">
                            <input type="date" name="tgl_awal" class="form-control" />
                        </div> s/d
                        <div class="col-sm-5">
                            <input type="date" name="tgl_akhir" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">&nbsp;</label>
              <div class="col-sm-10">
                <button type="button" id="btnProses" class="btn btn-info" >Proses</button>
                <button type="submit" class="btn btn-primary">Export to Pdf</button>
            </div>
            </div>

            </form>
        </div>
    </div>
</div>

<?php echo form_close(); ?>

<div class="row">
    <div class="col-sm-12">
        <div id="rowData"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#btnProses').click(function(){

            $.ajax({
                url:'<?php echo site_url('Laporan/getLaporan_ListBarang'); ?>',
                type:'POST',
                data:$('#form').serialize(),
                dataType:'html',
                success:function(res){
                    $('#rowData').html(res);
                }
            });
        });
    });
</script>
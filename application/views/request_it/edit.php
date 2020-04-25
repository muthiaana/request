
<div class="container-fluid">


  <form action="<?php echo base_url("Request/submit"); ?>" method="POST">
  <fieldset>
          <div class="form-group">
              <div class="d-flex flex-row-reverse">
                <span class="p-2"><?php echo date('H:i'); ?></span>
                <span class="p-2">Jam</span>
                <span class="p-2"><?php echo date('Y-m-d'); ?></span>
                <span class="p-2">Tanggal</span>
              </div>
          </div>

          <div class="form-group">
              <label class="col-form-label" for="inputDefault">User</label>
              <input type="text" name="username" class="form-control" placeholder="Nama User" id="disabledInput" disabled="" value="<?php echo(isset($reqit[0]->username)? $reqit[0]->username:''); ?>">
          </div>

          <div class="form-group">
              <label class="col-form-label" for="inputDefault">Keterangan Masalah</label>
                    <input type="text" name="ketmasalah" class="form-control" placeholder="Keterangan Masalah" id="inputDefault" value="<?php echo(isset($reqit[0]->ketmasalah)? $reqit[0]->ketmasalah:''); ?>">
          </div>

            <div class="form-group">
              <label>Kategori Masalah</label>
              <select class="form-control" id="kategorimasalah" name="kategorimasalah" required>
                <?php foreach ($katmasalah as $r) : ?>
                  <option value="<?= $r['id_kat_masalah']; ?>"><?= $r['kategorimasalah']; ?></option>
                <?php endforeach ; ?>
              </select>
          </div>
<!--                <label class="col-form-label" for="inputDefault">Kategori Masalah</label>
                <select class="custom-select" name="kategorimasalah">
                      <option selected="">--------Pilih--------</option>
                      <option value="1">Eror Program</option>
                      <option value="2">Printer Bermasalah</option>
                      <option value="3">Email Bermasalah</option>
                      <option value="3">Jaringan Bermasalah</option>
              </select>
          </div> -->

  <fieldset class="form-group">
                        <?php  
                           $mendesak = '';
                           $tdkmendesak = '';
                           $normal = '';
                          if(isset($data_keluhan[0]->prioritas)){
                              if($data_keluhan[0]->prioritas == 'Mendesak'){
                                   $mendesak = 'selected';
                                   $tdkmendesak = '';
                                   $normal = '';
                              }
                              else if($data_keluhan[0]->prioritas == 'Tidak Mendesak'){
                                   $mendesak = '';
                                   $tdkmendesak = 'selected';
                                   $normal = '';
                              }
                              else if($data_keluhan[0]->prioritas == 'Normal'){
                                   $mendesak = '';
                                   $tdkmendesak = '';
                                   $normal = 'selected';
                              }
                          }
                        ?>
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">Prioritas</legend>
      <div class="col-sm-10">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="prioritas" id="prioritas" value="Tidak Mendesak" <?php echo $tdkmendesak?> checked>
          <label class="form-check-label" for="prioritas">
            Tidak Mendesak
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="prioritas" id="prioritas" value="Normal" <?php echo $normal?>>
          <label class="form-check-label" for="prioritas">
            Normal
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="prioritas" id="prioritas" value="Mendesak" <?php echo $mendesak?>>
          <label class="form-check-label" for="prioritas">
            Mendesak
          </label>
        </div>
      </div>
    </div>
  </fieldset>

  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">Prioritas</legend>
      <div class="col-sm-10">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="stok" id="stok" value="stok">
          <label class="form-check-label" for="stok">Stok</label>
        </div>
      </div>
    </div>
  </fieldset>

    <button type="submit" class="btn btn-primary">Submit</button>
  </fieldset>
</form>
<script>
    $('.custom-file-input').on('change', function() {
        let filename = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass('selected').html(filename);
    });
</script>


</div>
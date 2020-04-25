<div class="container-fluid">

   <?= form_open_multipart('NewUser/submit') ?>
	<div class="form-group">
      <label >Nama</label>
      <input type="text" name="name" class="form-control" placeholder="Nama" value="<?= $user['name'] ?>">
    </div>

  <div class="form-group">
      <label >Username</label>
      <input type="text" name="username" class="form-control" placeholder="username" value="<?= $user['username'] ?>">
    </div>

    <div class="form-group">
      <label >profile picture</label>
      <div class="custom-file">
          <input type="file" class="custom-file-input" id="image" name="image" value="<?= $user['image'] ?>">
          <label class="custom-file-label" for="image">Choose file</label>
      </div>
    </div>

    <div class="form-group">
      <label >Password</label>
      <input type="password" name="password" class="form-control" placeholder="Password">
    </div>

    <div class="form-group">
      <label for="role" >Role</label>
      <select class="form-control" id="role" name="id_role" required>
        <option value="">select role</option>
        <?php foreach ($role as $r) : ?>
          <option value="<?= $r['id_role']; ?>"><?= $r['role']; ?></option>
        <?php endforeach ; ?>
      </select>
    </div>

    <div class="form-group">
      <label >Divisi</label>
      <select class="form-control" id="divisi" name="id_divisi" required>
        <option value="">select divisi</option>
        <?php foreach ($divisi as $r) : ?>
          <option value="<?= $r['id_divisi']; ?>"><?= $r['nama_divisi']; ?></option>
        <?php endforeach ; ?>
      </select>
    </div>

    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="status" name="status">
      <label class="custom-control-label" for="status">Status</label>
    </div>
<br><br>

		<input type="hidden" name="id_user">

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<script>
    $('.custom-file-input').on('change', function() {
        let filename = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass('selected').html(filename);
    });
</script>
const flashdata = $('.flash-data').data('flashdata');

if (flashdata) {
	swal({
		title : 'Data',
		text : 'Berhasil' + flashdata,
		type : 'success'
	});

}

// klik delete

$('.klik-delete').on('click', function (d) {

	d.preventdefault();
	const href = $(this).attr('href');

	swal({

	const swalWithBootstrapButtons = Swal.mixin({
  	customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  	},
  	buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
	  title: 'Are you sure?',
	  text: "You won't be able to revert this!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonText: 'Yes, delete it!',
	  cancelButtonText: 'No, cancel!',
	  reverseButtons: true
	}).then((result) => {
	  if (result.value) {
	  	document.location.href = href;
	    // swalWithBootstrapButtons.fire(
	      // 'Deleted!',
	      // 'Your file has been deleted.',
	      // 'success'
    )
	  } else if (
	    /* Read more about handling dismissals below */
	    result.dismiss === Swal.DismissReason.cancel
	  ) {
	    swalWithBootstrapButtons.fire(
	      'Cancelled',
	      'Your imaginary file is safe :)',
	      'error'
	    )
	  }
})
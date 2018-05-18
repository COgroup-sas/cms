jQuery(function () {
	if(jQuery('.js-basic').length > 0) {
    jQuery('.js-basic').DataTable({
    	resposive: true,
      "language": {
        "url": SITE_URL +  "vendor/cogroup/cms/js/i18n/spanish.datatable.json"
      }
    });
  };
  if(jQuery('.js-exportable').length > 0) {
    //Exportable table
    jQuery('.js-exportable').DataTable({
    		resposive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
          "url": SITE_URL +  "vendor/cogroup/cms/js/i18n/spanish.datatable.json"
    }
    });
  };
});
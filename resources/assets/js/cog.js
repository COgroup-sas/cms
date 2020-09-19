/* COG functions */
jQuery(function () {
  setTimeout(function () { jQuery('.preloader').fadeOut(); }, 50);

  jQuery.ajaxSetup({
    headers: {
      'X-CSRF-Token': jQuery('input[name="_token"]').val()
    }
	});

  if(jQuery('.masked-input').length > 0) {
    var $MaskedInput = jQuery('.masked-input');

    //Mobile Phone Number
    $MaskedInput.find('.mobile-phone-number').inputmask('(99) 999-999-9999', { placeholder: '(__) ___-___-____' });
    //Phone Number
    $MaskedInput.find('.phone-number').inputmask('(99) 9 999-9999', { placeholder: '(__) _ ___-____' });
	}

  if(jQuery(".allcheck").length > 0) {
    jQuery(".allcheck").on('change', function() {
      var status = jQuery(this).is(":checked");
      jQuery(".check").each(function () {
        jQuery(this).prop('checked', status);
      });
      jQuery(".allcheck").each(function () {
        jQuery(this).prop('checked', status);
      });
    });
  }

  if(jQuery(".btnaction").length > 0) {
	  jQuery(".btnaction").each(function () {
	  	jQuery(this).on("click", function(e){
				event.preventDefault();
				var url = jQuery(this).attr('href');
				var check = 0;
				var id = jQuery(this).attr('id');
				jQuery(".check").each(function() {
					if(jQuery(this).is(":checked") == true) check++;
				});
				if(check == 1) {
					jQuery(".form").attr('action', url);
					jQuery(".form").submit();
				}
				else if(check > 1) jQuery("#more-" + id + "-modal-error").modal();
				else jQuery("#" + id + "-modal-error").modal();
			});
		});
	}

	if(jQuery(".btnaction2").length > 0) {
	  jQuery(".btnaction2").each(function () {
	  	jQuery(this).on("click", function(e){
				event.preventDefault();
				var url = jQuery(this).attr('href');
				var check = 0;
				var idmodal = jQuery(this).attr('id');
				var id = '';
				jQuery(".check").each(function() {
					if(jQuery(this).is(":checked") == true) check++;
					id = jQuery(this).val();
				});
				if(check == 1) {
					jQuery(location).attr('href', url + "/" + id);
				}
				else if(check > 1) jQuery("#more-" + idmodal + "-modal-error").modal();
				else jQuery("#" + idmodal + "-modal-error").modal();
			});
		});
	}

	if(jQuery("#btndelete").length > 0) {
		jQuery("#btndelete").on("click", function(e){
			event.preventDefault();
			var url = jQuery(this).attr('href');
			var check = 0;
			jQuery(".check").each(function() {
				if(jQuery(this).is(":checked") == true) check++;
			});
			if(check > 0) {
				jQuery("#delete-modal").modal();
				jQuery(".form").attr('action', url);
			}
			else jQuery("#delete-modal-error").modal();
			jQuery("#modal-yes").on("click", function(){
				jQuery(".form").submit();
			});
		});
	}

	if(jQuery('.perm').length > 0) {
		var $this = jQuery('.perm').on('change', function() {
			console.log(this.checked);
			var id = jQuery(this).attr("data-id");
			var perm = jQuery(this).attr("data-perm");
			var rolid = jQuery(this).attr("data-rol-id");
			var url = jQuery("#rolurl").val();
			var thischeck = (jQuery('#'+id+'-'+perm).is(':checked') == true) ? 1 : 0;
			jQuery.post( url, {
				modules_id : id,
				perm: perm,
				roles_id: rolid,
				value: thischeck
			}).done(function (result) {
				if(result.status != false) {
					var thischeck = (jQuery("#"+id+'-'+perm).is(":checked") == true) ? 0 : 1;
					//jQuery("#"+id+'-'+perm).prop( "checked", thischeck );
				}
			});
		});
	}

	if(jQuery('.user-active').length > 0) {
		jQuery(".user-active").click(function (e) {
			event.preventDefault();
			//detect type
			var useractive = jQuery(this);
			var id = jQuery(this).attr("data-id");
			var active = (jQuery(this).attr("data-active") == 'Y') ? 'N' : 'Y';
			var urlactive = jQuery(this).attr('href');

			var result = $.post( urlactive, { id : id, active : active });

			result.done(function(data) {
				if(data.status != false) {
					var text = (active == 'Y') ? 'fa-check-circle' : 'fa-circle';
					var removetext = (active == 'Y') ? 'fa-circle' : 'fa-check-circle';
					jQuery(useractive).attr("data-active", active);

					jQuery(useractive).find("i.far").addClass(text);
					jQuery(useractive).find("i.far").removeClass(removetext);
				}
				else {
					console.log('error');
				}
			});
		});
	}

	jQuery('[data-toggle="tooltip"]').tooltip();
  jQuery('[data-toggle="popover"]').popover();
  if(jQuery('#loginModal').length > 0) {
    jQuery('#loginModal').modal('show');
  }
  if(jQuery('.datepicker').length > 0) {
    jQuery('.datepicker').each(function() {
      jQuery(this).datepicker({
        format: 'yyyy-mm-dd',
        iconsLibrary: 'fontawesome',
        maxDate: '{{ date("Y-m-d") }}',
        weekStartDay: 0
        //locale: '{{ app()->getLocale() }}-{{ app()->getLocale() }}'
      });
    });
  }
  if(jQuery('.timepicker').length > 0) {
    jQuery('.timepicker').each(function () {
      jQuery(this).timepicker({
        format: 'HH:MM',
        value: '@if(!empty($value)){{ $value }}@else{{ date("H:i") }}@endif',
        weekStartDay: 0
        //locale: '{{ app()->getLocale() }}-{{ app()->getLocale() }}'
      });
    });
  }
  jQuery('select').each(function(index){
    var id = jQuery(this).attr('id');
    if(typeof(id) !== 'undefined') {
      jQuery('#' + id).select2({
        theme: "bootstrap4",
        width: jQuery(this).data('width') ? jQuery(this).data('width') : jQuery(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: jQuery(this).data('placeholder')
      });
    }
  });
  if(jQuery('.tagsinput').length > 0) {
    jQuery('.tagsinput').each(function() {
      var id = jQuery(this).attr('id');
      jQuery('#' + id).tagsInput({
        'unique': true,
        'minChars': 2,
        'validationPattern': new RegExp('^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$'),
        'placeholder': jQuery(this).attr('placeholder')
      });
    });
  };

  if(jQuery('.button-collapse').length > 0) {
  	jQuery(".button-collapse").sideNav();
		// SideNav Scrollbar Initialization
		var sideNavScrollbar = document.querySelector('.custom-scrollbar');
		var ps = new PerfectScrollbar(sideNavScrollbar);
  }

  if(jQuery('.open-nav').length > 0) {
  	jQuery('.open-nav').on('click', function() {
  		jQuery('.sidenav').addClass('show');
  		jQuery('main').css('transform', "translateX(255)");
  		jQuery('<div id="sidenavoverlay"></div>').appendTo('body');
  	});
	}

	jQuery(document).on("click", "#sidenavoverlay" , function() {
		jQuery('.sidenav').removeClass('show');
		jQuery('main').css('transform', 'translateX(0)');
		jQuery('#sidenavoverlay').remove();
	});

	if(jQuery('#vertical-accordion-menu').length > 0) {
		jQuery("#vertical-accordion-menu").jqueryAccordionMenu();
	}

	if(jQuery('#toast-container').length > 0) {
		jQuery('#toast-container').toast('show').on('hidden.bs.toast', function () {
      jQuery(this).remove();
    });
	}
});
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 $(function () {
  setTimeout(function () { $('.preloader').fadeOut(); }, 50);

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

	if(jQuery('.notification').length > 0) {
    var placementFrom = jQuery('.notification').data('placement-from');
    var placementAlign = jQuery('.notification').data('placement-align');
    var animateEnter = jQuery('.notification').data('time');
    var colorName = jQuery('.notification').data('color-name');
    var text = jQuery('.notification').data('text');

    nowuiDashboard.showSidebarMessage(text, colorName, placementFrom, placementAlign);
  };

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
					$(location).attr('href', url + "/" + id);
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
		var $this = jQuery('.perm').children('.bootstrap-switch').on('switchChange.bootstrapSwitch', function(e) {
			var $this = jQuery(this);
			console.log('action por aca');
			// CSRF protection
			var id = $this.parents('label').attr("data-id");
			var perm = $this.parents('label').attr("data-perm");
			var rolid = $this.parents('label').attr("data-rol-id");
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
					jQuery("#"+id+'-'+perm).prop( "checked", thischeck );
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
});
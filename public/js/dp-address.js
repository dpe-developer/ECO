$(function(){

	var dpAddressID = 0;
	var customID = 'dp-address-' + dpAddressID;

	$.fn.dpAddress = function(option) {
		var showModal = typeof option === 'object' ? option.showModal : true;
		$(this).addClass('dp-address')

		$('.dp-address').each(function(){
			$(this).attr('data-dp-address', dpAddressID)
			var dataCustomID = $(this).data('dp-address-custom-id');
			if(dataCustomID){
				customID = dataCustomID+'-'+dpAddressID;
			}
			appendAddressModal($(this));
			setModalInputValue($(this));
			saveAddress($(this));
			dpAddressID++;
		})

		
		$(this).on('click', function(){
			setModalInputValue($(this));
			var dataID = $(this).data('dp-address');
			if (showModal) {
				$('.dp-address-modal[data-dp-address="'+dataID+'"]').modal('show')
			}
		})

		$('.dp-address-save-btn').on('click', function(){
			saveAddress($(this));
		})

	};

	function setModalInputValue(dpAddress) {
		var dataID = $(dpAddress).data('dp-address');
		var inputBaseName = $(dpAddress).data('dp-address-input-name');
			
		var sub_address_1 = $('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="address_1"]').val();
		var sub_address_2 = $('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="address_2"]').val();
		var sub_city = $('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="city"]').val();
		var sub_state = $('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="state"]').val();
		var sub_country = $('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="country"]').val();
		var sub_postal_code = $('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="postal_code"]').val();
		var sub_remarks = $('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="address_remarks"]').val();
		var sub_type = $('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="address_type"]').val();

		$('.dp-address-modal-input-address-1[data-dp-address="'+dataID+'"]').val((sub_address_1 ? sub_address_1 : ''));
		$('.dp-address-modal-input-address-2[data-dp-address="'+dataID+'"]').val((sub_address_2 ? sub_address_2 : ''));
		$('.dp-address-modal-input-city[data-dp-address="'+dataID+'"]').val((sub_city ? sub_city : ''));
		$('.dp-address-modal-input-state[data-dp-address="'+dataID+'"]').val((sub_state ? sub_state : ''));
		$('.dp-address-modal-input-country[data-dp-address="'+dataID+'"]').val((sub_country ? sub_country : ''));
		$('.dp-address-modal-input-postal-code[data-dp-address="'+dataID+'"]').val((sub_postal_code ? sub_postal_code : ''));
		$('.dp-address-modal-input-address-remarks[data-dp-address="'+dataID+'"]').val((sub_remarks ? sub_remarks : ''));
		$('.dp-address-modal-input-address-type[data-dp-address="'+dataID+'"]').val((sub_type ? sub_type : ''));
	}

	function saveAddress(dpAddress) {
		var dataID = $(dpAddress).data('dp-address');
		var inputBaseName = $(dpAddress).data('dp-address-input-name');
			
		var address_1 = $('.dp-address-modal-input-address-1[data-dp-address="'+dataID+'"]').val();
		var address_2 = $('.dp-address-modal-input-address-2[data-dp-address="'+dataID+'"]').val();
		var city = $('.dp-address-modal-input-city[data-dp-address="'+dataID+'"]').val();
		var state = $('.dp-address-modal-input-state[data-dp-address="'+dataID+'"]').val();
		var country = $('.dp-address-modal-input-country[data-dp-address="'+dataID+'"]').val();
		var postal_code = $('.dp-address-modal-input-postal-code[data-dp-address="'+dataID+'"]').val();
		var remarks = $('.dp-address-modal-input-address-remarks[data-dp-address="'+dataID+'"]').val();
		var type = $('.dp-address-modal-input-address-type[data-dp-address="'+dataID+'"]').val();
			
		$('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="address_1"]').val((address_1 ? address_1 : ''));
		$('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="address_2"]').val((address_2 ? address_2 : ''));
		$('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="city"]').val((city ? city : ''));
		$('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="state"]').val((state ? state : ''));
		$('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="country"]').val((country ? country : ''));
		$('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="postal_code"]').val((postal_code ? postal_code : ''));
		$('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="address_remarks"]').val((remarks ? remarks : ''));
		$('.dp-address-sub-input[data-dp-address-input-name="'+inputBaseName+'"][name="address_type"]').val((type ? type : ''));

		address_1 = (address_1 != '' && address_1 != null) ? address_1 + '\n' : '';
		address_2 = (address_2 != '' && address_2 != null) ? address_2 + '\n' : '';
		city_state = (city != '' && city != null) && (state != '' && state != null) ? city + ', ' + state + '\n' : ((city != '' && city != null) ? city + '\n' : ((state != '' && state != null) ? state + '\n' : ''));
		country = (country != '' && country != null) ? country + '\n' : '';
		postal_code = (postal_code != '' && postal_code != null) ? postal_code + '\n' : '';
		remarks = (remarks != '' && remarks != null) ? remarks + '\n' : '';
		type = (type != '' && type != null) ? '(' + type + ')' : '';
		var complete_address = 
			address_1 +
			address_2 +
			city_state +
			country +
			postal_code +
			remarks +
			type;
		$('.dp-address[data-dp-address="'+dataID+'"]').html(complete_address);
		$('.dp-address-modal[data-dp-address="'+dataID+'"]').modal('hide');
	}

	function appendAddressModal(dpAddress) {
		var addressModalTitle = $(dpAddress).data('dp-address-title')!=undefined ? $(dpAddress).data('dp-address-title') : 'Address';
		var inputName = $(dpAddress).data('dp-address-input-name')!=undefined ? $(dpAddress).data('dp-address-input-name') : 'Address'
		var addressModal = 
			'<input name="'+inputName+'" value="'+inputName+'" type="hidden" data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'" class="dp-address-base-input">' +
			'<div data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'" class="modal fade dp-address-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">' +
			'<div class="modal-dialog" role="document">' +
				'<div class="modal-content modal-md">' +
					'<div class="modal-header">' +
						'<h5 class="modal-title">'+addressModalTitle+'</h5>' +
						'<a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">' +
		                    '<span aria-hidden="true">&times;</span>' +
		                '</a>' +
					'</div>' +
					'<div class="modal-body">' +
						'<table class="table table-borderless table-form">' +
							'<tr>' +
								'<td>' +
									'<label>Street</label>' +
								'</td>' +
								'<td colspan="3">' +
									'<input name="address_1['+inputName+']" data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'" class="form-control form-control-sm dp-address-modal-input-address-1" type="text">' +
									'<input name="address_2['+inputName+']" data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'" class="form-control form-control-sm dp-address-modal-input-address-2" type="text">' +
								'</td>' +
							'</tr>' +
							'<tr>' +
								'<td>' +
									'<label>City</label>' +
								'</td>' +
								'<td>' +
									'<input name="city['+inputName+']" data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'" class="form-control form-control-sm dp-address-modal-input-city" type="text">' +
								'</td>' +
								'<td>' +
									'<label>State/Province</label>' +
								'</td>' +
								'<td>' +
									'<input name="state['+inputName+']" data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'" class="form-control form-control-sm dp-address-modal-input-state" type="text">' +
								'</td>' +
							'</tr>' +
							'<tr>' +
								'<td>' +
									'<label>Country</label>' +
								'</td>' +
								'<td>' +
									'<input name="country['+inputName+']" data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'" class="form-control form-control-sm dp-address-modal-input-country" type="text">' +
								'</td>' +
								'<td>' +
									'<label>Zip/Postal Code</label>' +
								'</td>' +
								'<td>' +
									'<input name="postal_code['+inputName+']" data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'" class="form-control form-control-sm dp-address-modal-input-postal-code" type="text">' +
								'</td>' +
							'</tr>' +
							'<tr>' +
								'<td>' +
									'<label>Type</label>' +
								'</td>' +
								'<td colspan="3">' +
									'<select name="address_type['+inputName+']" data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'" class="form-control dp-address-modal-input-address-type">' +
										'<option></option>' +
										'<option value="Commercial Address">Commercial Address</option>' +
										'<option value="Residential Address">Residential Address</option>' +
									'</select>' +
								'</td>' +
							'</tr>' +
							'<tr>' +
								'<td>' +
									'<label>Remarks</label>' +
								'</td>' +
								'<td colspan="3">' +
									'<textarea name="address_remarks['+inputName+']" data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'" class="form-control form-control-sm dp-address-modal-input-address-remarks"></textarea>' +
								'</td>' +
							'</tr>' +
						'</table>' +
					'</div>' +
					'<div class="modal-footer text-right">' +
						'<button class="btn btn-primary dp-address-save-btn" type="button" data-dp-address-input-name="'+inputName+'" data-dp-address="'+dpAddressID+'" data-dp-address-custom-id="'+customID+'">Save</button>' +
					'</div>' +
				'</div>' +
			'</div>' +
		'</div>';

		$(dpAddress).parent().append(addressModal);
	}
})
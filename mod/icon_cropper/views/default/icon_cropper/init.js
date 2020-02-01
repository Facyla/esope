define(function(require) {
	
	var $ = require('jquery');
	var elgg = require('elgg');
	require('jquery-cropper/jquery-cropper');
	
	function Cropper() {
		var $field;
		var $fieldWrapper;
		var $img;
		var $imgWrapper;
		var $inputWrapper;
		var $messagesWrapper;
		var that = this;
		
		this.init = function(selector) {
			$field = $(selector);
			$fieldWrapper = $field.closest('.elgg-field');
			$imgWrapper = $fieldWrapper.siblings('.icon-cropper-wrapper');
			$img = $imgWrapper.find('> img').eq(0);
			$inputWrapper = $fieldWrapper.siblings('.icon-cropper-input').eq(0);
			
			$messagesWrapper = $fieldWrapper.siblings('.icon-cropper-messages');
			
			$field.on('change', this.replaceImg);
			
			$remove = $fieldWrapper.siblings('.elgg-entity-edit-icon-remove').find('input[type="checkbox"]');
			$remove.on('change', this.checkRemoveState);
			
			if ($img[0].hasAttribute('src')) {
				this.reload();
			}
		};
	
		this.replaceImg = function() {
			var oFReader = new FileReader();
			oFReader.readAsDataURL(this.files[0]);
		    
			// remove previous state
			$imgWrapper.addClass('hidden');
			$img.off('crop.iconCropper');
	    	$img.cropper('destroy');
	    	$img.attr('src', '');
	    	
	    	that.resetMessages();
			
			// validate image
		    oFReader.onload = function (oFREvent) {
		    	var image = new Image();
		    	image.src = this.result;
		    	
		    	image.onload = function(imageEvent) {
		    		$img.attr('src', this.src);
		    		
		    		$inputWrapper.find('input[name="icon_cropper_guid"], input[name="icon_cropper_type"], input[name="icon_cropper_name"]').remove();
		    		
		    		that.reload({
		    			data: {}
		    		});
		    	};
		    };
		};
		
		this.reload = function(extra_data) {
			extra_data = extra_data || {};

			$imgWrapper.removeClass('hidden');
			
			var data = $img.data().iconCropper;
			$.extend(data, extra_data);

			$img.cropper(data);
			$img.on('crop.iconCropper', this.crop);
		};
		
		this.crop = function(event) {
			var cropDetails = $img.cropper('getData', true);
			
			that.resetMessages();
			
			if (elgg.data.iconCropper.minWidth > 0 && cropDetails.width < elgg.data.iconCropper.minWidth) {
				that.showMessage('width');
			}
			if (elgg.data.iconCropper.minHeight > 0 && cropDetails.height < elgg.data.iconCropper.minHeight) {
				that.showMessage('height');
			}
			
			$inputWrapper.find('input[name="x1"]').val(cropDetails.x);
			$inputWrapper.find('input[name="y1"]').val(cropDetails.y);
			$inputWrapper.find('input[name="x2"]').val(cropDetails.x + cropDetails.width);
			$inputWrapper.find('input[name="y2"]').val(cropDetails.y + cropDetails.height);
		};
		
		this.resetMessages = function() {
			if (!$messagesWrapper.length) {
				return;
			}
			
			$messagesWrapper.addClass('hidden');
			$messagesWrapper.find('.icon-cropper-error-generic').addClass('hidden');
			$messagesWrapper.find('.icon-cropper-error-width').addClass('hidden');
			$messagesWrapper.find('.icon-cropper-error-height').addClass('hidden');
		};
		
		this.showMessage = function(message_type) {
			if ($.inArray(message_type, ['width', 'height']) < 0) {
				return;
			}
			
			if (!$messagesWrapper.length) {
				return;
			}
			
			$messagesWrapper.removeClass('hidden');
			$messagesWrapper.find('.icon-cropper-error-generic').removeClass('hidden');
			$messagesWrapper.find('.icon-cropper-error-' + message_type).removeClass('hidden');
		};
		
		this.show = function() {
			$fieldWrapper.removeClass('hidden');
			this.reload();
			$img.trigger('crop.iconCropper');
		};
		
		this.hide = function() {
			$fieldWrapper.addClass('hidden');
			$imgWrapper.addClass('hidden');
			this.resetMessages();
		};
		
		this.checkRemoveState = function() {
			if ($(this).is(':checked')) {
				that.hide();
			} else {
				that.show();
			}
		};
	};
	
	return Cropper;
});

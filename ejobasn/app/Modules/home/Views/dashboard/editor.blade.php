<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="packages/static/js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="packages/static/js/tinymce/plugins/tiny_mce_wiris/editor_plugin.js"></script>
		<script>
		  	tinymce.init({
		    	selector: '#editor',
		    	height : 400,
		    	plugins: [
					'advlist autolink lists link image charmap print preview hr anchor pagebreak',
					'searchreplace wordcount visualblocks visualchars code fullscreen',
					'insertdatetime media nonbreaking save table contextmenu directionality',
					'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help',
					'tiny_mce_wiris'
			  	],
			  	toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',
  				toolbar2: 'print preview | forecolor backcolor emoticons | codesample | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry',
  				image_advtab: true,
		    	relative_urls: false,
		    	remove_script_host: false,
		    	file_picker_callback: elfinder_browser,
		    	convert_urls: false,
		 	});

		 	function elfinder_browser(callback, value, meta){
		 		tinymce.activeEditor.windowManager.open({
		 			file: "packages/static/js/elfinder/elfinder.html",
		 			title: "Elfinder Explore",
		 			width: 900,
		 			height: 450,
		 			resizable: "true"
		 		}, {
    			oninsert: function (file, elf) {
      				var url, reg, info;
				    // URL normalization
				    url = file.url;
				    reg = /\/[^/]+?\/\.\.\//;
				    while(url.match(reg)) {
				      url = url.replace(reg, '/');
				    }      
				    // Make file info
				    info = file.name + ' (' + elf.formatSize(file.size) + ')';

					// Provide file and text for the link dialog
					if (meta.filetype == 'file') {
						callback(url, {text: info, title: info});
					}
					// Provide image and alt text for the image dialog
					if (meta.filetype == 'image') {
						callback(url, {alt: info});
					}
					// Provide alternative source and posted for the media dialog
					if (meta.filetype == 'media') {
						callback(url);
					}
    			}
  			});
  			return false;
		}
		</script>
	</head>
	<body>
		<form method="post">
			<textarea id="editor"></textarea>
		</form>
	</body>
</html>
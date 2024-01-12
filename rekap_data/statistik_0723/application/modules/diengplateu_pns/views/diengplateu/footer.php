
	<script type="text/javascript" src="<?php echo $def_js?>holder.js"></script>
	<!-- Metis Menu Plugin JavaScript -->
    <script type="text/javascript" src="<?php echo $def_js?>metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="<?php echo $def_js?>main.js"></script>
	<script>
	// outdatedbrowser
		//event listener: DOM ready
		function addLoadEvent(func) {
		    var oldonload = window.onload;
		    if (typeof window.onload != 'function') {
		        window.onload = func;
		    } else {
		        window.onload = function() {
		            oldonload();
		            func();
		        }
		    }
		}
		//call plugin function after DOM ready
		addLoadEvent(
		    outdatedBrowser({
		        bgColor: '#f25648',
		        color: '#ffffff',
		        lowerThan: 'transform',
		        languagePath: '<?php echo base_url()?>assets/outdatedbrowser/lang/id.html'
		    })
		);

		$(document).ready(function() {
			// Ajax menu			
			$('#page-wrapper').load('<?php echo base_url()?>diengplateu/page/dashboard');
			$('#loading-state').fadeOut("slow");
			// Sidebar navigation
			$('.sidebar .nav > li > a').not('.external-link').click(function(){
				var href = $(this).attr('href');
				var anchor = $(this);
				$('.sidebar .nav > li > a').removeClass('active');
				if (href=="#" || href=="") {
					// disable ajax for empty link
					return false;
				} else {
					// start ajax if not empty link
					$.ajax({
						url: href,
						type: "POST",
						dataType: "html",
						beforeSend: function(){
							$('#loading-state').fadeIn("slow");
						},
						success: function(html){
						  $('#loading-state').fadeOut("slow");
						  $("#page-wrapper").html(html);
						  anchor.addClass('active');
						  $('.sidebar-nav.navbar-collapse').removeClass('in');
						}
					});
				}
				return false;
			});
		});
	</script>	
</body>
</html>
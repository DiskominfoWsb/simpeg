@include('home::dashboard.header') 
@include('home::dashboard.sidebar-left') 

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper" id='utama'>
	</div>
	<!-- /.content-wrapper -->

	<script>
		$(document).ready(function() {
			preloader = new $.materialPreloader({
			    position: 'top',
			    height: '5px',
			    col_1: '#159756',
			    col_2: '#da4733',
			    col_3: '#3b78e7',
			    col_4: '#fdba2c',
			    fadeIn: 200,
			    fadeOut: 200
			});

			$.ajax({
                type: 'get',
				url : '{{ $redirect_url }}',
				data: '{{ $query_string_url }}',
                beforeSend: function(){
                	preloader.on();

					// remove class active di semua <li>
					$(".sidebar-menu li").removeClass("active");
                },
                success: function(data) {
                    $('#utama').html(data);
                },
				complete: function(){
					preloader.off();

					var menu_selected = $("a[href='{{ $redirect_url }}']");

					// add class active di current li
					menu_selected.parent().addClass('active');
					menu_selected.parent().parent().parent().addClass('active');
				}
            });
		});
	</script>

@include('home::dashboard.footer') 
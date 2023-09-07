		  <footer class="main-footer">
		    <div class="pull-right hidden-xs">
		      <b>Version</b> 2.3.3
		    </div>
		    <strong>Copyright &copy; 2014-{{date('Y')}} <a href="http://dinustek.com">Dinustek</a>.</strong> All rights
		    reserved.
		  </footer>
		  <!-- Control Sidebar -->
		  <div class="control-sidebar-bg"></div>
		</div>
	<!-- ./wrapper -->

	{{--JS untuk refresh page (dengan cara tekan F5 di keyboard)--}}
	<script src="{{ asset('packages/tugumuda/js/refresh-page.js')}}"></script>
	{{--<script type="text/javascript">
		set_access_token('{{ access_token() }}');
	</script>--}}
    <script type="text/javascript" src="{!!asset('packages/static/plugins/timepicker/bootstrap-timepicker.min.js')!!}"></script>
	{!! modal(false,'modal_notif') !!}

	{!! modal(true,'modal_notif2') !!}
	</body>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.linkmod').on('click',function(e){
                e.preventDefault();
                var $this =$(this);
                claravel_modal('Notifikasi Sinkronisasi Data','Loading...','modal_notif');
                $.ajax({
                    type: 'post',
                    url : $this.attr('href'),
                    data: {'_token' : '{!!csrf_token()!!}'},
                    success:function(html){
                        $('#modal_notif .modal-body').html(html);
                    }
                });
            });
        });
    </script>
</html>

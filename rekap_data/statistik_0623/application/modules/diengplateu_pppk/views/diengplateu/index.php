
<?php $this->template->load($themes.'header',$themes.'header'); ?>
	
	<?php $this->template->load($themes.'navigation',$themes.'navigation'); ?>

    <!-- Page Content -->	
    <div id="page-wrapper">
		<div id="loading-state">
			<i class='fa fa-refresh fa-spin fa-5x'></i>
			<p>Memuat Halaman...</p>			
		</div>  
	</div>
	<!-- /#page-wrapper -->

<?php $this->template->load($themes.'footer',$themes.'footer'); ?>
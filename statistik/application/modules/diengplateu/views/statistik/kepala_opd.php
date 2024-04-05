<script type="text/javascript">
var xhr = $.ajax();
$(document).ready(function(){
    getKepalaOpd();

    $('#id_bulan, #id_tahun').select2();
    
    $('#id_bulan').click(function(){
        getKepalaOpd();
    });

    $('#id_tahun').click(function(){
        getKepalaOpd();
    });

    function getKepalaOpd(){
        xhr.abort();
        xhr = $.ajax({
            url:'<?=base_url()?>diengplateu/data/hasil_kepala_opd',
            type:'post',
            data:{ 'id_tahun':$('#id_tahun').val(),'id_bulan':$('#id_bulan').val() },
            beforeSend:function(){
                $('#result').html('<i class="icon-spinner icon-spin"></i> Loading...');
            },
            success:function(response){
                $('#result').html(response);
            }
        });
    }
});
</script>

<style>
    .filter {
        background-color: white; /* Specify the background color here */
        padding: 5px;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Daftar Kepala OPD</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row filter">
    <div class="alert-warning" style="padding: 5px; margin: 10px">
        Bulan : <?= $this->siemodel->getBulan("id_bulan",date('m')); ?>&nbsp;&nbsp;
        Tahun : <?= $this->siemodel->getTahun("id_tahun",date('Y')); ?>&nbsp;&nbsp;
        <a href="<?=base_URL()?>diengplateu/page/download_excell" target="_blank">
        <button type="submit" class="btn btn-sm btn-primary btn-sidebar">Download</button></a><br>
    </div>
</div>

<div id="result"></div>
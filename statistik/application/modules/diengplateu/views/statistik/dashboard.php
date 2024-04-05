<style>
    .filter {
        background-color: white; /* Specify the background color here */
        padding: 5px;
        margin: 1px;
    }
</style>

<script type="text/javascript">
    var xhr = $.ajax();
    $(document).ready(function(){
        getDashboard();
        
        $('#id_bulan, #id_tahun').select2();

        $('#id_bulan').click(function(){
            getDashboard();
        });

        $('#id_tahun').click(function(){
            getDashboard();
        });

        function getDashboard(){
            xhr.abort();
            xhr = $.ajax({
                url:'<?=base_url()?>diengplateu/data/hasil_dashboard',
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
        

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row filter">
    <div class="alert-warning" style="padding: 5px; margin: 10px">
        Bulan : <?= $this->siemodel->getBulan("id_bulan",date('m')); ?>&nbsp;&nbsp;
        Tahun : <?= $this->siemodel->getTahun("id_tahun",date('Y')); ?>&nbsp;&nbsp;
    </div>
</div>
<!-- /.row -->
<div id="result"></div>
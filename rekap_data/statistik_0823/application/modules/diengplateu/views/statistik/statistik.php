<script type="text/javascript">
    var xhr = $.ajax();

    $(document).ready(function(){
        refreshStatistik();
        $('#idkategori, #kdunit, #idskpd').select2();
        $('#kdunit').change(function(){
            $.ajax({
                url:'<?php echo base_url()?>diengplateu/ajax/xkdunit',
                type:'post',
                data:{'idskpd': $('#kdunit').val()},
                beforeSend:function(){
                    $('#xkdunit').html('<i class="icon-spinner icon-spin"></i> Loading...');
                },
                success:function(response){
                    $('#xkdunit').html(response);
                    $('#idskpd').select2();
                    refreshStatistik();
                }
            });
        });

        $('#idkategori').click(function(){
            refreshStatistik();
        });
    });

    function refreshStatistik(){
        xhr.abort();
        xhr = $.ajax({
            url:'<?=base_url()?>diengplateu/data/statistik',
            type:'post',
            data:{ 'idskpd':$('#idskpd').val(),'idkategori':$('#idkategori').val() },
            beforeSend:function(){
                $('#result').html('<i class="icon-spinner icon-spin"></i> Loading...');
            },
            success:function(response){
                $('#result').html(response);
            }
        });
    }
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Data ASN Bulan Juli 2023</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <span class="active"><i class="fa fa-bar-chart-o fa-fw"/> Statistik PNS Kab. Wonosobo</span>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="alert-warning" style="padding: 5px">
                    <form class="form-inline">
                        <div align="pull-right">
                            Kategori : <?php echo $this->siemodel->listKategori("idkategori",$this->uri->segment(4),$required="");?>
                            Unit Kerja : <?php echo $this->siemodel->listSkpd2($id="kdunit",$sel="",$required="");?>
                            Sub Unit Kerja :
                        <span id="xkdunit">
                            <select id="idskpd" class="idskpd form-controls" name="" style="width:230px">
                                <option value="">.: Pilih Sub Unit :.</option>
                            </select>
                        </span>
                        </div>
                    </form>
                </div><br>

                <div id="result"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

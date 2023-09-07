<script>
    $(document).ready(function(){
        $('#tb-statistik .link').click(function(){
            var index = $('#tb-statistik .link').index($(this));
            var par = $('#tb-statistik .link').eq(index).parent().parent();
            var vidwhere = $('#tb-statistik .link').eq(index).attr("data");
            var vidjenkel = $(par).find('.ed1').html();
            var vidskpd = $('#tb-statistik .link').eq(index).attr("skpd");
            $('#form-print #idwhere').val(vidwhere);
            $('#form-print #idjenkel').val(vidjenkel);
            $('#form-print #idskpd').val(vidskpd);
            $('#form-print').submit();
        });
    });
</script>
<style>
    .link{
        cursor:pointer;
        color: blue;
    }
</style>

<form id="form-print" name="form-print" action="<?=base_url()?>diengplateu/page/statistik_statfungsekdes_print" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
    <input type="hidden" id="idwhere" name="idwhere" value="" />
    <input type="hidden" id="idjenkel" name="idjenkel" value="" />
    <input type="hidden" id="idskpd" name="idskpd" value="" />
</form>

<div class="row">
    <div class="span5">
        <table class="table table-hover table-bordered" width="100%" id="tb-statistik">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Jenis Kelamin</div></th>
                    <th><div align="center">Jumlah</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $x = 0;
                $jmlall[$x]  = 0;
                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND a.idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT IF(a.idjenkel=1,'Pria',IF(a.idjenkel=2,'Wanita','-')) AS kategori, idjenkel, COUNT(*) AS pns FROM tb_1022  a 
                        LEFT JOIN a_jabfungum b ON a.idjabfungum = b.idjabfungum
                        WHERE a.idjenkedudupeg NOT IN (99,21)     AND (a.niplama LIKE '%sekdes%' OR b.jabfungum = 'sekdes') $where GROUP BY a.idjenkel;");
                foreach ($rs->result() as $item) {
                    $jmlall[$x]  = $item->pns;
                    $x++;
                    ?>
                <tr>
                    <td>
                        <?php echo $x?>
                        <span class="ed1" style="display:none"><?=$item->idjenkel?></span>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="text" align="right" data="0" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->pns)?></div></td>
                </tr>
            <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="text" align="right" data="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#tb-statistik .link').click(function(){
            var index = $('#tb-statistik .link').index($(this));
            var par = $('#tb-statistik .link').eq(index).parent().parent();
            var vidwhere = $('#tb-statistik .link').eq(index).attr("data");
            var vidskpd = $(par).find('.ed1').html();
            var vidjenkel = $('#tb-statistik .link').eq(index).attr("jenkel");
            $('#form-print #idwhere').val(vidwhere);
            $('#form-print #idskpd').val(vidskpd);
            $('#form-print #idjenkel').val(vidjenkel);
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

<form id="form-print" name="form-print" action="<?=base_url()?>diengplateu/page/statistik_statskpd_print" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
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
                    <th><div align="center">OPD</div></th>
                    <th><div align="center">Pria</div></th>
                    <th><div align="center">Wanita</div></th>
                    <th><div align="center">Total</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $x = 0;
                $x = 0;
                $jmlall[$x]  = 0;
                $sumallp[$x] = 0;
                $sumallw[$x] = 0;
                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND a.idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT b.skpd as kategori, b.idskpd, SUM(IF(a.idskpd!='' AND a.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(a.idskpd!='' AND a.idjenkel = 2,1,0)) AS jmlwanita FROM tb_1022 a
                      INNER JOIN skpd b ON LEFT(a.idskpd,2) = b.idskpd WHERE a.idjenkedudupeg NOT IN (99,21) $where GROUP BY LEFT(a.idskpd,2)");
                foreach ($rs->result() as $item) {
                    $sumallp[$x] = $item->jmlpria;
                    $sumallw[$x] = $item->jmlwanita;
                    $jmlall[$x]  = $item->jmlpria + $item->jmlwanita;
                    $x++;
                ?>
                <tr>
                    <td>
                        <?php echo $x?>
                        <span class="ed1" style="display:none"><?=$item->idskpd?></span>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="text" align="right" data="0" jenkel="1" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="text" align="right" data="0" jenkel="2" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="text" align="right" data="0" jenkel="sum" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div align="text"><?php echo number_format(array_sum($sumallp))?></div></td>
                    <td><div align="text"><?php echo number_format(array_sum($sumallw))?></div></td>
                    <td><div align="text"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


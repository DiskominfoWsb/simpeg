<script>
    $(document).ready(function(){
        $('#tb-statistik .link').click(function(){
            var index = $('#tb-statistik .link').index($(this));
            var par = $('#tb-statistik .link').eq(index).parent().parent();
            var vidwhere = $('#tb-statistik .link').eq(index).attr("data");
            var vidjenkel = $(par).find('.ed1').html();
            var visguru = $('#tb-statistik .link').eq(index).attr("isguru");
            var vidskpd = $('#tb-statistik .link').eq(index).attr("skpd");
            $('#form-print #idwhere').val(vidwhere);
            $('#form-print #isguru').val(visguru);
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

<form id="form-print" name="form-print" action="<?=base_url()?>diengplateu/page/statistik_statguru_print" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
    <input type="hidden" id="idwhere" name="idwhere" value="" />
    <input type="hidden" id="isguru" name="isguru" value="" />
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
                    <th><div align="center">Guru</div></th>
                    <th><div align="center">Non Guru</div></th>
                    <th><div align="center">Total</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $x = 0;
                $jmlall[$x]  = 0;
                $sumallp[$x] = 0;
                $sumallw[$x] = 0;

                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT IF(a.jenkel='L','Pria','Wanita') AS kategori, a.idjenkel, SUM(IF(MID(b.idjabfung, 5, 1)=4,1,0)) AS guru, SUM(IF(MID(b.idjabfung, 5, 1)!=4,1,0)) AS nonguru  FROM a_jenkel a
                                      LEFT JOIN tb_0723 b ON a.idjenkel = b.idjenkel WHERE b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idjenkel ORDER BY a.idjenkel");
                foreach ($rs->result() as $item) {
                    $sumguru[$x] = $item->guru;
                    $sumnonguru[$x] = $item->nonguru;
                    $jmlall[$x]  = $item->guru + $item->nonguru;
                    $x++;
                    ?>
                <tr>
                    <td>
                        <?php echo $x?>
                        <span class="ed1" style="display:none"><?=$item->idjenkel?></span>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" isguru="4" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->guru)?></div></td>
                    <td><div class="link" align="right" data="0" isguru="0" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->nonguru)?></div></td>
                    <td><div class="link" align="right" data="0" isguru="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->guru + $item->nonguru)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" isguru="4" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumguru))?></div></td>
                    <td><div class="link" align="right" data="1" isguru="0" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumnonguru))?></div></td>
                    <td><div class="link" align="right" data="1" isguru="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('#tb-statistik .link').click(function(){
            var index = $('#tb-statistik .link').index($(this));
            var par = $('#tb-statistik .link').eq(index).parent().parent();
            var vidwhere = $('#tb-statistik .link').eq(index).attr("data");
            var vidjenkel = $(par).find('.ed1').html();
            var viskartu = $('#tb-statistik .link').eq(index).attr("iskartu");
            var vidskpd = $('#tb-statistik .link').eq(index).attr("skpd");
            $('#form-print #idwhere').val(vidwhere);
            $('#form-print #iskartu').val(viskartu);
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

<form id="form-print" name="form-print" action="<?=base_url()?>diengplateu/page/statistik_statkartu_print" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
    <input type="hidden" id="idwhere" name="idwhere" value="" />
    <input type="hidden" id="iskartu" name="iskartu" value="" />
    <input type="hidden" id="idjenkel" name="idjenkel" value="" />
    <input type="hidden" id="idskpd" name="idskpd" value="" />
</form>

<div class="row">
    <div class="span5">
        <table class="table table-hover table-bordered" width="100%" id="tb-statistik">
            <thead>
            <tr>
                <th width="5%" rowspan="2"><div align="center">No. </div></th>
                <th rowspan="2"><div align="center">Jenis Kelamin</div></th>
                <th colspan="2"><div align="center">Karpeg</div></th>
                <th colspan="2"><div align="center">Karis / Karsu</div></th>
            </tr>
            <tr>
                <th><div align="center">Punya</div></th>
                <th><div align="center">Tidak</div></th>
                <th><div align="center">Punya</div></th>
                <th><div align="center">Tidak</div></th>
            </tr>
            </thead>
            <tbody>
                <?php
                $x = 0;
                $jmlall[$x]  = 0;
                $sumkarpeg[$x] = 0;
                $sumkarsu[$x] = 0;

                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
                $rs = $this->db->query("SELECT if(a.idjenkel=1,'Pria','Wanita') as kategori, a.idjenkel, SUM(IF(b.nokarpeg!='',1,0)) AS nokarpeg,SUM(IF(b.nokarpeg='',1,0)) AS nonnokarpeg,
                      SUM(IF(b.nokaris!='',1,0)) AS nokaris, SUM(IF(b.nokaris='',1,0)) AS nonnokaris FROM a_jenkel a LEFT JOIN tb_1223 b ON a.idjenkel = b.idjenkel
                      where b.idjenkedudupeg NOT IN (99,21) and b.idstspeg='3' $where GROUP BY a.idjenkel ORDER BY a.idjenkel");
                foreach ($rs->result() as $item) {
                    $sumkarpeg[$x] = $item->nokarpeg;
                    $sumnonkarpeg[$x] = $item->nonnokarpeg;
                    $sumkarsu[$x] = $item->nokaris;
                    $sumnonkarsu[$x] = $item->nonnokaris;
                    $jmlall[$x]  = $item->nokarpeg + $item->nokaris;
                    $x++;
                    ?>
                <tr>
                    <td>
                        <?php echo $x?>
                        <span class="ed1" style="display:none"><?=$item->idjenkel?></span>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="text" align="right" data="0" iskartu="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->nokarpeg)?></div></td>
                    <td><div class="text" align="right" data="0" iskartu="11" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->nonnokarpeg)?></div></td>
                    <td><div class="text" align="right" data="0" iskartu="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->nokaris)?></div></td>
                    <td><div class="text" align="right" data="0" iskartu="22" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->nonnokaris)?></div></td>
                </tr>
                    <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="text" align="right" data="1" iskartu="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumkarpeg))?></div></td>
                    <td><div class="text" align="right" data="1" iskartu="11" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumnonkarpeg))?></div></td>
                    <td><div class="text" align="right" data="1" iskartu="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumkarsu))?></div></td>
                    <td><div class="text" align="right" data="1" iskartu="22" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumnonkarsu))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


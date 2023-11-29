<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Statistik.xls");
?>


<div class="row">
    <div class="span5">
        <table border="1">
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
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT IF(idjenkel=1,'Pria',IF(idjenkel=2,'Wanita','-')) AS kategori, idjenkel, COUNT(*) AS pns FROM tb_01
                              WHERE idjenkedudupeg NOT IN (99,21) $where GROUP BY idjenkel");
                foreach ($rs->result() as $item) {
                    $jmlall[$x]  = $item->pns;
                    $x++;
                    ?>
                <tr>
                    <td>
                        <?php echo $x?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->pns)?></div></td>
                </tr>
            <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Status Pegawai</div></th>
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
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT a.stspeg as kategori, a.idstspeg, SUM(IF(b.idstspeg!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idstspeg!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_stspeg a
                      LEFT JOIN tb_01 b ON a.idstspeg = b.idstspeg AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idstspeg");
                foreach ($rs->result() as $item) {
                    $sumallp[$x] = $item->jmlpria;
                    $sumallw[$x] = $item->jmlwanita;
                    $jmlall[$x]  = $item->jmlpria + $item->jmlwanita;
                    $x++;
                ?>
                <tr>
                    <td>
                        <?php echo $x?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallp))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallw))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Agama</div></th>
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
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT a.idagama, b.idjenkel, a.agama as kategori, SUM(IF(b.idagama!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idagama!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_agama a
                          LEFT JOIN tb_01 b ON a.idagama = b.idagama AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idagama");
                foreach ($rs->result() as $item) {
                    $sumallp[$x] = $item->jmlpria;
                    $sumallw[$x] = $item->jmlwanita;
                    $jmlall[$x]  = $item->jmlpria + $item->jmlwanita;
                    $x++;
                ?>
                <tr>
                    <td>
                        <?php echo $x?>
                        
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallp))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallw))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Golongan</div></th>
                    <th><div align="center">Pria</div></th>
                    <th><div align="center">Wanita</div></th>
                    <th><div align="center">Total</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $xgol = 0;
                $xgol = 0;
                $jmlall[$xgol]  = 0;
                $sumallp[$xgol] = 0;
                $sumallw[$xgol] = 0;
                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT a.golru as kategori, a.idgolru, SUM(IF(b.idgolrupkt!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idgolrupkt!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_golruang a
                      LEFT JOIN tb_01 b ON a.idgolru = b.idgolrupkt AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idgolru");
                foreach ($rs->result() as $item) {
                    $sumallp[$xgol] = $item->jmlpria;
                    $sumallw[$xgol] = $item->jmlwanita;
                    $jmlall[$xgol]  = $item->jmlpria + $item->jmlwanita;
                    $xgol++;
                ?>
                <tr>
                    <td>
                        <?php echo $xgol?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallp))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallw))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Pendidikan</div></th>
                    <th><div align="center">Pria</div></th>
                    <th><div align="center">Wanita</div></th>
                    <th><div align="center">Total</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $xdik = 0;
                $xdik = 0;
                $jmlalldik[$xdik]  = 0;
                $sumallpdik[$xdik] = 0;
                $sumallwdik[$xdik] = 0;
                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rsdik = $this->db->query("SELECT a.tkpendid as kategori, a.idtkpendid, SUM(IF(b.idtkpendid!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idtkpendid!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_tkpendid a
                      LEFT JOIN tb_01 b ON a.idtkpendid = b.idtkpendid AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idtkpendid");
                foreach ($rsdik->result() as $item) {
                    $sumallpdik[$xdik] = $item->jmlpria;
                    $sumallwdik[$xdik] = $item->jmlwanita;
                    $jmlalldik[$xdik]  = $item->jmlpria + $item->jmlwanita;
                    $xdik++;
                ?>
                <tr>
                    <td>
                        <?php echo $xdik?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallp))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallw))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Jenis Jabatan</div></th>
                    <th><div align="center">Pria</div></th>
                    <th><div align="center">Wanita</div></th>
                    <th><div align="center">Total</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $xjenjab = 0;
                $xjenjab = 0;
                $jmlalljab[$xjenjab]  = 0;
                $sumallpjab[$xjenjab] = 0;
                $sumallwjab[$xjenjab] = 0;
                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT a.jenjab as kategori, a.idjenjab, SUM(IF(b.idjenjab!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idjenjab!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_jenjab a
                      LEFT JOIN tb_01 b ON a.idjenjab = b.idjenjab AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idjenjab");
                foreach ($rs->result() as $item) {
                    $sumallpjab[$xjenjab] = $item->jmlpria;
                    $sumallwjab[$xjenjab] = $item->jmlwanita;
                    $jmlalljab[$xjenjab]  = $item->jmlpria + $item->jmlwanita;
                    $xjenjab++;
                ?>
                <tr>
                    <td>
                        <?php echo $xjenjab?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallp))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallw))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Eselon</div></th>
                    <th><div align="center">Pria</div></th>
                    <th><div align="center">Wanita</div></th>
                    <th><div align="center">Total</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $x = 0;
                $x = 0;
                $jmlallstruk[$x]  = 0;
                $sumallo[$x] = 0;
                $sumallk[$x] = 0;
                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT a.esl as kategori, a.idesl, SUM(IF(b.idesljbt!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idesljbt!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_esl a
                      LEFT JOIN tb_01 b ON a.idesl = b.idesljbt AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idesl");
                foreach ($rs->result() as $item) {
                    $sumallo[$x] = $item->jmlpria;
                    $sumallk[$x] = $item->jmlwanita;
                    $jmlallstruk[$x]  = $item->jmlpria + $item->jmlwanita;
                    $x++;
                ?>
                <tr>
                    <td>
                        <?php echo $x?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallo))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallk))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlallstruk))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Diklat Struktural</div></th>
                    <th><div align="center">Pria</div></th>
                    <th><div align="center">Wanita</div></th>
                    <th><div align="center">Total</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $x = 0;
                $x = 0;
                $jmlallklat[$x]  = 0;
                $sumallo[$x] = 0;
                $sumallk[$x] = 0;
                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT a.dikstru as kategori, a.iddikstru, SUM(IF(b.iddikstru!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.iddikstru!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_dikstru a
                      inner JOIN tb_01 b ON a.iddikstru = b.iddikstru AND b.idjenjab IN(20,30,40)AND b.idjenkedudupeg NOT IN (99,21)  $where GROUP BY a.iddikstru order by a.iddikstru DESC");
                foreach ($rs->result() as $item) {
                    $sumallm[$x] = $item->jmlpria;
                    $sumallf[$x] = $item->jmlwanita;
                    $jmlallklat[$x]  = $item->jmlpria + $item->jmlwanita;
                    $x++;
                ?>
                <tr>
                    <td>
                        <?php echo $x?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallm))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallf))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlallklat))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Jabatan Fungsional</div></th>
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
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT a.jabfung as kategori, a.idjabfung, SUM(IF(b.idjabfung!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idjabfung!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_jabfung a
                      INNER JOIN tb_01 b ON a.idjabfung = b.idjabfung AND b.idjenkedudupeg NOT IN (99,21) and b.idjenjab = '2' $where GROUP BY a.jabfung ORDER BY a.jabfung");
                foreach ($rs->result() as $item) {
                    $sumallp[$x] = $item->jmlpria;
                    $sumallw[$x] = $item->jmlwanita;
                    $jmlall[$x]  = $item->jmlpria + $item->jmlwanita;
                    $x++;
                ?>
                <tr>
                    <td>
                        <?php echo $x?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallp))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallw))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Jabatan Fungsional Jenjang</div></th>
                    <th><div align="center">Pria</div></th>
                    <th><div align="center">Wanita</div></th>
                    <th><div align="center">Total</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $x = 0;
                $x = 0;
                $jmlallf[$x]  = 0;
                $sumallpf[$x] = 0;
                $sumallwf[$x] = 0;
                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT a.jenjang as kategori, a.tingkat, SUM(IF(b.idjabfung!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idjabfung!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_jabfung a
                      INNER JOIN tb_01 b ON a.idjabfung = b.idjabfung AND b.idjenkedudupeg NOT IN (99,21) and b.idjenjab = '2' $where GROUP BY a.jenjang ORDER BY a.jenjang DESC");
                foreach ($rs->result() as $item) {
                    $sumallpf[$x] = $item->jmlpria;
                    $sumallwf[$x] = $item->jmlwanita;
                    $jmlallf[$x]  = $item->jmlpria + $item->jmlwanita;
                    $x++;
                ?>
                <tr>
                    <td>
                        <?php echo $x?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallp))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallw))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="span5">
        <table border="1">
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
                $jmlalltot[$x]  = 0;
                $sumallp[$x] = 0;
                $sumallw[$x] = 0;

                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT IF(a.idjenkel='1','Pria','Wanita') AS kategori, a.idjenkel, SUM(IF(left(b.idjabfung, 3)=300,1,0)) AS guru, SUM(IF(left(b.idjabfung, 3)!=300,1,0)) AS nonguru  FROM a_jenkel a
                                      LEFT JOIN tb_01 b ON a.idjenkel = b.idjenkel WHERE b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idjenkel ORDER BY a.idjenkel");
                foreach ($rs->result() as $item) {
                    $sumguru[$x] = $item->guru;
                    $sumnonguru[$x] = $item->nonguru;
                    $jmlalltot[$x]  = $item->guru + $item->nonguru;
                    $x++;
                    ?>
                <tr>
                    <td>
                        <?php echo $x?>
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
                    <td><div class="link" align="right" data="1" isguru="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlalltot))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Jabatan Pelaksana</div></th>
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
                if($idskpd != "") $where = ($idskpd == "")?"":"AND b.idskpd LIKE '$idskpd%'";

                $rs = $this->db->query("SELECT a.jabfungum as kategori, a.idjabfungum, SUM(IF(b.idjabfungum!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idjabfungum!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_jabfungum a
                      INNER JOIN tb_01 b ON a.idjabfungum = b.idjabfungum AND b.idjenkedudupeg NOT IN (99,21) and b.idjenjab = '3' $where GROUP BY a.jabfungum ORDER BY a.jabfungum");
                foreach ($rs->result() as $item) {
                    $sumallp[$x] = $item->jmlpria;
                    $sumallw[$x] = $item->jmlwanita;
                    $jmlall[$x]  = $item->jmlpria + $item->jmlwanita;
                    $x++;
                ?>
                <tr>
                    <td>
                        <?php echo $x?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" jenkel="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallp))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="2" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($sumallw))?></div></td>
                    <td><div class="link" align="right" data="1" jenkel="grand" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlall))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">SKPD</div></th>
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

                $rs = $this->db->query("SELECT b.skpd as kategori, b.idskpd, SUM(IF(a.idskpd!='' AND a.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(a.idskpd!='' AND a.idjenkel = 2,1,0)) AS jmlwanita FROM tb_01 a
                      INNER JOIN skpd b ON LEFT(a.idskpd,2) = b.idskpd WHERE a.idjenkedudupeg NOT IN (99,21) $where GROUP BY LEFT(a.idskpd,2)");
                foreach ($rs->result() as $item) {
                    $sumallpopd[$x] = $item->jmlpria;
                    $sumallwopd[$x] = $item->jmlwanita;
                    $jmlallopd[$x]  = $item->jmlpria + $item->jmlwanita;
                    $x++;
                ?>
                <tr>
                    <td>
                        <?php echo $x?>
                    </td>
                    <td><?php echo $item->kategori?></td>
                    <td><div class="link" align="right" data="0" jenkel="1" title="Lihat Detail"><?php echo number_format($item->jmlpria)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="2" title="Lihat Detail"><?php echo number_format($item->jmlwanita)?></div></td>
                    <td><div class="link" align="right" data="0" jenkel="sum" title="Lihat Detail"><?php echo number_format($item->jmlpria + $item->jmlwanita)?></div></td>
                </tr>
                <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right"><?php echo number_format(array_sum($sumallpopd))?></div></td>
                    <td><div class="link" align="right"><?php echo number_format(array_sum($sumallwopd))?></div></td>
                    <td><div class="link" align="right"><?php echo number_format(array_sum($jmlallopd))?></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!--
<div class="row">
    <div class="span5">
        <table border="1">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Sekretaris Desa</div></th>
                    <th><div align="center">Jumlah</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $xsek = 0;
                $jmlallsek[$xsek]  = 0;
                $idskpd = $this->input->post('idskpd');
                if($idskpd != "") $where = ($idskpd == "")?"":"AND a.idskpd LIKE '$idskpd%'";

                $rssek = $this->db->query("SELECT IF(a.idjenkel=1,'Pria',IF(a.idjenkel=2,'Wanita','-')) AS kategori, idjenkel, COUNT(*) AS pns FROM tb_01 a
                        LEFT JOIN a_jabfungum b ON a.idjabfungum = b.idjabfungum
                        WHERE a.idjenkedudupeg NOT IN (99,21)  AND (a.niplama LIKE '%sekdes%' OR b.jabfungum = 'sekdes') $where GROUP BY a.idjenkel;");
                foreach ($rssek->result() as $items) {
                    $jmlallsek[$xsek]  = $items->pns;
                    $xsek++;
                    ?>
                <tr>
                    <td>
                        <?php echo $xsek?>
                    </td>
                    <td><?php echo $items->kategori?></td>
                    <td><div class="link" align="right" data="0" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format($items->pns)?></div></td>
                </tr>
            <?php } ?>
                <tr class="breadcrumb">
                    <td colspan="2">Grand Total</td>
                    <td><div class="link" align="right" data="1" skpd="<?=$this->input->post('idskpd')?>" title="Lihat Detail"><?php echo number_format(array_sum($jmlallsek))?></div></td>
                </tr> -->
            </tbody>
        </table>
    </div>
</div>
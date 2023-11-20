<div class="row">
    <div class="span5">
        <table class="table table-hover table-bordered" width="100%" id="tb-statistik">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Perangkat Daerah</div></th>
                    <th><div align="center">Nama Pejabat</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $x = 0;

                $rs = $this->db->query("SELECT a.skpd,b.nama from a_skpd a
                left join tb_01 b on a.idskpd=b.idskpd
                WHERE  length(a.idskpd)='2' and a.flag='1' and b.idjenkedudupeg not in('21','99') and b.idesljbt in('21','22','31') or (a.idskpd like'01.%' and b.idjenkedudupeg not in('21','99'))
                or (a.idskpd like'02.%' and b.idjenkedudupeg not in('21','99') and b.idesljbt='31')");
                foreach ($rs->result() as $item) {
                    $x++;
                    ?>
                <tr>
                    <td><?php $x?></td>
                    <td><?php echo $item->skpd?></td>
                    <td><?php echo $item->nama?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

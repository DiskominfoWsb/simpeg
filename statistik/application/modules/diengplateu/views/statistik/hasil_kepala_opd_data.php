<div class="row">
    <div class="span5">
        <?php
            $id_tahun = $this->input->post('id_tahun');
            $id_bulan = $this->input->post('id_bulan');

            if($id_tahun < date('Y')){			
                $db = DB_STATISTIK;
                $table = "tb_01_".$id_bulan."".$id_tahun;
            }else{
                if($id_bulan != date('m')){
                    $db = DB_STATISTIK;
                    $table = "tb_01_".$id_bulan."".$id_tahun;
                }else{
                    $db = $this->db->database;
                    $table = "tb_01";
                }
            }

            //cek tabel ada atau tidak
            $count_table = $this->db->query("SELECT COUNT(*) AS jml FROM information_schema.tables WHERE table_schema = '".$db."' AND table_name = '".$table."' LIMIT 1")->row();
            
            if($count_table->jml>0){ 
                $dbtable = $db.(($db!='')?".":"").$table; ?>
                <table class="table table-hover table-bordered" width="100%" id="tb-statistik">
                    <thead>
                        <tr>
                            <th width="5%"><div align="center">No. </div></th>
                            <th><div align="center">Perangkat Daerah</div></th>
                            <th><div align="center">Nama Pejabat</div></th>
                            <th><div align="center">Pangkat/Gol. Ruang</div></th>
                            <th><div align="center">Eselon / TMT Jabatan</div></th>
                            <th><div align="center">Pendidikan</div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $x = 0;

                        $rs = $this->db->query("SELECT a.jab,concat(if(b.gdp='','',concat(b.gdp,' ')),b.nama,if(b.gdb='','',concat(', ',b.gdb)))as nama, c.pangkat, c.golru, d.esl as eselon, DATE_FORMAT(b.tmtjbt,'%d-%m-%Y') as tmt_jab,e.jenjurusan from a_skpd a
                        left join ".$dbtable." b on a.idskpd=b.idskpd
                        left join a_golruang c on b.idgolrupkt=c.idgolru
                        left join a_esl d on b.idesljbt=d.idesl
                        left join a_jenjurusan e on b.idjenjurusan=e.idjenjurusan
                        WHERE  length(a.idskpd)='2' and a.flag='1' and b.idjenkedudupeg not in('21','99') and b.idesljbt in('21','22','31') or (a.idskpd like'01.%' and b.idjenkedudupeg not in('21','99'))
                        or (a.idskpd like'02.%' and b.idjenkedudupeg not in('21','99') and b.idesljbt='31')");
                        foreach ($rs->result() as $item) {
                            $x++;
                            ?>
                        <tr>
                            <td align="center"><?php echo $x?></td>
                            <td><?php echo $item->jab?></td>
                            <td><?php echo $item->nama?></td>
                            <td align="center"><?php echo $item->pangkat."<br>".$item->golru?></td>
                            <td align="center"><?php echo $item->eselon."<br>".$item->tmt_jab?></td>
                            <td align="center"><?php echo $item->jenjurusan?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php 
            }else{ ?>
                <p style="background-color: white; padding: 20px;">Data tidak ditemukan</p>
            <?php } ?>
    </div>
</div>

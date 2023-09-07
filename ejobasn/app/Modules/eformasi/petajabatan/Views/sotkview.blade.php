
<html>
<head>
    <title>Struktur Peta Jabatan</title>
    <style type="text/css" media="all">
            /*Now the CSS*/
        * {margin: 0; padding: 0;background-color:#fff}
        .treeDiv
        {
            margin:0 auto;
            text-align:center;
            width:10500px;
        }
        .tree ul {
            padding-top: 20px; position: relative;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li {
            float: left; text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

            /*We will use ::before and ::after to draw the connectors*/

        .tree li::before, .tree li::after{
            content: '';
            position: absolute; top: 0; right: 50%;
            border-top: 1px solid #ccc;
            width: 50%; height: 35px;
        }
        .tree li::after{
            right: auto; left: 50%;
            border-left: 1px solid #ccc;
        }

            /*We need to remove left-right connectors from elements without
           any siblings*/
        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }

            /*Remove space from the top of single children*/
        .tree li:only-child{ padding-top: 0;}

            /*Remove left connector from first child and
        right connector from last child*/
        .tree li:first-child::before, .tree li:last-child::after{
            border: 0 none;
        }
            /*Adding back the vertical connector to the last nodes*/
        .tree li:last-child::before{
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }
        .tree li:first-child::after{
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

            /*Time to add downward connectors from parents*/
        .tree ul ul::before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 1px solid #ccc;
            width: 0; height: 20px;
        }

        a span.sotk-title{
            display:block;
            /*background-color:#F4F4F4;*/
            /*padding: 10px;*/
            /*min-height:50px;*/
            /*max-height:55px;*/
            overflow:hidden;
        }

        .tree li a,.tree a.top-tree{
            /*border: 1px solid #ccc;
            padding: 5px 10px;*/
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 11px;
            display:inline-block;
            width: 250px; /*80px*/
            height:auto; /*200px*/
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li a.vert-line{
            border:none;
            position:relative;
            height:450px;
        }

        .tree li a.vert-line:before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 1px solid #ccc;
            width: 0; height: 460px;
        }

        .sotk-nama{
            display:block;
            background-color:#F4f4f4;
            font-size:9px;
            overflow:hidden;
        }

        .sotk-nip{
            margin-top:20px;
            display:block;
            background-color:#F4f4f4;
            text-decoration:underline;
            font-size:9px;
            overflow:hidden;
        }

        table {
          border-collapse: separate;
          border-spacing: 0;
        }

        table tr th,
        table tr td {
          border-right: 1px solid #000;
          border-bottom: 1px solid #000;
          padding: 5px;
        }

        table tr th:first-child,
        table tr td:first-child {
          border-left: 1px solid #000;
        }
        table tr th {
          border-top: 1px solid #000;
        }

        /* top-left border-radius */
        table tr:first-child th:first-child {
          border-top-left-radius: 6px;
        }

        /* top-right border-radius */
        table tr:first-child th:last-child {
          border-top-right-radius: 6px;
        }

        /* bottom-left border-radius */
        table tr:last-child td:first-child {
          border-bottom-left-radius: 6px;
        }

        /* bottom-right border-radius */
        table tr:last-child td:last-child {
          border-bottom-right-radius: 6px;
        }

        .red{ background-color: #FF3333; }
        .blue{ background-color: #0080FF; }
        .green{ background-color: #00FF80; }
        .yellow{ background-color: #FFFF66; }
        .gray{ background-color: #ECECEC; }
    </style>

    <script type="text/javascript" src="{!!asset('packages/tugumuda/plugins/jQuery/jquery-1.11.0.min.js')!!}"></script>
    <script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>
    <script>
        $(document).ready(function(){
            $('ul li a').find('.sotk-nip').each(function(index,item){
                if($(item).html()=='') $(item).parent().css('background-color','orange');
            });

            $('#download-excel').on('click', function(e){
                e.preventDefault();
                cetak_excel('result');
            })

            $('#export-btn').on('click', function(e){
                e.preventDefault();
                ResultsToTable();
            });

            function ResultsToTable(){
                $("#resultsTable").table2excel({
                    exclude: ".noExl",
                    name: "Results"
                });
            }
        });

        function cetak_word(elemen){
            uriContent = "data:application/msword," + encodeURIComponent( format_html($('#' + elemen + '').html()) );
            window.open(uriContent, 'myDocument');
        }

        function cetak_excel(elemen){
            uriContent = "data:application/vnd.ms-excel," + encodeURIComponent( format_html($('#' + elemen + '').html()) );
            window.open(uriContent, 'myDocument');
        }



        
    </script>
</head>
<body>

<!--<button id="download-excel" class="btn btn-success" type="button">Excel</button>-->
<div align="center" id="result">
    <div class="treeDiv">
        <div class="tree">
            <?php
                if (Input::get('idskpd') != ''){
                $rs = \DB::table('tr_petajab as a')
                        ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as c'), 'a.idskpd', '=', 'c.idskpd')
                        ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as d'), 'a.idjabfung', '=', 'd.idjabfung')
                        ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as f'), 'a.idjabfungum', '=', 'f.idjabfungum')
                        ->select('a.id', 'a.idjenjab', 'a.periode_tahun','a.periode_bulan','a.namajabatan','c.idesl','a.idskpd','c.skpd','c.jab','c.path','b.nip','b.niplama','b.photo','b.nama',
                            \DB::raw("concat(if(length(b.gdp)>0,concat(b.gdp,' '),''),b.nama,if(length(b.gdb)>0,concat(',',b.gdb),'')) as namalengkap"),
                            \DB::raw('IF(a.idjenjab>4,c.kelas_jabatan,IF(a.idjenjab=2,d.kelas_jabatan,IF(a.idjenjab=3,f.kelas_jabatan,"-"))) as kelasjab')
                        )
                        ->leftjoin(\DB::Raw(config('global.kepegawaian').'.tb_01 as b'), function($join){
                            $join->on('a.idskpd','=','b.idjabjbt')
                                ->where('b.idjenkedudupeg','!=',99)
                                ->where('b.idjenkedudupeg','!=',21);
                        })
                        ->where('a.idskpd', Input::get('idskpd'))
                        ->where('a.periode_tahun','=',Input::get('periode_tahun'))
                        ->where('a.periode_bulan','=',Input::get('periode_bulan'));

                $item = $rs->first();
            ?>
            <!-- {{-- jika item tidak ditemukan --}} -->
            <?php if(!empty($item)){
                    if($item->idjenjab== 0){
                        //kepala sekolah
                        $tmp_pemangku = \App\Models\Petajab::getPemangkuByIdPeta($item->id)->first();
                        $pemangku_jabatan = '- '.$tmp_pemangku->gdp.' '.$tmp_pemangku->nama.', '.$tmp_pemangku->gdb;
                    }else{
                        $pemangku_jabatan = "";
                    }
                ?>
            <ul>
                <li>
                    <a>
                        <span class="sotk-title">&nbsp;</span>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <th align="center" class="{!!\PetajabatanModel::warnajabatanesl($item->idesl)!!}" colspan="5">{!! @$item->namajabatan!!}</th>
                            </tr>
                            <tr>
                                <td align="center" class="{!!\PetajabatanModel::warnajabatanesl($item->idesl)!!}" colspan="5">(Kelas {!! @$item->kelasjab!!})</td>
                            </tr>
                            <tr><td colspan='5' style='font-size:8pt'>{!! @$pemangku_jabatan !!}{!! @$item->namalengkap==""?"":"- ".@$item->namalengkap !!}</td></tr>

                            <?php
                            // $fungsional = \DB::table('tr_petajab')
                            //     ->select(\DB::raw('
                            //         tr_petajab.*,
                            //         a_matkulpel.matkulpel,
                            //         a_tugasdokter.tugasdokter
                            //     '),
                            //     \DB::raw('
                            //         SUM(
                            //             IF(tr_petajab.idjabjbt = tb_01.idjabjbt AND tb_01.idjabjbt != "" AND tb_01.idjenjab > 4,1,
                            //                 IF(tr_petajab.idjabfung = tb_01.idjabfung AND tb_01.idjabfung != "" AND tb_01.idjenjab = 2 AND tr_petajab.idskpd = tb_01.idskpd,1,
                            //                     IF(tr_petajab.idjabfungum = tb_01.idjabfungum AND tb_01.idjabfungum != "" AND tb_01.idjenjab = 3 AND tr_petajab.idskpd = tb_01.idskpd,1,0)
                            //                 )
                            //            )
                            //         ) AS banyakorang'
                            //     ),
                            //     \DB::raw('
                            //         group_concat(
                            //             IF(tr_petajab.idjabjbt = tb_01.idjabjbt AND tb_01.idjabjbt != "" AND tb_01.idjenjab > 4,tb_01.nama,
                            //                 IF(tr_petajab.idjabfung = tb_01.idjabfung AND tb_01.idjabfung != "" AND tb_01.idjenjab = 2 AND tr_petajab.idskpd = tb_01.idskpd,tb_01.nama,
                            //                     IF(tr_petajab.idjabfungum = tb_01.idjabfungum AND tb_01.idjabfungum != "" AND tb_01.idjenjab = 3 AND tr_petajab.idskpd = tb_01.idskpd,tb_01.nama,NULL)
                            //                 )
                            //             )
                            //         ) AS orangnya'
                            //     ),
                            //     \DB::raw('IF(tr_petajab.idjenjab>4,skpd.kelas_jabatan,IF(tr_petajab.idjenjab=2,a_jabfung.kelas_jabatan,IF(tr_petajab.idjenjab=3,a_jabfungum.kelas_jabatan,"-"))) as kelasjab'),
                            //     \DB::raw('IF(tr_petajab.idjenjab>4,a_jabasn.jabasn,IF(tr_petajab.idjenjab=2,a_jenjab.jenjab,IF(tr_petajab.idjenjab=3,a_jenjab.jenjab,"-"))) as jenjabatan'))
                            //     ->leftjoin(\DB::Raw(config('global.kepegawaian').'.tb_01'), 'tr_petajab.idskpd', '=', 'tb_01.idskpd')
                            //     ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'), 'tr_petajab.idskpd', '=', 'skpd.idskpd')
                            //     ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
                            //     ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                            //     ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jenjab as a_jenjab'), 'tr_petajab.idjenjab','=','a_jenjab.idjenjab')
                            //     ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabasn as a_jabasn'), 'tr_petajab.idjenjab','=','a_jabasn.idjabasn')
                            //     ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_matkulpel as a_matkulpel'), 'tr_petajab.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
                            //     ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tugasdokter as a_tugasdokter'), 'tr_petajab.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                            //     ->whereNotIn('tb_01.idjenkedudupeg', ['99','21'])
                            //     ->where('tb_01.iskepsek','!=',1)
                            //     ->where('tr_petajab.periode_tahun','=',$item->periode_tahun)
                            //     ->where('tr_petajab.periode_bulan','=',$item->periode_bulan)
                            //     ->where('tr_petajab.idskpd','=',$item->idskpd)
                            //     ->where('tr_petajab.idjabjbt','=','')
                            //     ->orderBy('tr_petajab.idskpd','asc')
                            //     ->orderBy('tr_petajab.idjabjbt','desc')
                            //     ->orderBy('a_tugasdokter.tugasdokter','desc')
                            //     ->orderBy('a_matkulpel.matkulpel','desc')
                            //     ->orderBy('a_jabfung.kelas_jabatan','desc')
                            //     ->orderBy('a_jabfungum.kelas_jabatan','desc')
                            //     ->orderBy('kelasjab','desc')
                            //     ->groupBy('tr_petajab.id')
                            //     ->get();

                                $fungsional = \App\Models\Petajab::jabatanSkpdNonStruktur($item->idskpd,$item->periode_bulan,$item->periode_tahun);
                            ?>

                            @if(count($fungsional)>0)
                                <tr>
                                    <td align="center" width="50%">Jabatan</td>
                                    <td align="center" width="12.5%">Kls</td>
                                    <td align="center" width="12.5%">B</td>
                                    <td align="center" width="12.5%">K</td>
                                    <td align="center" width="12.5%">-/+</td>
                                </tr>
                            @endif
                            <span style="text-align: left; font-size:8pt">
                                </span>
                            @foreach ($fungsional as $f)
                                <?php 
                                    $orangnya = $f->pegawaiPemangku();
                                    $banyak_orang = count($orangnya);
                                    $sts_style = ($banyak_orang>$f->abk)?'red':($banyak_orang<$f->abk)?'yellow':''; 
                                    // -- start if guru or dokter
                                        if(substr($f->idjabfung,0,3) == '300'){
                                            $guru_or_dokter= " - ".@CFirst($f->matkulpel);
                                        }else if(substr($f->idjabfung,0,3) == '220'){
                                            $guru_or_dokter= " - ".@CFirst($f->tugasdokter);
                                        }else{
                                            $guru_or_dokter= "";
                                        }
                                    // -- end if guru or dokter
                                ?>
                                <tr>
                                    <td class="{!! $sts_style !!}">{!!$f->namajabatan.$guru_or_dokter!!}</td>
                                    <td align="center" class="{!! $sts_style !!}">{!!$f->kelasjab!!}</td>
                                    <td align="center" class="{!! $sts_style !!}">{!!$banyak_orang!!}</td>
                                    <td align="center" class="{!! $sts_style !!}">{!!$f->abk!!}</td>
                                    <td align="center" class="{!! $sts_style !!}">{!!($banyak_orang - $f->abk)!!}</td>
                                </tr>
                                @if($banyak_orang > 0)
                                    <tr><td colspan='5' style='font-size:8pt'>
                                        @foreach($orangnya as $orang)
                                            {!! "- ".$orang->nama !!}
                                            @if($orang != end($orangnya))
                                                {!! "<br/>" !!}
                                            @endif
                                        @endforeach
                                    </td></tr>; 
                                @endif
                            @endforeach
                            <!-- Menampilkan Pegawai yang menduduki jabatan -->
                            <?php    
                            // echo "<tr><td colspan='5' style='font-size:8pt'>- ";
                            // $x=1;
                            // foreach ($fungsional as $f) {
                            //         if(!empty($f->orangnya)){
                            //             if($x!=1){
                            //                 echo '<br>- ';
                            //             }
                            //             echo $f->orangnya;
                            //             $x++;
                            //         }
                            // }
                            // echo "</td></tr>";  
                             ?>
                        </table>
                    </a>
                    <ul>
                        {!! familytree(Input::get('idskpd'),Input::get('periode_tahun'),Input::get('periode_bulan')) !!}
                    </ul>
                </li>
            </ul>
            <?php }else{
                $urlphoto = url("packages/upload/photo/pegawai/default.jpg");
            ?>
            <ul>
                <li>
                    <div><i>mohon maaf anda belum memilih SKPD</i></div>
                </li>
            </ul>
            <?php } ?>


            {{-- END jika item tidak ditemukan --}}
            <?php }else{ ?>
                <ul>
                <li>
                    <div><i>mohon maaf SKPD tidak ditemukan</i></div>
                </li>
            </ul>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>

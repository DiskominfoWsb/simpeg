<?php
    $idskpd = ((Input::get('idskpd') != '')?Input::get('idskpd'):'25');
    $proyeksi5tahuns = \DB::table('tr_petajab as a')
        ->select(\DB::raw("
                        a.idskpd, a.namajabatan, b.skpd, a.idjenjab, a.idjabjbt, a.idjabfung, a.idjabfungum,
                        IF(a.idjenjab>4, b.kelas_jabatan, IF(a.idjenjab=2, f.kelas_jabatan, IF(a.idjenjab=3, g.kelas_jabatan, '-'))) AS kelas_jabatan,
                        IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-'))) AS idjabatan,
                        SUM(IF(a.idjenjab > 4 AND a.idjabjbt = c.idjabatan,1,0)) AS struktural,
                        SUM(IF(a.idjenjab = 2 AND a.idjabfung = c.idjabatan AND a.idskpd = c.idskpd,1,0)) AS fungsional,
                        SUM(IF(a.idjenjab = 3 AND a.idjabfungum = c.idjabatan AND a.idskpd = c.idskpd ,1,0)) AS pelaksana,
                        (SUM(IF(a.idjenjab > 4 AND a.idjabjbt = c.idjabatan,1,0)) + SUM(IF(a.idjenjab = 2 AND a.idjabfung = c.idjabatan AND a.idskpd = c.idskpd,1,0)) + SUM(IF(a.idjenjab = 3 AND a.idjabfungum = c.idjabatan AND a.idskpd = c.idskpd ,1,0))) AS jumlahreal,
                        IF(a.idjenjab > 4 AND a.idjabjbt = b.idskpd,a.abk,0) AS akstruktural,
                        IF(a.idjenjab = 2 AND a.idjabfung = f.idjabfung AND a.idskpd = b.idskpd,a.abk,0) AS akfungsional,
                        IF(a.idjenjab = 3 AND a.idjabfungum = g.idjabfungum AND a.idskpd = b.idskpd,a.abk,0) AS akpelaksana,
                        (IF(a.idjenjab > 4 AND a.idjabjbt = b.idskpd,a.abk,0) + IF(a.idjenjab = 2 AND a.idjabfung = f.idjabfung AND a.idskpd = b.idskpd,a.abk,0) + IF(a.idjenjab = 3 AND a.idjabfungum = g.idjabfungum AND a.idskpd = b.idskpd,a.abk,0)) AS jumlahak,
                        SUM(IF((IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-')))) = c.idjabatan AND a.idskpd = c.idskpd AND YEAR(c.pensiunnext)=YEAR(NOW()),1,0)) AS pensiun1,
                        SUM(IF((IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-')))) = c.idjabatan AND a.idskpd = c.idskpd AND YEAR(c.pensiunnext)=YEAR(NOW())+1,1,0)) AS pensiun2,
                        SUM(IF((IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-')))) = c.idjabatan AND a.idskpd = c.idskpd AND YEAR(c.pensiunnext)=YEAR(NOW())+2,1,0)) AS pensiun3,
                        SUM(IF((IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-')))) = c.idjabatan AND a.idskpd = c.idskpd AND YEAR(c.pensiunnext)=YEAR(NOW())+3,1,0)) AS pensiun4,
                        SUM(IF((IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-')))) = c.idjabatan AND a.idskpd = c.idskpd AND YEAR(c.pensiunnext)=YEAR(NOW())+4,1,0)) AS pensiun5
                    "))
        ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'), 'a.idskpd', '=', 'b.idskpd')
        ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as f'), 'a.idjabfung', '=', 'f.idjabfung')
        ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as g'), 'a.idjabfungum', '=', 'g.idjabfungum')
        ->leftjoin(\DB::Raw(config('global.kepegawaian').'.v_pegawai c'), function($join)use($idskpd){
        //$join->on('idjabatan', '=', 'c.idjabatan')
        //->where('a.idskpd', '=', 'c.idskpd');
        $join->on(\DB::raw('(IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, "-"))))'), '=', 'c.idjabatan')
            //->where(\DB::raw('left(c.idskpd,2)'), '=', '25');
                ->where('c.idskpd', 'like', ''.$idskpd.'%');
        })
        ->whereRaw("a.idskpd LIKE \"".$idskpd."%\"")
        //->orderBy('a.idskpd')->orderBy('a.idjabfung')->orderBy('a.idjabfungum')
        ->orderBy('a.idskpd','asc')
        ->orderBy('a.idjabjbt','desc')
        ->orderBy('f.kelas_jabatan','desc')
        ->orderBy('g.kelas_jabatan','desc')
        ->groupBy('a.idskpd')->groupBy('a.idjabfung')->groupBy('a.idjabfungum')
        ->get();

$w="<?xml version=\"1.0\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>User</Author>
  <LastAuthor>Rendy Amdani</LastAuthor>
  <Created>2021-03-08T03:08:11Z</Created>
  <LastSaved>2021-03-31T12:42:55Z</LastSaved>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>9525</WindowHeight>
  <WindowWidth>24000</WindowWidth>
  <WindowTopX>32767</WindowTopX>
  <WindowTopY>32767</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID=\"Default\" ss:Name=\"Normal\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Calibri\" x:CharSet=\"1\" x:Family=\"Swiss\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s62\" ss:Name=\"Normal 2\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m316503416\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316503436\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316500712\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Double\" ss:Weight=\"3\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Color=\"#000000\"
    ss:Bold=\"1\" ss:Italic=\"1\"/>
   <Interior ss:Color=\"#BFBFBF\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"m316500732\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Double\" ss:Weight=\"3\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Double\" ss:Weight=\"3\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"
    ss:Color=\"#000000\" ss:Bold=\"1\" ss:Italic=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316500752\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Double\" ss:Weight=\"3\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316500772\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316500792\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316500812\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316505120\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316505140\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316505160\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316505180\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316505200\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316505220\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"m316505240\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s64\" ss:Parent=\"s62\">
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s65\" ss:Parent=\"s62\">
   <Alignment ss:Vertical=\"Center\"/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\" ss:Bold=\"1\" ss:StrikeThrough=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s66\" ss:Parent=\"s62\">
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s67\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"
    ss:Color=\"#000000\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s68\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Right\" ss:Vertical=\"Bottom\"/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s69\" ss:Parent=\"s62\">
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"
    ss:Color=\"#000000\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s70\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s72\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s74\" ss:Parent=\"s62\">
   <Alignment ss:Vertical=\"Center\"/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"
    ss:Color=\"#000000\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s75\" ss:Parent=\"s62\">
   <Alignment ss:Vertical=\"Center\"/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s76\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders/>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"
    ss:Color=\"#000000\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s102\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s112\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Color=\"#000000\"
    ss:Bold=\"1\" ss:Italic=\"1\"/>
   <Interior ss:Color=\"#BFBFBF\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"s120\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Color=\"#000000\"
    ss:Bold=\"1\" ss:Italic=\"1\"/>
   <Interior ss:Color=\"#BFBFBF\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"s121\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Color=\"#000000\"
    ss:Bold=\"1\" ss:Italic=\"1\"/>
   <Interior ss:Color=\"#BFBFBF\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"s122\" ss:Parent=\"s62\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Double\" ss:Weight=\"3\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Double\" ss:Weight=\"3\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s130\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Double\" ss:Weight=\"3\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Double\" ss:Weight=\"3\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s131\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Double\" ss:Weight=\"3\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s142\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\" ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s143\" ss:Parent=\"s62\">
   <Alignment ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s148\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"10.5\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s149\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"10.5\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s150\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"10.5\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s151\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s152\" ss:Parent=\"s62\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s157\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s158\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"10.5\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s159\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"10.5\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s160\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Center\"
    ss:ReadingOrder=\"LeftToRight\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"10.5\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s164\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s165\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Justify\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s166\" ss:Parent=\"s62\">
   <Alignment ss:Horizontal=\"Justify\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s167\" ss:Parent=\"s62\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s168\" ss:Parent=\"s62\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"2\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Times New Roman\" x:Family=\"Roman\" ss:Size=\"12\"/>
   <Interior/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"PROYEKSI KEBUTUHAN 5\">
  <Table ss:ExpandedColumnCount=\"20000000\" ss:ExpandedRowCount=\"18000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:StyleID=\"s64\" ss:DefaultRowHeight=\"15.75\">
   <Column ss:StyleID=\"s64\" ss:AutoFitWidth=\"0\" ss:Width=\"31.5\"/>
   <Column ss:StyleID=\"s64\" ss:AutoFitWidth=\"0\" ss:Width=\"19.5\" ss:Span=\"5\"/>
   <Column ss:Index=\"8\" ss:StyleID=\"s64\" ss:AutoFitWidth=\"0\" ss:Width=\"273\"/>
   <Column ss:StyleID=\"s64\" ss:AutoFitWidth=\"0\" ss:Width=\"71.25\" ss:Span=\"1\"/>
   <Column ss:Index=\"11\" ss:StyleID=\"s64\" ss:AutoFitWidth=\"0\" ss:Width=\"30.75\"
    ss:Span=\"9\"/>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:StyleID=\"s65\"><ss:Data ss:Type=\"String\"
      xmlns=\"http://www.w3.org/TR/REC-html40\"><B><S><Font html:Color=\"#000000\">KABUPATEN</Font></S><Font
        html:Color=\"#000000\">/KOTA *)</Font></B></ss:Data></Cell>
    <Cell ss:StyleID=\"s65\"/>
    <Cell ss:StyleID=\"s65\"/>
    <Cell ss:StyleID=\"s65\"/>
    <Cell ss:StyleID=\"s65\"/>
    <Cell ss:StyleID=\"s65\"/>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">: KABUPATEN KENDAL</Data></Cell>
    <Cell ss:Index=\"10\" ss:StyleID=\"s67\"/>
    <Cell ss:StyleID=\"s68\"/>
    <Cell ss:StyleID=\"s69\"/>
    <Cell ss:StyleID=\"s70\"/>
    <Cell ss:StyleID=\"s70\"/>
    <Cell ss:StyleID=\"s70\"/>
    <Cell ss:StyleID=\"s70\"/>
    <Cell ss:Index=\"18\" ss:MergeAcross=\"2\" ss:StyleID=\"s72\"/>
   </Row>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
   </Row>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
    <Cell ss:StyleID=\"s75\"/>
   </Row>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:MergeAcross=\"19\" ss:StyleID=\"s76\"><Data ss:Type=\"String\">PROYEKSI KEBUTUHAN PEGAWAI 5 (LIMA) TAHUN KE DEPAN</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"16.5\">
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
    <Cell ss:StyleID=\"s76\"/>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"19.5\">
    <Cell ss:MergeDown=\"2\" ss:StyleID=\"m316505120\"><Data ss:Type=\"String\">No</Data></Cell>
    <Cell ss:MergeAcross=\"6\" ss:MergeDown=\"2\" ss:StyleID=\"m316505140\"><Data
      ss:Type=\"String\">Nama Unit Organisasi dan Nama Jabatan </Data></Cell>
    <Cell ss:MergeDown=\"2\" ss:StyleID=\"m316505160\"><Data ss:Type=\"String\">Bezetting Pegawai Saat Ini</Data></Cell>
    <Cell ss:MergeDown=\"2\" ss:StyleID=\"m316505180\"><Data ss:Type=\"String\">Kebutuhan Pegawai Berdasarkan ABK</Data></Cell>
    <Cell ss:MergeAcross=\"9\" ss:StyleID=\"m316505200\"><Data ss:Type=\"String\">Proyeksi </Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"24\">
    <Cell ss:Index=\"11\" ss:MergeAcross=\"4\" ss:StyleID=\"m316505220\"><Data
      ss:Type=\"String\">Jumlah yang akan Pensiun</Data></Cell>
    <Cell ss:MergeAcross=\"4\" ss:StyleID=\"m316505240\"><Data ss:Type=\"String\">Pegawai yang Dibutuhkan</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"28.5\">
    <Cell ss:Index=\"11\" ss:StyleID=\"s102\"><Data ss:Type=\"Number\">".date('Y')."</Data></Cell>
    <Cell ss:StyleID=\"s102\"><Data ss:Type=\"Number\">".(date('Y') + 1)."</Data></Cell>
    <Cell ss:StyleID=\"s102\"><Data ss:Type=\"Number\">".(date('Y') + 2)."</Data></Cell>
    <Cell ss:StyleID=\"s102\"><Data ss:Type=\"Number\">".(date('Y') + 4)."</Data></Cell>
    <Cell ss:StyleID=\"s102\"><Data ss:Type=\"Number\">".(date('Y') + 5)."</Data></Cell>
    <Cell ss:StyleID=\"s102\"><Data ss:Type=\"Number\">".(date('Y'))."</Data></Cell>
    <Cell ss:StyleID=\"s102\"><Data ss:Type=\"Number\">".(date('Y') + 1)."</Data></Cell>
    <Cell ss:StyleID=\"s102\"><Data ss:Type=\"Number\">".(date('Y') + 2)."</Data></Cell>
    <Cell ss:StyleID=\"s102\"><Data ss:Type=\"Number\">".(date('Y') + 4)."</Data></Cell>
    <Cell ss:StyleID=\"s102\"><Data ss:Type=\"Number\">".(date('Y') + 5)."</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"12.75\">
    <Cell ss:StyleID=\"s112\"><Data ss:Type=\"Number\">1</Data></Cell>
    <Cell ss:MergeAcross=\"6\" ss:StyleID=\"m316500712\"><Data ss:Type=\"Number\">2</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">3</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">4</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">5</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">6</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">7</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">8</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">9</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">10</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">11</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">12</Data></Cell>
    <Cell ss:StyleID=\"s120\"><Data ss:Type=\"Number\">13</Data></Cell>
    <Cell ss:StyleID=\"s121\"><Data ss:Type=\"Number\">14</Data></Cell>
   </Row>";

    $x = 0;
    foreach ($proyeksi5tahuns as $proyeksi5tahun){
        $x++;
        $len = strlen($proyeksi5tahun->idskpd);

        $pensiun1[$x] = $proyeksi5tahun->pensiun1;
        $pensiun2[$x] = $proyeksi5tahun->pensiun2;
        $pensiun3[$x] = $proyeksi5tahun->pensiun3;
        $pensiun4[$x] = $proyeksi5tahun->pensiun4;
        $pensiun5[$x] = $proyeksi5tahun->pensiun5;

        $kurang1[$x] = $proyeksi5tahun->jumlahak - $proyeksi5tahun->jumlahreal + $proyeksi5tahun->pensiun1;
        $kurang2[$x] = $proyeksi5tahun->jumlahak - $proyeksi5tahun->jumlahreal + $proyeksi5tahun->pensiun2 + $proyeksi5tahun->pensiun1;
        $kurang3[$x] = $proyeksi5tahun->jumlahak - $proyeksi5tahun->jumlahreal + $proyeksi5tahun->pensiun3 + $proyeksi5tahun->pensiun2 + $proyeksi5tahun->pensiun1;
        $kurang4[$x] = $proyeksi5tahun->jumlahak - $proyeksi5tahun->jumlahreal + $proyeksi5tahun->pensiun4 + $proyeksi5tahun->pensiun3 + $proyeksi5tahun->pensiun2 + $proyeksi5tahun->pensiun1;
        $kurang5[$x] = $proyeksi5tahun->jumlahak - $proyeksi5tahun->jumlahreal + $proyeksi5tahun->pensiun5 + $proyeksi5tahun->pensiun4 + $proyeksi5tahun->pensiun3 + $proyeksi5tahun->pensiun2 + $proyeksi5tahun->pensiun1;

        $jumlahreal[$x] = $proyeksi5tahun->jumlahreal;
        $jumlahak[$x] = $proyeksi5tahun->jumlahak;

        if($len == 2){
            if($proyeksi5tahun->idjenjab > 4){
               $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"20.0625\">
                <Cell ss:StyleID=\"s131\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:MergeAcross=\"6\" ss:StyleID=\"m316500752\"><Data ss:Type=\"String\">".$proyeksi5tahun->namajabatan."</Data></Cell>
                <Cell ss:StyleID=\"s148\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahreal."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahak."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun1."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun2."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun3."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun4."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun5."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang1[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang2[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang3[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang4[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s150\"><Data ss:Type=\"Number\">".$kurang5[$x]."</Data></Cell>
               </Row>";
            }else{
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"20.0625\">
                <Cell ss:StyleID=\"s142\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"s143\"/>
                <Cell ss:MergeAcross=\"5\" ss:StyleID=\"m316500772\"><Data ss:Type=\"String\">".$proyeksi5tahun->namajabatan."</Data></Cell>
                <Cell ss:StyleID=\"s148\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahreal."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahak."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun1."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun2."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun3."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun4."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun5."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang1[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang2[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang3[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang4[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s150\"><Data ss:Type=\"Number\">".$kurang5[$x]."</Data></Cell>
               </Row>";
            }
        }elseif($len == 5){
            if($proyeksi5tahun->idjenjab > 4){
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"20.0625\">
                <Cell ss:StyleID=\"s142\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"s143\"/>
                <Cell ss:MergeAcross=\"5\" ss:StyleID=\"m316500772\"><Data ss:Type=\"String\">".$proyeksi5tahun->namajabatan."</Data></Cell>
                <Cell ss:StyleID=\"s148\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahreal."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahak."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun1."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun2."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun3."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun4."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun5."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang1[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang2[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang3[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang4[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s150\"><Data ss:Type=\"Number\">".$kurang5[$x]."</Data></Cell>
               </Row>";
            }else{
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"20.0625\">
                <Cell ss:StyleID=\"s151\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"s143\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:MergeAcross=\"4\" ss:StyleID=\"m316500792\"><Data ss:Type=\"String\">".$proyeksi5tahun->namajabatan."</Data></Cell>
                <Cell ss:StyleID=\"s148\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahreal."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahak."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun1."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun2."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun3."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun4."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun5."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang1[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang2[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang3[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang4[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s150\"><Data ss:Type=\"Number\">".$kurang5[$x]."</Data></Cell>
               </Row>";
            }
        }elseif($len == 8){
            if($proyeksi5tahun->idjenjab > 4){
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"20.0625\">
                <Cell ss:StyleID=\"s151\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"s143\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:MergeAcross=\"4\" ss:StyleID=\"m316500792\"><Data ss:Type=\"String\">".$proyeksi5tahun->namajabatan."</Data></Cell>
                <Cell ss:StyleID=\"s148\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahreal."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahak."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun1."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun2."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun3."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun4."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun5."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang1[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang2[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang3[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang4[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s150\"><Data ss:Type=\"Number\">".$kurang5[$x]."</Data></Cell>
               </Row>";
            }else{
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"20.0625\">
                <Cell ss:StyleID=\"s151\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"s143\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:MergeAcross=\"3\" ss:StyleID=\"m316500812\"><Data ss:Type=\"String\">".$proyeksi5tahun->namajabatan."</Data></Cell>
                <Cell ss:StyleID=\"s148\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahreal."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahak."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun1."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun2."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun3."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun4."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun5."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang1[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang2[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang3[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang4[$x]."</Data></Cell>
                <Cell ss:StyleID=\"s150\"><Data ss:Type=\"Number\">".$kurang5[$x]."</Data></Cell>
               </Row>";
            }
        }elseif($len == 11){
            if($proyeksi5tahun->idjenjab > 4){
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"20.0625\">
                    <Cell ss:StyleID=\"s151\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                    <Cell ss:StyleID=\"s143\"/>
                    <Cell ss:StyleID=\"s152\"/>
                    <Cell ss:StyleID=\"s152\"/>
                    <Cell ss:MergeAcross=\"3\" ss:StyleID=\"m316500812\"><Data ss:Type=\"String\">".$proyeksi5tahun->namajabatan."</Data></Cell>
                    <Cell ss:StyleID=\"s148\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahreal."</Data></Cell>
                    <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->jumlahak."</Data></Cell>
                    <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun1."</Data></Cell>
                    <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun2."</Data></Cell>
                    <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun3."</Data></Cell>
                    <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun4."</Data></Cell>
                    <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$proyeksi5tahun->pensiun5."</Data></Cell>
                    <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang1[$x]."</Data></Cell>
                    <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang2[$x]."</Data></Cell>
                    <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang3[$x]."</Data></Cell>
                    <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">".$kurang4[$x]."</Data></Cell>
                    <Cell ss:StyleID=\"s150\"><Data ss:Type=\"Number\">".$kurang5[$x]."</Data></Cell>
                   </Row>";
            }else{
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"20.25\">
                <Cell ss:StyleID=\"s151\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"s143\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m316503416\"><Data ss:Type=\"String\">".$proyeksi5tahun->namajabatan."</Data></Cell>
                <Cell ss:StyleID=\"s148\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s150\"><Data ss:Type=\"Number\">1</Data></Cell>
               </Row>";
            }
        }elseif($len == 14){
            if($proyeksi5tahun->idjenjab > 4){
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"20.25\">
                <Cell ss:StyleID=\"s151\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"s143\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m316503416\"><Data ss:Type=\"String\">".$proyeksi5tahun->namajabatan."</Data></Cell>
                <Cell ss:StyleID=\"s148\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s150\"><Data ss:Type=\"Number\">1</Data></Cell>
               </Row>";
            }else{
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"20.0625\">
                <Cell ss:StyleID=\"s151\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"s143\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:StyleID=\"s152\"/>
                <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m316503436\"><Data ss:Type=\"String\">".$proyeksi5tahun->namajabatan."</Data></Cell>
                <Cell ss:StyleID=\"s148\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s149\"><Data ss:Type=\"Number\">1</Data></Cell>
                <Cell ss:StyleID=\"s150\"><Data ss:Type=\"Number\">1</Data></Cell>
               </Row>";
            }
        }

    }
    $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"24.9375\">
    <Cell ss:StyleID=\"s122\"/>
    <Cell ss:MergeAcross=\"6\" ss:StyleID=\"m316500732\"><Data ss:Type=\"String\">Jumlah Seluruhnya</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($jumlahreal)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($jumlahak)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($pensiun1)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($pensiun2)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($pensiun3)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($pensiun4)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($pensiun5)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($kurang1)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($kurang2)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($kurang3)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($kurang4)."</Data></Cell>
    <Cell ss:StyleID=\"s130\"><Data ss:Type=\"Number\">".array_sum($kurang5)."</Data></Cell>
   </Row>
    <Row ss:AutoFitHeight=\"0\" ss:Height=\"20.0625\">
    <Cell ss:StyleID=\"s164\"/>
    <Cell ss:StyleID=\"s165\"/>
    <Cell ss:StyleID=\"s166\"/>
    <Cell ss:StyleID=\"s166\"/>
    <Cell ss:StyleID=\"s166\"/>
    <Cell ss:StyleID=\"s166\"/>
    <Cell ss:StyleID=\"s166\"/>
    <Cell ss:StyleID=\"s166\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s167\"/>
    <Cell ss:StyleID=\"s168\"/>
   </Row>
  </Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <PageSetup>
    <Layout x:Orientation=\"Landscape\"/>
    <Header x:Margin=\"0.3\"/>
    <Footer x:Margin=\"0.3\"/>
    <PageMargins x:Bottom=\"0.75\" x:Left=\"0.7\" x:Right=\"0.7\" x:Top=\"0.75\"/>
   </PageSetup>
   <Unsynced/>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>148</PaperSizeIndex>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <TabColorIndex>21</TabColorIndex>
   <PageBreakZoom>100</PageBreakZoom>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>8</ActiveRow>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
";

force_download("proyeksi_5_tahunan_".date('Ymds').".xls", $w);
?>

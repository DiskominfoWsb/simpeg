<?php

// memanggil library FPDF
require('libraries/fpdf/fpdf.php');

 
// intance object dan memberikan pengaturan halaman PDF
$pdf=new FPDF('P','mm','F4');
$pdf->AddPage();
 
$pdf->SetFont('Times','B',14);
$pdf->Cell(200,10,'DATA KEPALA OPD',0,0,'C');
 
$pdf->Cell(10,15,'',0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(10,7,'NO',1,0,'C');
$pdf->Cell(60,7,'NAMA JABATAN' ,1,0,'C');
$pdf->Cell(40,7,'NAMA PEJABAT',1,0,'C');
$pdf->Cell(20,7,'PANGKAT',1,0,'C');
$pdf->Cell(15,7,'ESELON',1,0,'C');
$pdf->Cell(35,7,'PENDIDIKAN',1,0,'C');
 
 
$pdf->Cell(10,7,'',0,1);
$pdf->SetFont('Times','',12);
$x = 0;
$rs = $this->db->query("SELECT a.jab,concat(if(b.gdp='','',concat(b.gdp,' ')),b.nama,if(b.gdb='','',concat(', ',b.gdb)))as nama, c.pangkat, c.golru, d.esl as eselon, e.jenjurusan from a_skpd a
left join tb_1223 b on a.idskpd=b.idskpd
left join a_golruang c on b.idgolrupkt=c.idgolru
left join a_esl d on b.idesljbt=d.idesl
left join a_jenjurusan e on b.idjenjurusan=e.idjenjurusan
WHERE  length(a.idskpd)='2' and a.flag='1' and b.idjenkedudupeg not in('21','99') and b.idesljbt in('21','22','31') or (a.idskpd like'01.%' and b.idjenkedudupeg not in('21','99'))
or (a.idskpd like'02.%' and b.idjenkedudupeg not in('21','99') and b.idesljbt='31')");
foreach ($rs->result() as $item) {
    $x++;

  $pdf->Cell(10,6, $no,1,0,'C'); 
  $pdf->Cell(50,6, $item->jab,1,0);
  $pdf->Cell(75,6, $item->nama,1,0);  
  $pdf->Cell(55,6, $item->pangkat.'<br>'.$item->golru,1,1);
  $pdf->Cell(75,6, $item->eselon,1,0);
  $pdf->Cell(75,6, $item->jenjurusan,1,0);
}
 
$pdf->Output();
 
?>


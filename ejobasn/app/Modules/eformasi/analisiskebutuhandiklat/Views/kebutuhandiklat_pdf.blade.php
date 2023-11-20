<?php

use rizalafani\fpdflaravel\Fpdf as FPDFS;
class PDF_MC_Table extends FPDFS{
    var $widths;
    var $aligns;
    
    function Footer(){
        $this->SetY(-9);
        $this->SetFont('Arial', '', 7);
        $this->SetFont('Arial', '', 7);
        $this->Cell(5);
        $this->Cell(20, 4, 'Hal. : ' . $this->PageNo(), 0, 0, 'L');        
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(170, 4, 'Printed on : ' . date('d-m-Y H:i:s') . ' | Generated by Simpeg Kab. Kendal', 0, 1, 'R');
    }

    function SetWidths($w){
        $this->widths=$w;
    }

    function SetAligns($a){
        $this->aligns=$a;
    }

    function Row($data){
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=8*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,8,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function Rowmini($data){
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=6*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,6,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }
    
    function RowNoLinesMini($data){
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=6*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            //$this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,6,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowNoLines($data){
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=8*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
//            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,8,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h){
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt){
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb){
            $c=$s[$i];
            if($c=="\n"){
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax){
                if($sep==-1){
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
//}

//class PDF_Code128 

    protected $T128;                                         // Tableau des codes 128
    protected $ABCset = "";                                  // jeu des caractères éligibles au C128
    protected $Aset = "";                                    // Set A du jeu des caractères éligibles
    protected $Bset = "";                                    // Set B du jeu des caractères éligibles
    protected $Cset = "";                                    // Set C du jeu des caractères éligibles
    protected $SetFrom;                                      // Convertisseur source des jeux vers le tableau
    protected $SetTo;                                        // Convertisseur destination des jeux vers le tableau
    protected $JStart = array("A"=>103, "B"=>104, "C"=>105); // Caractères de sélection de jeu au début du C128
    protected $JSwap = array("A"=>101, "B"=>100, "C"=>99);   // Caractères de changement de jeu

    //____________________________ Extension du constructeur _______________________
    function __construct($orientation='P', $unit='mm', $format='A4') {

        parent::__construct($orientation,$unit,$format);

        $this->T128[] = array(2, 1, 2, 2, 2, 2);           //0 : [ ]               // composition des caractères
        $this->T128[] = array(2, 2, 2, 1, 2, 2);           //1 : [!]
        $this->T128[] = array(2, 2, 2, 2, 2, 1);           //2 : ["]
        $this->T128[] = array(1, 2, 1, 2, 2, 3);           //3 : [#]
        $this->T128[] = array(1, 2, 1, 3, 2, 2);           //4 : [$]
        $this->T128[] = array(1, 3, 1, 2, 2, 2);           //5 : [%]
        $this->T128[] = array(1, 2, 2, 2, 1, 3);           //6 : [&]
        $this->T128[] = array(1, 2, 2, 3, 1, 2);           //7 : [']
        $this->T128[] = array(1, 3, 2, 2, 1, 2);           //8 : [(]
        $this->T128[] = array(2, 2, 1, 2, 1, 3);           //9 : [)]
        $this->T128[] = array(2, 2, 1, 3, 1, 2);           //10 : [*]
        $this->T128[] = array(2, 3, 1, 2, 1, 2);           //11 : [+]
        $this->T128[] = array(1, 1, 2, 2, 3, 2);           //12 : [,]
        $this->T128[] = array(1, 2, 2, 1, 3, 2);           //13 : [-]
        $this->T128[] = array(1, 2, 2, 2, 3, 1);           //14 : [.]
        $this->T128[] = array(1, 1, 3, 2, 2, 2);           //15 : [/]
        $this->T128[] = array(1, 2, 3, 1, 2, 2);           //16 : [0]
        $this->T128[] = array(1, 2, 3, 2, 2, 1);           //17 : [1]
        $this->T128[] = array(2, 2, 3, 2, 1, 1);           //18 : [2]
        $this->T128[] = array(2, 2, 1, 1, 3, 2);           //19 : [3]
        $this->T128[] = array(2, 2, 1, 2, 3, 1);           //20 : [4]
        $this->T128[] = array(2, 1, 3, 2, 1, 2);           //21 : [5]
        $this->T128[] = array(2, 2, 3, 1, 1, 2);           //22 : [6]
        $this->T128[] = array(3, 1, 2, 1, 3, 1);           //23 : [7]
        $this->T128[] = array(3, 1, 1, 2, 2, 2);           //24 : [8]
        $this->T128[] = array(3, 2, 1, 1, 2, 2);           //25 : [9]
        $this->T128[] = array(3, 2, 1, 2, 2, 1);           //26 : [:]
        $this->T128[] = array(3, 1, 2, 2, 1, 2);           //27 : [;]
        $this->T128[] = array(3, 2, 2, 1, 1, 2);           //28 : [<]
        $this->T128[] = array(3, 2, 2, 2, 1, 1);           //29 : [=]
        $this->T128[] = array(2, 1, 2, 1, 2, 3);           //30 : [>]
        $this->T128[] = array(2, 1, 2, 3, 2, 1);           //31 : [?]
        $this->T128[] = array(2, 3, 2, 1, 2, 1);           //32 : [@]
        $this->T128[] = array(1, 1, 1, 3, 2, 3);           //33 : [A]
        $this->T128[] = array(1, 3, 1, 1, 2, 3);           //34 : [B]
        $this->T128[] = array(1, 3, 1, 3, 2, 1);           //35 : [C]
        $this->T128[] = array(1, 1, 2, 3, 1, 3);           //36 : [D]
        $this->T128[] = array(1, 3, 2, 1, 1, 3);           //37 : [E]
        $this->T128[] = array(1, 3, 2, 3, 1, 1);           //38 : [F]
        $this->T128[] = array(2, 1, 1, 3, 1, 3);           //39 : [G]
        $this->T128[] = array(2, 3, 1, 1, 1, 3);           //40 : [H]
        $this->T128[] = array(2, 3, 1, 3, 1, 1);           //41 : [I]
        $this->T128[] = array(1, 1, 2, 1, 3, 3);           //42 : [J]
        $this->T128[] = array(1, 1, 2, 3, 3, 1);           //43 : [K]
        $this->T128[] = array(1, 3, 2, 1, 3, 1);           //44 : [L]
        $this->T128[] = array(1, 1, 3, 1, 2, 3);           //45 : [M]
        $this->T128[] = array(1, 1, 3, 3, 2, 1);           //46 : [N]
        $this->T128[] = array(1, 3, 3, 1, 2, 1);           //47 : [O]
        $this->T128[] = array(3, 1, 3, 1, 2, 1);           //48 : [P]
        $this->T128[] = array(2, 1, 1, 3, 3, 1);           //49 : [Q]
        $this->T128[] = array(2, 3, 1, 1, 3, 1);           //50 : [R]
        $this->T128[] = array(2, 1, 3, 1, 1, 3);           //51 : [S]
        $this->T128[] = array(2, 1, 3, 3, 1, 1);           //52 : [T]
        $this->T128[] = array(2, 1, 3, 1, 3, 1);           //53 : [U]
        $this->T128[] = array(3, 1, 1, 1, 2, 3);           //54 : [V]
        $this->T128[] = array(3, 1, 1, 3, 2, 1);           //55 : [W]
        $this->T128[] = array(3, 3, 1, 1, 2, 1);           //56 : [X]
        $this->T128[] = array(3, 1, 2, 1, 1, 3);           //57 : [Y]
        $this->T128[] = array(3, 1, 2, 3, 1, 1);           //58 : [Z]
        $this->T128[] = array(3, 3, 2, 1, 1, 1);           //59 : [[]
        $this->T128[] = array(3, 1, 4, 1, 1, 1);           //60 : [\]
        $this->T128[] = array(2, 2, 1, 4, 1, 1);           //61 : []]
        $this->T128[] = array(4, 3, 1, 1, 1, 1);           //62 : [^]
        $this->T128[] = array(1, 1, 1, 2, 2, 4);           //63 : [_]
        $this->T128[] = array(1, 1, 1, 4, 2, 2);           //64 : [`]
        $this->T128[] = array(1, 2, 1, 1, 2, 4);           //65 : [a]
        $this->T128[] = array(1, 2, 1, 4, 2, 1);           //66 : [b]
        $this->T128[] = array(1, 4, 1, 1, 2, 2);           //67 : [c]
        $this->T128[] = array(1, 4, 1, 2, 2, 1);           //68 : [d]
        $this->T128[] = array(1, 1, 2, 2, 1, 4);           //69 : [e]
        $this->T128[] = array(1, 1, 2, 4, 1, 2);           //70 : [f]
        $this->T128[] = array(1, 2, 2, 1, 1, 4);           //71 : [g]
        $this->T128[] = array(1, 2, 2, 4, 1, 1);           //72 : [h]
        $this->T128[] = array(1, 4, 2, 1, 1, 2);           //73 : [i]
        $this->T128[] = array(1, 4, 2, 2, 1, 1);           //74 : [j]
        $this->T128[] = array(2, 4, 1, 2, 1, 1);           //75 : [k]
        $this->T128[] = array(2, 2, 1, 1, 1, 4);           //76 : [l]
        $this->T128[] = array(4, 1, 3, 1, 1, 1);           //77 : [m]
        $this->T128[] = array(2, 4, 1, 1, 1, 2);           //78 : [n]
        $this->T128[] = array(1, 3, 4, 1, 1, 1);           //79 : [o]
        $this->T128[] = array(1, 1, 1, 2, 4, 2);           //80 : [p]
        $this->T128[] = array(1, 2, 1, 1, 4, 2);           //81 : [q]
        $this->T128[] = array(1, 2, 1, 2, 4, 1);           //82 : [r]
        $this->T128[] = array(1, 1, 4, 2, 1, 2);           //83 : [s]
        $this->T128[] = array(1, 2, 4, 1, 1, 2);           //84 : [t]
        $this->T128[] = array(1, 2, 4, 2, 1, 1);           //85 : [u]
        $this->T128[] = array(4, 1, 1, 2, 1, 2);           //86 : [v]
        $this->T128[] = array(4, 2, 1, 1, 1, 2);           //87 : [w]
        $this->T128[] = array(4, 2, 1, 2, 1, 1);           //88 : [x]
        $this->T128[] = array(2, 1, 2, 1, 4, 1);           //89 : [y]
        $this->T128[] = array(2, 1, 4, 1, 2, 1);           //90 : [z]
        $this->T128[] = array(4, 1, 2, 1, 2, 1);           //91 : [{]
        $this->T128[] = array(1, 1, 1, 1, 4, 3);           //92 : [|]
        $this->T128[] = array(1, 1, 1, 3, 4, 1);           //93 : [}]
        $this->T128[] = array(1, 3, 1, 1, 4, 1);           //94 : [~]
        $this->T128[] = array(1, 1, 4, 1, 1, 3);           //95 : [DEL]
        $this->T128[] = array(1, 1, 4, 3, 1, 1);           //96 : [FNC3]
        $this->T128[] = array(4, 1, 1, 1, 1, 3);           //97 : [FNC2]
        $this->T128[] = array(4, 1, 1, 3, 1, 1);           //98 : [SHIFT]
        $this->T128[] = array(1, 1, 3, 1, 4, 1);           //99 : [Cswap]
        $this->T128[] = array(1, 1, 4, 1, 3, 1);           //100 : [Bswap]                
        $this->T128[] = array(3, 1, 1, 1, 4, 1);           //101 : [Aswap]
        $this->T128[] = array(4, 1, 1, 1, 3, 1);           //102 : [FNC1]
        $this->T128[] = array(2, 1, 1, 4, 1, 2);           //103 : [Astart]
        $this->T128[] = array(2, 1, 1, 2, 1, 4);           //104 : [Bstart]
        $this->T128[] = array(2, 1, 1, 2, 3, 2);           //105 : [Cstart]
        $this->T128[] = array(2, 3, 3, 1, 1, 1);           //106 : [STOP]
        $this->T128[] = array(2, 1);                       //107 : [END BAR]

        for ($i = 32; $i <= 95; $i++) {                                            // jeux de caractères
            $this->ABCset .= chr($i);
        }
        $this->Aset = $this->ABCset;
        $this->Bset = $this->ABCset;

        for ($i = 0; $i <= 31; $i++) {
            $this->ABCset .= chr($i);
            $this->Aset .= chr($i);
        }
        for ($i = 96; $i <= 127; $i++) {
            $this->ABCset .= chr($i);
            $this->Bset .= chr($i);
        }
        for ($i = 200; $i <= 210; $i++) {                                           // controle 128
            $this->ABCset .= chr($i);
            $this->Aset .= chr($i);
            $this->Bset .= chr($i);
        }
        $this->Cset="0123456789".chr(206);

        for ($i=0; $i<96; $i++) {                                                   // convertisseurs des jeux A & B
            @$this->SetFrom["A"] .= chr($i);
            @$this->SetFrom["B"] .= chr($i + 32);
            @$this->SetTo["A"] .= chr(($i < 32) ? $i+64 : $i-32);
            @$this->SetTo["B"] .= chr($i);
        }
        for ($i=96; $i<107; $i++) {                                                 // contrôle des jeux A & B
            @$this->SetFrom["A"] .= chr($i + 104);
            @$this->SetFrom["B"] .= chr($i + 104);
            @$this->SetTo["A"] .= chr($i);
            @$this->SetTo["B"] .= chr($i);
        }
    }

    //________________ Fonction encodage et dessin du code 128 _____________________
    function Code128($x, $y, $code, $w, $h) {
        $Aguid = "";                                                                      // Création des guides de choix ABC
        $Bguid = "";
        $Cguid = "";
        for ($i=0; $i < strlen($code); $i++) {
            $needle = substr($code,$i,1);
            $Aguid .= ((strpos($this->Aset,$needle)===false) ? "N" : "O"); 
            $Bguid .= ((strpos($this->Bset,$needle)===false) ? "N" : "O"); 
            $Cguid .= ((strpos($this->Cset,$needle)===false) ? "N" : "O");
        }

        $SminiC = "OOOO";
        $IminiC = 4;

        $crypt = "";
        while ($code > "") {
                                                                                        // BOUCLE PRINCIPALE DE CODAGE
            $i = strpos($Cguid,$SminiC);                                                // forçage du jeu C, si possible
            if ($i!==false) {
                $Aguid [$i] = "N";
                $Bguid [$i] = "N";
            }

            if (substr($Cguid,0,$IminiC) == $SminiC) {                                  // jeu C
                $crypt .= chr(($crypt > "") ? $this->JSwap["C"] : $this->JStart["C"]);  // début Cstart, sinon Cswap
                $made = strpos($Cguid,"N");                                             // étendu du set C
                if ($made === false) {
                    $made = strlen($Cguid);
                }
                if (fmod($made,2)==1) {
                    $made--;                                                            // seulement un nombre pair
                }
                for ($i=0; $i < $made; $i += 2) {
                    $crypt .= chr(strval(substr($code,$i,2)));                          // conversion 2 par 2
                }
                $jeu = "C";
            } else {
                $madeA = strpos($Aguid,"N");                                            // étendu du set A
                if ($madeA === false) {
                    $madeA = strlen($Aguid);
                }
                $madeB = strpos($Bguid,"N");                                            // étendu du set B
                if ($madeB === false) {
                    $madeB = strlen($Bguid);
                }
                $made = (($madeA < $madeB) ? $madeB : $madeA );                         // étendu traitée
                $jeu = (($madeA < $madeB) ? "B" : "A" );                                // Jeu en cours

                $crypt .= chr(($crypt > "") ? $this->JSwap[$jeu] : $this->JStart[$jeu]); // début start, sinon swap

                $crypt .= strtr(substr($code, 0,$made), $this->SetFrom[$jeu], $this->SetTo[$jeu]); // conversion selon jeu

            }
            $code = substr($code,$made);                                           // raccourcir légende et guides de la zone traitée
            $Aguid = substr($Aguid,$made);
            $Bguid = substr($Bguid,$made);
            $Cguid = substr($Cguid,$made);
        }                                                                          // FIN BOUCLE PRINCIPALE

        $check = ord($crypt[0]);                                                   // calcul de la somme de contrôle
        for ($i=0; $i<strlen($crypt); $i++) {
            $check += (ord($crypt[$i]) * $i);
        }
        $check %= 103;

        $crypt .= chr($check) . chr(106) . chr(107);                               // Chaine cryptée complète

        $i = (strlen($crypt) * 11) - 8;                                            // calcul de la largeur du module
        $modul = $w/$i;

        for ($i=0; $i<strlen($crypt); $i++) {                                      // BOUCLE D'IMPRESSION
            $c = $this->T128[ord($crypt[$i])];
            for ($j=0; $j<count($c); $j++) {
                $this->Rect($x,$y,$c[$j]*$modul,$h,"F");
                $x += ($c[$j++]+$c[$j])*$modul;
            }
        }
    }
}  

    $pdf = new PDF_MC_Table('P', 'mm', array(210, 297));

    $pdf->SetAutoPageBreak(true, 10);
    $pdf->SetMargins(10, 15, 10);

    $idskpd = Input::get('idskpd');
    $periode_bulan = Input::get('periode_bulan');
    $periode_tahun = Input::get('periode_tahun');
    $idjenjab = Input::get('idjenjab');
    $idjabatan = Input::get('idjabatan');
    $idjendiklat = Input::get('idjendiklat');
    $iddiklat = Input::get('iddiklat');
    $kdunit = substr($idskpd,0,2);

    $idstatusdiklat = Input::get('idstatusdiklat');

    $where = ' tb_01.idjenkedudupeg not in ("99","21") and tb_01.kdunit = "'.$kdunit.'"';
    if($idjenjab == '2'){
        // $where .= " and tb_01.idjabfung = '".$idjabatan."' and tb_01.idjabfung != '' and tb_01.idjenjab = '".$idjenjab."' and tb_01.idskpd like '".$idskpd."%'";
        $where .= " and tb_01.idjabfung = '".$idjabatan."' and tb_01.idjabfung != '' and tb_01.idskpd like '".$idskpd."%'";
    } else if($idjenjab == '3'){
        // $where .= " and tb_01.idjabfungum = '".$idjabatan."' and tb_01.idjabfungum != '' and tb_01.idjenjab = '".$idjenjab."' and tb_01.idskpd like '".$idskpd."%'";
        $where .= " and tb_01.idjabfungum = '".$idjabatan."' and tb_01.idjabfungum != '' and tb_01.idskpd like '".$idskpd."%'";
    } else {
        //$where .= " and tb_01.idskpd like '".$idskpd."%' and tb_01.idskpd != '' and tb_01.idjenjab > '4'";
        $where .= " and tb_01.idskpd like '".$idskpd."%' and tb_01.idskpd != ''";
    }


    if($idjendiklat == 1){

        $diklat = \DB::connection('kepegawaian')->table('a_dikstru')->where('iddikstru','=',$iddiklat)->first();

        if($idstatusdiklat==1){
            $where .= " and r_dikstru.iddikstru = '".$iddiklat."' AND tb_01.nip IN (SELECT nip FROM r_dikstru WHERE iddikstru = '".$iddiklat."') group by tb_01.nip";
        } else {
            $where .= " and r_dikstru.iddikstru != '".$iddiklat."' AND tb_01.nip NOT IN (SELECT nip FROM r_dikstru WHERE iddikstru = '".$iddiklat."') AND tb_01.idjenjab > '4' group by tb_01.nip";
        }

        $rs = \DB::connection('kepegawaian')->table('r_dikstru')
        ->join('tb_01','tb_01.nip','=','r_dikstru.nip')
        ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftJoin('a_skpd as b', \DB::raw('left(tb_01.idskpd,2)'), '=' ,'b.idskpd')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->select('tb_01.*','a_golruang.golru','b.skpd', 'a_skpd.skpd as subskpd',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan')
        )
        ->whereRaw($where)
        ->orderBy('tb_01.idjenjab', 'asc')
        ->orderBy('tb_01.idgolrupkt', 'desc')

        // ->where('tr_petajab.idskpd','like',''.$idskpd.'%')
        // ->orderBy('tr_petajab.idskpd','asc')
        // ->orderBy('tr_petajab.idjabjbt','desc')
        // ->orderBy('a_jabfung.kelas_jabatan','desc')
        // ->orderBy('a_jabfungum.kelas_jabatan','desc')
        // ->orderBy('tr_petajab.idjabfungum','asc')
        // ->orderBy('tr_petajab.idjabfung','asc')
        // ->groupBy('tr_petajab.id')
        ->get();
    } else if($idjendiklat == 2){
        $diklat = \DB::connection('kepegawaian')->table('a_dikfung')->where('iddikfung','=',$iddiklat)->first();

        if($idstatusdiklat==1){
            $where .= " and r_dikfung.iddikfung = '".$iddiklat."' AND tb_01.nip IN (SELECT nip FROM r_dikfung WHERE iddikfung = '".$iddiklat."') group by tb_01.nip";
        } else {
            $where .= " and r_dikfung.iddikfung != '".$iddiklat."' AND tb_01.nip NOT IN (SELECT nip FROM r_dikfung WHERE iddikfung = '".$iddiklat."') AND tb_01.idjenjab = '2' group by tb_01.nip";
        }

        $rs = \DB::connection('kepegawaian')->table('r_dikfung')
        ->join('tb_01','tb_01.nip','=','r_dikfung.nip')
        ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftJoin('a_skpd as b', \DB::raw('left(tb_01.idskpd,2)'), '=' ,'b.idskpd')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->select('tb_01.*','a_golruang.golru','b.skpd', 'a_skpd.skpd as subskpd',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan')
        )
        ->whereRaw($where)
        ->orderBy('tb_01.idjenjab', 'asc')
        ->orderBy('tb_01.idgolrupkt', 'desc')

        // ->where('tr_petajab.idskpd','like',''.$idskpd.'%')
        // ->orderBy('tr_petajab.idskpd','asc')
        // ->orderBy('tr_petajab.idjabjbt','desc')
        // ->orderBy('a_jabfung.kelas_jabatan','desc')
        // ->orderBy('a_jabfungum.kelas_jabatan','desc')
        // ->orderBy('tr_petajab.idjabfungum','asc')
        // ->orderBy('tr_petajab.idjabfung','asc')
        // ->groupBy('tr_petajab.id')
        ->get();
    } else if($idjendiklat == 3){
        $diklat = \DB::connection('kepegawaian')->table('a_diktek')->where('iddiktek','=',$iddiklat)->first();

        if($idstatusdiklat==1){
            $where .= " and r_diktek.iddiktek = '".$iddiklat."' AND tb_01.nip IN (SELECT nip FROM r_diktek WHERE iddiktek = '".$iddiklat."') group by tb_01.nip";
        } else {
            $where .= " and r_diktek.iddiktek != '".$iddiklat."' AND tb_01.nip NOT IN (SELECT nip FROM r_diktek WHERE iddiktek = '".$iddiklat."') AND tb_01.idjenjab = '3' OR tb_01.idjenjab = '2' OR tb_01.idjenjab > '4' group by tb_01.nip";
        }

        $rs = \DB::connection('kepegawaian')->table('r_diktek')
        ->join('tb_01','tb_01.nip','=','r_diktek.nip')
        ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftJoin('a_skpd as b', \DB::raw('left(tb_01.idskpd,2)'), '=' ,'b.idskpd')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->select('tb_01.*','a_golruang.golru','b.skpd', 'a_skpd.skpd as subskpd',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan')
        )
        ->whereRaw($where)
        ->orderBy('tb_01.idjenjab', 'asc')
        ->orderBy('tb_01.idgolrupkt', 'desc')

        // ->where('tr_petajab.idskpd','like',''.$idskpd.'%')
        // ->orderBy('tr_petajab.idskpd','asc')
        // ->orderBy('tr_petajab.idjabjbt','desc')
        // ->orderBy('a_jabfung.kelas_jabatan','desc')
        // ->orderBy('a_jabfungum.kelas_jabatan','desc')
        // ->orderBy('tr_petajab.idjabfungum','asc')
        // ->orderBy('tr_petajab.idjabfung','asc')
        // ->groupBy('tr_petajab.id')
        ->get();
    }



    // $rs = \DB::select(DB::raw("SELECT a.*, 
    
    
    
    
    
    
    
    // b.nip, b.namalengkap, b.id as idpetajab
    //         FROM tr_petajab AS a 
    //         LEFT JOIN tr_pemangkujab AS b ON
    //         a.id = b.id_petajab
    //         WHERE a.periode_bulan = \"".$periode_bulan."\" and a.periode_tahun = \"".$periode_tahun."\" AND a.idskpd LIKE \"".$idskpd."%\" ORDER BY a.idskpd, idjabfungum, idjabfung"
    //     ));

    // $rs2 = \DB::select(DB::raw("SELECT a.*, b.nip, b.namalengkap, c.jabfung2, b.id as idpetajab
    //         FROM tr_formasi_peta AS a
    //         INNER JOIN a_jabfung c on a.idjabfung = c.idjabfung
    //         LEFT JOIN tr_formasi_pemangku AS b ON a.id = b.id_petajab
    //         WHERE a.periode = \"".$periode."\" and a.idjenjab = 2 AND a.idskpd LIKE \"".$idskpd."%\" ORDER BY a.idskpd, idjabfung"
    //     ));

    if($rs){
        //Halaman 1
        $pdf->AddPage();
        // Arial bold 15
        $pdf->SetFont('Arial', 'B', 12);
        // Title
        $pdf->Cell(200, 7, 'ANALISIS KEBUTUHAN DIKLAT', 0, 1, 'C');

        if($idjendiklat==1){
            $pdf->Cell(200, 7, strtoupper($diklat->dikstru), 0, 1, 'C');
        } elseif($idjendiklat==2){
            $pdf->Cell(200, 7, strtoupper($diklat->dikfung), 0, 1, 'C');
        } else{
            $pdf->Cell(200, 7, strtoupper($diklat->diktek), 0, 1, 'C');
        }

        $pdf->Cell(200, 7, 'PADA '.((Input::get('idskpd') != '')?strtoupper(getSkpd(Input::get('idskpd'))):''), 0, 1, 'C');
        $pdf->Cell(200, 7, '', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 6);

        $pdf->Cell(10, 7, 'NO', 1, 0, 'C');
        $pdf->Cell(30, 7, 'NIP', 1, 0,'C');
        $pdf->Cell(40, 7, 'NAMA', 1, 0, 'C');
        $pdf->Cell(15, 7, 'GOLONGAN', 1, 0, 'C');
        $pdf->Cell(25, 7, 'JABATAN', 1, 0, 'C');
        $pdf->Cell(35, 7, 'SUB UNIT KERJA', 1, 0, 'C');
        $pdf->Cell(35, 7, 'UNIT KERJA', 1, 1, 'C');

        $no = 0;
        if(count($rs) > 0){
            $pdf->SetWidths(array(10,30,40,15,25,35,35));
            $pdf->SetAligns(array('C','L','L','C','L','L','L'));
            /*looping jabatan struktural dan pelaksana*/

            foreach($rs as $item){
                $no++;
                $pdf->Rowmini(array($no,fnip($item->nip),$item->namalengkap, $item->golru, $item->jabatan, $item->subskpd, $item->skpd ));
            }
        } else {
            $pdf->SetWidths(array(190));
            $pdf->SetAligns(array('C'));
            $pdf->Rowmini(array('DATA TIDAK DITEMUKAN'));
        }


        $pdf->Cell(5, 4, '', 0, 1);
        // $pdf->Cell(15, 4, 'CATATAN', 0, 0, 'L');
        // $pdf->Cell(3, 4, ':', 0, 0, 'L');
        // $pdf->Cell(3, 4, '-', 0, 0, 'L');
        // $pdf->Cell(84, 4, 'Jabatan untuk pelaksana mengacu pada', 0, 0, 'L');
        // $pdf->Cell(85, 4, '...................., ....................................', 0, 1, 'C');
        // $pdf->Cell(21, 4, '', 0, 0, 'L');
        // $pdf->Cell(84, 4, 'Permenpan Nomor 25 Tahun 2016 tentang', 0, 0, 'L');
        // $pdf->Cell(85, 4, @strtoupper($rs[0]->namajabatan), 0, 1, 'C');
        // $pdf->Cell(21, 4, '', 0, 0, 'L');
        // $pdf->Cell(84, 4, 'Nomor Klatur Jabatan Pelaksanan bagi PNS', 0, 0, 'L');
        // $pdf->Cell(85, 4, '', 0, 1, 'C');
        // $pdf->Cell(21, 4, '', 0, 0, 'L');
        // $pdf->Cell(84, 4, 'di Lingkungan Instansi Pemerintah.', 0, 0, 'L');
        // $pdf->Cell(85, 4, '', 0, 1, 'C');
        // $pdf->Cell(18, 4, '', 0, 0, 'L');
        // $pdf->Cell(3, 4, '-', 0, 0, 'L');
        // $pdf->Cell(84, 4, 'Peta Jabatan Formulir 2 harus sama dengan', 0, 0, 'L');
        // $pdf->Cell(85, 4, '', 0, 1, 'C');
        // $pdf->Cell(21, 4, '', 0, 0, 'L');
        // $pdf->Cell(84, 4, 'peta jabatan Formulir 1.', 0, 0, 'L');
        // $pdf->Cell(85, 4, '', 0, 1, 'C');
        // $pdf->Cell(21, 4, '', 0, 0, 'L');
        // $pdf->Cell(84, 4, '', 0, 0, 'L');
        // $pdf->Cell(85, 4, '(Nama Pemangku Jabatan)', 0, 1, 'C');
        // $pdf->Cell(21, 4, '', 0, 0, 'L');
        // $pdf->Cell(84, 4, '', 0, 0, 'L');
        // $pdf->Cell(85, 4, 'NIP. ', 0, 1, 'C');
    }else{
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(200, 9, 'Data tidak ditemukan.', 0, 1, 'C');
    }

    $pdf->Output('Analisis Kebutuhan DIklat '.\Input::get('idskpd').' '.formatBulan(\Input::get('periode_bulan')).' '.\Input::get('periode_tahun').'.pdf', 'I');
?>
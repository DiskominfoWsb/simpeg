<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petajab extends Model {

  protected $guarded = array();
  
  protected $table = "tr_petajab";

  public static $rules = array(
            'periode' => 'required',
    'idskpd' => 'required',
  );

  public function scopeSort($query)
  {
        return $query
              ->orderBy('tr_petajab.idskpd','asc')
              ->orderBy('tr_petajab.idjabjbt','desc')
              ->orderBy('a_tugasdokter.tugasdokter','desc')
              ->orderBy('a_matkulpel.matkulpel','desc')
              ->orderBy('a_jabfung.idjabfung','desc')
              ->orderBy('a_jabfung.kelas_jabatan','desc')
              ->orderBy('a_jabfungum.idjabfungum','desc')
              ->orderBy('a_jabfungum.kelas_jabatan','desc')
              ->orderBy('kelasjab','desc');
  }

  public static function kebutuhanJabatan($idskpd, $periode_bulan, $periode_tahun)
  {
    return \App\Models\Petajab::leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'), 'tr_petajab.idskpd', '=', 'skpd.idskpd')
                  ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
                  ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                  ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tkpendid as a_tkpendid'), 'skpd.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                  ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jenjab as a_jenjab'), 'tr_petajab.idjenjab','=','a_jenjab.idjenjab')
                  ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabasn as a_jabasn'), 'tr_petajab.idjenjab','=','a_jabasn.idjabasn')
                  ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_matkulpel as a_matkulpel'), 'tr_petajab.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
                  ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tugasdokter as a_tugasdokter'), 'tr_petajab.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                  ->select(\DB::raw('tr_petajab.*, a_matkulpel.matkulpel, a_tugasdokter.tugasdokter'),
                  \DB::raw('IF(tr_petajab.idjenjab>4,skpd.jab,IF(tr_petajab.idjenjab=2,a_jabfung.jabfung,IF(tr_petajab.idjenjab=3,a_jabfungum.jabfungum,""))) as jab'),
                  \DB::raw('IF(tr_petajab.idjenjab>4,skpd.kelas_jabatan,IF(tr_petajab.idjenjab=2,a_jabfung.kelas_jabatan,IF(tr_petajab.idjenjab=3,a_jabfungum.kelas_jabatan,""))) as kelasjab'),
                  \DB::raw('IF(tr_petajab.idjenjab>4,skpd.idtkpendid,IF(tr_petajab.idjenjab=2,a_jabfung.idtkpendid,IF(tr_petajab.idjenjab=3,a_jabfungum.idtkpendid,""))) as idtkpendidjab'),
                  \DB::raw('IF(tr_petajab.idjenjab>4,skpd.idjenjurusan,IF(tr_petajab.idjenjab=2,a_jabfung.idjenjurusan,IF(tr_petajab.idjenjab=3,a_jabfungum.idjenjurusan,""))) as idjenjurusanjab'),
                  \DB::raw('IF(tr_petajab.idjenjab>4,skpd.idrumpunpendid,IF(tr_petajab.idjenjab=2,a_jabfung.idrumpunpendid,IF(tr_petajab.idjenjab=3,a_jabfungum.idrumpunpendid,""))) as idrumpunpendidjab'),
                  \DB::raw('IF(tr_petajab.idjenjab>4,a_jabasn.jabasn,IF(tr_petajab.idjenjab=2,a_jenjab.jenjab,IF(tr_petajab.idjenjab=3,a_jenjab.jenjab,""))) as jenjabatan'))
                  ->where('periode_bulan', '=', $periode_bulan)
                  ->where('periode_tahun', '=', $periode_tahun)
                  ->where('tr_petajab.idskpd','like',''.$idskpd.'%')
                  ->sort()
                  ->get();
  }

  public static function petaJabatan($idskpd, $periode_bulan, $periode_tahun)
  {
    return \App\Models\Petajab::leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'), 'tr_petajab.idskpd', '=', 'skpd.idskpd')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jenjab as a_jenjab'), 'tr_petajab.idjenjab','=','a_jenjab.idjenjab')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabasn as a_jabasn'), 'tr_petajab.idjenjab','=','a_jabasn.idjabasn')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_matkulpel as a_matkulpel'), 'tr_petajab.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tugasdokter as a_tugasdokter'), 'tr_petajab.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
            ->select(\DB::raw('tr_petajab.*, a_matkulpel.matkulpel, a_tugasdokter.tugasdokter'),
            \DB::raw('IF(tr_petajab.idjenjab>4,skpd.kelas_jabatan,IF(tr_petajab.idjenjab=2,a_jabfung.kelas_jabatan,IF(tr_petajab.idjenjab=3,a_jabfungum.kelas_jabatan,"-"))) as kelasjab'),
            \DB::raw('IF(tr_petajab.idjenjab>4,a_jabasn.jabasn,IF(tr_petajab.idjenjab=2,a_jenjab.jenjab,IF(tr_petajab.idjenjab=3,a_jenjab.jenjab,"-"))) as jenjabatan'))
            ->where('periode_bulan', '=', $periode_bulan)
            ->where('periode_tahun', '=', $periode_tahun)
            ->where('tr_petajab.idskpd','like',''.$idskpd.'%')
            ->sort()            
            ->get();
  }

   public static function banyakOrang($id = null){
      $petajab = \App\Models\Petajab::find($id);
      $rs = 0;

      if(!empty($petajab)){
        $where = "idskpd = '".$petajab->idskpd."' and idjenkedudupeg NOT IN ('99','21')";

        if($petajab->idjenjab !=0){ 
            // yang sudah kepala sekolah, tidak dihitung lagi sebagai guru
            $where .= " and iskepsek != 1";
        }

        if($petajab->idjenjab >= 20){
            $where .= " and idjenjab > '4' and idjabjbt = '".$petajab->idjabjbt."'";
        } else if($petajab->idjenjab == 2){
            if(substr($petajab->idjabfung, 0,3) == '300'){ //004
                  $where .= ' and ((idjenjab = "'.$petajab->idjenjab.'" and idjabfung = "'.$petajab->idjabfung.'") or (idjenjab = "3" and idjabproyeksi = "'.$petajab->idjabfung.'"))  and idmatkulpel = "'.$petajab->idmatkulpel.'"';
            } else if(substr($petajab->idjabfung, 0,3) == '220'){ //005
                  $where .= ' and ((idjenjab = "'.$petajab->idjenjab.'" and idjabfung = "'.$petajab->idjabfung.'") or (idjenjab = "3" and idjabproyeksi = "'.$petajab->idjabfung.'"))  and idtugasdokter = "'.$petajab->idtugasdokter.'"';
            } else {
                  $where .= ' and ((idjenjab = "'.$petajab->idjenjab.'" and idjabfung = "'.$petajab->idjabfung.'") or (idjenjab = "3" and idjabproyeksi = "'.$petajab->idjabfung.'")) ';
            }
        } else if($petajab->idjenjab == 3){
                  $where .= " and idjenjab = '".$petajab->idjenjab."' and idjabfungum = '".$petajab->idjabfungum."'";
        } else if($petajab->idjenjab == 0){
                  // $where .= " and idtugasgurudosen = '1'" ;
                  $where .= " and iskepsek = 1" ;
        }else{
          return 0;
        }
      }

      $rs = \DB::connection('kepegawaian')->table('tb_01')->select(\DB::raw('count(nip) as banyakorang'))->whereRaw($where)->first();
      
      return $rs;
    }

    public static function comboExisting($idjenjab="",$idskpd="",$idjabatan="",$idmatkulpel="",$idtugasdokter=""){
        
        $where = "idskpd = '".$idskpd."' and idjenkedudupeg NOT IN ('99','21')";

        if($idjenjab !=0){ 
            // yang sudah kepala sekolah, tidak dihitung lagi sebagai guru
            $where .= " and iskepsek != 1";
        }

        if($idjenjab >= 20){
            $where .= " and idjenjab > '4' and idjabjbt = '".$idjabatan."'";
        } else if($idjenjab == 2){
            if(substr($idjabatan, 0,3) == '300'){ //004
                  $where .= ' and idjenjab = "'.$idjenjab.'" and idjabfung = "'.$idjabatan.'" and idmatkulpel = "'.$idmatkulpel.'"';
            } else if(substr($idjabatan, 0,3) == '220'){ //005
                  $where .= ' and idjenjab = "'.$idjenjab.'" and idjabfung = "'.$idjabatan.'" and idtugasdokter = "'.$idtugasdokter.'"';
            } else {
                  $where .= " and idjenjab = '".$idjenjab."' and idjabfung = '".$idjabatan."'";
            }            
        } else if($idjenjab == 3){
                  $where .= " and idjenjab = '".$idjenjab."' and idjabfungum = '".$idjabatan."'";
        } else if($idjenjab == 0){
                  // $where .= " and idtugasgurudosen = '1'" ;
                  $where .= " and iskepsek = 1" ;
        }

        $rs = \DB::connection('kepegawaian')->table('tb_01')->select(\DB::raw('count(nip) as banyakorang'))->whereRaw($where)->first();

        if(!empty($rs)){
            if($rs->banyakorang > 0){
                  return $rs->banyakorang;
            } else {
                  return $rs->banyakorang;
            }    
        }
    }


    public function countPegawai()
    {
      $where = "idskpd = '".$this->idskpd."' and idjenkedudupeg NOT IN ('99','21')";

          if($this->idjenjab !=0){ 
              // yang sudah kepala sekolah, tidak dihitung lagi sebagai guru
              $where .= " and iskepsek != 1";
          }

          if($this->idjenjab >= 20){
              $where .= " and idjenjab > '4' and idjabjbt = '".$this->idjabjbt."'";
          } else if($this->idjenjab == 2){
              if(substr($this->idjabfung, 0,3) == '300'){ //004
                    $where .= ' and idjenjab = "'.$this->idjenjab.'" and idjabfung = "'.$this->idjabfung.'" and idmatkulpel = "'.$this->idmatkulpel.'"';
              } else if(substr($this->idjabfung, 0,3) == '220'){ //005
                    $where .= ' and idjenjab = "'.$this->idjenjab.'" and idjabfung = "'.$this->idjabfung.'" and idtugasdokter = "'.$this->idtugasdokter.'"';
              } else {
                    $where .= " and idjenjab = '".$this->idjenjab."' and idjabfung = '".$this->idjabfung."'";
              }            
          } else if($this->idjenjab == 3){
                    $where .= " and idjenjab = '".$this->idjenjab."' and idjabfungum = '".$this->idjabfungum."'";
          } else if($this->idjenjab == 0){
                    // $where .= " and idtugasgurudosen = '1'" ;
                    $where .= " and iskepsek = 1" ;
          }

          $rs = \DB::connection('kepegawaian')->table('tb_01')->select(\DB::raw('count(nip) as banyakorang'))->whereRaw($where)->first();
          if(!empty($rs)){
            return $rs->banyakorang;
          }
    }

    public function pegawaiPemangku()
    {
      $where = "idskpd = '".$this->idskpd."' and idjenkedudupeg NOT IN ('99','21')";

          if($this->idjenjab !=0){ 
              // yang sudah kepala sekolah, tidak dihitung lagi sebagai guru
              $where .= " and iskepsek != 1";
          }

          if($this->idjenjab >= 20){
              $where .= " and idjenjab > '4' and idjabjbt = '".$this->idjabjbt."'";
          } else if($this->idjenjab == 2){
              if(substr($this->idjabfung, 0,3) == '300'){ //004
                    $where .= ' and idjenjab = "'.$this->idjenjab.'" and idjabfung = "'.$this->idjabfung.'" and idmatkulpel = "'.$this->idmatkulpel.'"';
              } else if(substr($this->idjabfung, 0,3) == '220'){ //005
                    $where .= ' and idjenjab = "'.$this->idjenjab.'" and idjabfung = "'.$this->idjabfung.'" and idtugasdokter = "'.$this->idtugasdokter.'"';
              } else {
                    $where .= " and idjenjab = '".$this->idjenjab."' and idjabfung = '".$this->idjabfung."'";
              }            
          } else if($this->idjenjab == 3){
                    $where .= " and idjenjab = '".$this->idjenjab."' and idjabfungum = '".$this->idjabfungum."'";
          } else if($this->idjenjab == 0){
                    // $where .= " and idtugasgurudosen = '1'" ;
                    $where .= " and iskepsek = 1" ;
          }

         return \DB::connection('kepegawaian')->table('tb_01')->whereRaw($where)->get();
         
    }

    public static function getPemangkuByIdPeta($id=""){
      $peta = \App\Models\Petajab::find($id);
      
      $where = "idskpd = '".$peta->idskpd."' and idjenkedudupeg NOT IN ('99','21')";

        if($peta->idjenjab !=0){ 
            // yang sudah kepala sekolah, tidak dihitung lagi sebagai guru
            $where .= " and iskepsek != 1";
        }

        if($peta->idjenjab >= 20){
            $where .= " and idjenjab > '4' and idjabjbt = '".$peta->idjabjbt."'";
        } else if($peta->idjenjab == 2){
            if(substr($peta->idjabfung, 0,3) == '300'){ //004
                  $where .= ' and idjenjab = "'.$peta->idjenjab.'" and idjabfung = "'.$peta->idjabfung.'" and idmatkulpel = "'.$peta->idmatkulpel.'"';
            } else if(substr($peta->idjabfung, 0,3) == '220'){ //005
                  $where .= ' and idjenjab = "'.$peta->idjenjab.'" and idjabfung = "'.$peta->idjabfung.'" and idtugasdokter = "'.$peta->idtugasdokter.'"';
            } else {
                  $where .= " and idjenjab = '".$peta->idjenjab."' and idjabfung = '".$peta->idjabfung."'";
            }            
        } else if($peta->idjenjab == 3){
                  $where .= " and idjenjab = '".$peta->idjenjab."' and idjabfungum = '".$peta->idjab."'";
        } else if($peta->idjenjab == 0){
                  // $where .= " and idtugasgurudosen = '1'" ;
                  $where .= " and iskepsek = 1" ;
        }

        $rs = \DB::connection('kepegawaian')->table('tb_01')->whereRaw($where);

        if(!empty($rs)){
          return $rs;
        }
    }
    
    public static function jabatanSkpdNonStruktur($idskpd, $periode_bulan, $periode_tahun){
      return \App\Models\Petajab::select('tr_petajab.*','a_matkulpel.matkulpel', 'a_tugasdokter.tugasdokter',
              \DB::raw('IF(tr_petajab.idjenjab>4,skpd.kelas_jabatan,IF(tr_petajab.idjenjab=2,a_jabfung.kelas_jabatan,IF(tr_petajab.idjenjab=3,a_jabfungum.kelas_jabatan,"-"))) as kelasjab'),
              \DB::raw('IF(tr_petajab.idjenjab>4,a_jabasn.jabasn,IF(tr_petajab.idjenjab=2,a_jenjab.jenjab,IF(tr_petajab.idjenjab=3,a_jenjab.jenjab,"-"))) as jenjabatan'))
              ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'), 'tr_petajab.idskpd', '=', 'skpd.idskpd')
              ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
              ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
              ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jenjab as a_jenjab'), 'tr_petajab.idjenjab','=','a_jenjab.idjenjab')
              ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabasn as a_jabasn'), 'tr_petajab.idjenjab','=','a_jabasn.idjabasn')
              ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_matkulpel as a_matkulpel'), 'tr_petajab.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
              ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tugasdokter as a_tugasdokter'), 'tr_petajab.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
              ->where('periode_bulan', '=', $periode_bulan)
              ->where('periode_tahun', '=', $periode_tahun)
              ->where('tr_petajab.idskpd','=',$idskpd)
              ->where('tr_petajab.idjabjbt','=','')
              ->sort()            
              ->get();
    }

    public static function proyeksiPertahun($idskpd){
        return \App\Models\Petajab::select(\DB::raw("a_matkulpel.matkulpel, a_tugasdokter.tugasdokter,tr_petajab.idskpd, tr_petajab.namajabatan, a_skpd.skpd, tr_petajab.idjenjab, tr_petajab.idjabjbt, tr_petajab.idjabfung, tr_petajab.idjabfungum, tr_petajab.abk as abk,
          IF(left(tr_petajab.idjabfung,3) = '220',concat(tr_petajab.idjabfung, a_tugasdokter.tugasdokter),IF(left(tr_petajab.idjabfung,3) = '300',concat(tr_petajab.idjabfung, a_matkulpel.matkulpel),tr_petajab.idjabfung)) AS fungsionaldokter,
            IF(tr_petajab.idjenjab>4, a_skpd.kelas_jabatan, IF(tr_petajab.idjenjab=2, a_jabfung.kelas_jabatan, IF(tr_petajab.idjenjab=3, a_jabfungum.kelas_jabatan, '-'))) AS kelasjab,
            IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, '-'))) AS idjabatan,
            SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt,1,0)) AS struktural,
            SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt AND a_skpd.jab_asn = 10,1,0)) AS eselon1,
            SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt AND a_skpd.jab_asn = 20,1,0)) AS eselon2,
            SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt AND a_skpd.jab_asn = 30,1,0)) AS eselon3,
            SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt AND a_skpd.jab_asn = 40,1,0)) AS eselon4,
            SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt AND a_skpd.jab_asn = 50,1,0)) AS eselon5,
            SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd,1,0)) AS fungsional,
            SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd AND a_jabfung.tingkat2 = 'Pemula',1,0)) AS pemula,
            SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd AND a_jabfung.tingkat2 = 'Terampil',1,0)) AS terampil,
            SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd AND a_jabfung.tingkat2 = 'Mahir',1,0)) AS mahir,
            SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd AND a_jabfung.tingkat2 = 'Penyelia',1,0)) AS penyelia,
            SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd AND a_jabfung.tingkat2 = 'Pertama',1,0)) AS pertama,
            SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd AND a_jabfung.tingkat2 = 'Muda',1,0)) AS muda,
            SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd AND a_jabfung.tingkat2 = 'Madya',1,0)) AS madya,
            SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd AND a_jabfung.tingkat2 = 'Utama',1,0)) AS utama,
            SUM(IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = tb_01.idjabfungum AND tr_petajab.idskpd = tb_01.idskpd ,1,0)) AS pelaksana,
            (SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt AND tr_petajab.idskpd = tb_01.idskpd,1,0)) 
              + SUM(IF(((tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung) OR (tb_01.idjenjab = 3 and tb_01.idjabproyeksi = tr_petajab.idjabfung and tb_01.idjabproyeksi != '')) AND tr_petajab.idskpd = tb_01.idskpd, 
                IF(LEFT(tr_petajab.idjabfung,3) = '300',
                  IF(tr_petajab.idmatkulpel = tb_01.idmatkulpel AND tb_01.iskepsek != 1,1,0),
                  IF(LEFT(tr_petajab.idjabfung,3) = '220',
                    IF(tr_petajab.idtugasdokter = tb_01.idtugasdokter,1,0),
                    1)),
                0))
              + SUM(IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = tb_01.idjabfungum AND tr_petajab.idskpd = tb_01.idskpd ,1,0))
              + SUM(IF(tr_petajab.idjenjab = 0 AND tb_01.iskepsek=1 AND tr_petajab.idskpd = tb_01.idskpd,1,0))
              ) AS jumlahreal,
            IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = a_skpd.idskpd,tr_petajab.abk,0) AS akstruktural,
            IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = a_skpd.idskpd AND a_skpd.jab_asn = 10,tr_petajab.abk,0) AS abkeselon1,
            IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = a_skpd.idskpd AND a_skpd.jab_asn = 20,tr_petajab.abk,0) AS abkeselon2,
            IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = a_skpd.idskpd AND a_skpd.jab_asn = 30,tr_petajab.abk,0) AS abkeselon3,
            IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = a_skpd.idskpd AND a_skpd.jab_asn = 40,tr_petajab.abk,0) AS abkeselon4,
            IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = a_skpd.idskpd AND a_skpd.jab_asn = 50,tr_petajab.abk,0) AS abkeselon5,
            IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd,tr_petajab.abk,0) AS akfungsional,
            IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd AND a_jabfung.tingkat2 = 'Pemula',tr_petajab.abk,0) AS abkpemula,
            IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd AND a_jabfung.tingkat2 = 'Terampil',tr_petajab.abk,0) AS abkterampil,
            IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd AND a_jabfung.tingkat2 = 'Mahir',tr_petajab.abk,0) AS abkmahir,
            IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd AND a_jabfung.tingkat2 = 'Penyelia',tr_petajab.abk,0) AS abkpenyelia,
            IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd AND a_jabfung.tingkat2 = 'Pertama',tr_petajab.abk,0) AS abkpertama,
            IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd AND a_jabfung.tingkat2 = 'Muda',tr_petajab.abk,0) AS abkmuda,
            IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd AND a_jabfung.tingkat2 = 'Madya',tr_petajab.abk,0) AS abkmadya,
            IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd AND a_jabfung.tingkat2 = 'Utama',tr_petajab.abk,0) AS abkutama,
            IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = a_jabfungum.idjabfungum AND tr_petajab.idskpd = a_skpd.idskpd,tr_petajab.abk,0) AS akpelaksana,
            SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, '-')))) 
                = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2,tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, '-')))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup,IF((tb_01.idjenjab = 2),a_jabfung.pens,IF((tb_01.idjenjab = 3),a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),'01'))=YEAR(NOW()) + 1,1,0)) AS pensiun
                "))
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd AS a_skpd'), 'tr_petajab.idskpd', '=', 'a_skpd.idskpd')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_matkulpel as a_matkulpel'), 'tr_petajab.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tugasdokter as a_tugasdokter'), 'tr_petajab.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung AS a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum AS a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.tb_01 AS tb_01'), function($join) use ($idskpd) {
            $join->on(\DB::raw('
              (
                (
                  (IF(tr_petajab.idjenjab>4, 
                      tr_petajab.idjabjbt, 
                      IF(tr_petajab.idjenjab=2, 
                          tr_petajab.idjabfung, 
                          IF(tr_petajab.idjenjab=3, 
                              tr_petajab.idjabfungum,
                              "-"))))
                  = (IF(tb_01.idjenjab>4,
                     tb_01.idjabjbt,
                     IF(tb_01.idjenjab=2, 
                         tb_01.idjabfung, 
                         IF(tb_01.idjenjab=3, 
                             tb_01.idjabfungum, 
                             "--"))))
                  OR (tr_petajab.idjenjab=2 and tb_01.idjenjab = 3 and tb_01.idjabproyeksi = tr_petajab.idjabfung and tb_01.idjabproyeksi != "")
                  OR (tr_petajab.idjenjab=0 and tb_01.iskepsek=1)
                )
              ) AND tb_01.idskpd LIKE "'.$idskpd.'%" and tb_01.idjenkedudupeg != "99" and tb_01.idjenkedudupeg != "21"') ,\DB::raw(''),\DB::raw(''));
          })
          ->where('tr_petajab.idskpd', 'LIKE', $idskpd.'%')
          ->groupBy('tr_petajab.idjabfungum', 'tr_petajab.idskpd', 'fungsionaldokter')
          ->sort()
          ->get();
    }

      public static function proyeksiPer5Tahun($idskpd){
        return \App\Models\Petajab::select('tr_petajab.idskpd', 'tr_petajab.namajabatan', 'tr_petajab.idjenjab', 'tr_petajab.idjabjbt', 'tr_petajab.idjabfung', 'tr_petajab.idjabfungum', 'a_skpd.skpd','a_matkulpel.matkulpel', 'a_tugasdokter.tugasdokter',
            \DB::raw('IF(tr_petajab.idjenjab>4, a_skpd.kelas_jabatan, IF(tr_petajab.idjenjab=2, a_jabfung.kelas_jabatan, IF(tr_petajab.idjenjab=3, a_jabfungum.kelas_jabatan, "-"))) AS kelasjab'),
            // \DB::raw('IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-"))) AS idjabatan'),
            // \DB::raw('SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt,1,0)) AS struktural'),
            // \DB::raw('SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd,1,0)) AS fungsional'),
            // \DB::raw('SUM(IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = tb_01.idjabfungum AND tr_petajab.idskpd = tb_01.idskpd ,1,0)) AS pelaksana'),
            \DB::raw('(SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt,1,0)) + SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd,1,0)) + SUM(IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = tb_01.idjabfungum AND tr_petajab.idskpd = tb_01.idskpd,1,0))) AS jumlahreal'),
            // \DB::raw('IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = a_skpd.idskpd,tr_petajab.abk,0) AS akstruktural'),
            // \DB::raw('IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd,tr_petajab.abk,0) AS akfungsional'),
            // \DB::raw('IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = a_jabfungum.idjabfungum AND tr_petajab.idskpd = a_skpd.idskpd,tr_petajab.abk,0) AS akpelaksana'),
            \DB::raw('(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = a_skpd.idskpd,tr_petajab.abk,0) + IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd,tr_petajab.abk,0) + IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = a_jabfungum.idjabfungum AND tr_petajab.idskpd = a_skpd.idskpd,tr_petajab.abk,0)) AS jumlahak'),
            \DB::raw('SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-")))) = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup, IF((tb_01.idjenjab = 2), a_jabfung.pens, IF((tb_01.idjenjab = 3), a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),"01"))=YEAR(NOW()),1,0)) AS pensiun1'),
            \DB::raw('SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-")))) = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup, IF((tb_01.idjenjab = 2), a_jabfung.pens, IF((tb_01.idjenjab = 3), a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),"01"))=YEAR(NOW())+1,1,0)) AS pensiun2'),
            \DB::raw('SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-")))) = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup, IF((tb_01.idjenjab = 2), a_jabfung.pens, IF((tb_01.idjenjab = 3), a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),"01"))=YEAR(NOW())+2,1,0)) AS pensiun3'),
            \DB::raw('SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-")))) = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup, IF((tb_01.idjenjab = 2), a_jabfung.pens, IF((tb_01.idjenjab = 3), a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),"01"))=YEAR(NOW())+3,1,0)) AS pensiun4'),
            \DB::raw('SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-")))) = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup, IF((tb_01.idjenjab = 2), a_jabfung.pens, IF((tb_01.idjenjab = 3), a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),"01"))=YEAR(NOW())+4,1,0)) AS pensiun5'))
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd'), 'tr_petajab.idskpd', '=', 'a_skpd.idskpd')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.tb_01'), function($join) use ($idskpd) {
            $join->on(\DB::raw('(IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-"))))=(IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-"))))') ,\DB::raw(''),\DB::raw(''))
              ->where('tb_01.idskpd', 'LIKE', $idskpd.'%')
              ->whereNotIn('tb_01.idjenkedudupeg',['99','21']);
          })
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_matkulpel'), 'tr_petajab.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tugasdokter as a_tugasdokter'), 'tr_petajab.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
          ->where('tr_petajab.idskpd', 'LIKE', $idskpd.'%')
          ->groupBy('tr_petajab.idskpd', 'tr_petajab.idjabfung', 'tr_petajab.idjabfungum')
          ->sort()
          ->get();
    }


    public static function proyeksiPer5Tahun_old($idskpd){
        return \App\Models\Petajab::select('a_jabfung.kelas_jabatan','a_jabfungum.kelas_jabatan','tr_petajab.idskpd', 'tr_petajab.namajabatan', 'tr_petajab.idjenjab', 'tr_petajab.idjabjbt', 'tr_petajab.idjabfung', 'tr_petajab.idjabfungum', 'a_skpd.skpd','a_matkulpel.matkulpel', 'a_tugasdokter.tugasdokter',
            \DB::raw('IF(left(tr_petajab.idjabfung,3) = "220",concat(tr_petajab.idjabfung, a_tugasdokter.tugasdokter),IF(left(tr_petajab.idjabfung,3) = "300",concat(tr_petajab.idjabfung, a_matkulpel.matkulpel),tr_petajab.idjabfung)) AS fungsionaldokter'),
            \DB::raw('IF(tr_petajab.idjenjab>4, a_skpd.kelas_jabatan, IF(tr_petajab.idjenjab=2, a_jabfung.kelas_jabatan, IF(tr_petajab.idjenjab=3, a_jabfungum.kelas_jabatan, "-"))) AS kelasjab'),
            // \DB::raw('IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-"))) AS idjabatan'),
            // \DB::raw('SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt,1,0)) AS struktural'),
            // \DB::raw('SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd,1,0)) AS fungsional'),
            // \DB::raw('SUM(IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = tb_01.idjabfungum AND tr_petajab.idskpd = tb_01.idskpd ,1,0)) AS pelaksana'),
            \DB::raw('(SUM(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = tb_01.idjabjbt,1,0)) + SUM(IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = tb_01.idjabfung AND tr_petajab.idskpd = tb_01.idskpd,1,0)) + SUM(IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = tb_01.idjabfungum AND tr_petajab.idskpd = tb_01.idskpd,1,0))) AS jumlahreal'),      
            // \DB::raw('IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = a_skpd.idskpd,tr_petajab.abk,0) AS akstruktural'),
            // \DB::raw('IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd,tr_petajab.abk,0) AS akfungsional'),
            // \DB::raw('IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = a_jabfungum.idjabfungum AND tr_petajab.idskpd = a_skpd.idskpd,tr_petajab.abk,0) AS akpelaksana'),
            \DB::raw('(IF(tr_petajab.idjenjab > 4 AND tr_petajab.idjabjbt = a_skpd.idskpd,tr_petajab.abk,0) + IF(tr_petajab.idjenjab = 2 AND tr_petajab.idjabfung = a_jabfung.idjabfung AND tr_petajab.idskpd = a_skpd.idskpd,tr_petajab.abk,0) + IF(tr_petajab.idjenjab = 3 AND tr_petajab.idjabfungum = a_jabfungum.idjabfungum AND tr_petajab.idskpd = a_skpd.idskpd,tr_petajab.abk,0)) AS jumlahak'),
            \DB::raw('SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-")))) = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup, IF((tb_01.idjenjab = 2), a_jabfung.pens, IF((tb_01.idjenjab = 3), a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),"01"))=YEAR(NOW()),1,0)) AS pensiun1'),
            \DB::raw('SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-")))) = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup, IF((tb_01.idjenjab = 2), a_jabfung.pens, IF((tb_01.idjenjab = 3), a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),"01"))=YEAR(NOW())+1,1,0)) AS pensiun2'),
            \DB::raw('SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-")))) = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup, IF((tb_01.idjenjab = 2), a_jabfung.pens, IF((tb_01.idjenjab = 3), a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),"01"))=YEAR(NOW())+2,1,0)) AS pensiun3'),
            \DB::raw('SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-")))) = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup, IF((tb_01.idjenjab = 2), a_jabfung.pens, IF((tb_01.idjenjab = 3), a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),"01"))=YEAR(NOW())+3,1,0)) AS pensiun4'),
            \DB::raw('SUM(IF((IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-")))) = (IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) AND tr_petajab.idskpd = tb_01.idskpd AND YEAR(CONCAT(LEFT(((tb_01.tglhr + INTERVAL IF((tb_01.idjenjab > 4),a_skpd.bup, IF((tb_01.idjenjab = 2), a_jabfung.pens, IF((tb_01.idjenjab = 3), a_jabfungum.pens,58))) YEAR) + INTERVAL 1 MONTH),8),"01"))=YEAR(NOW())+4,1,0)) AS pensiun5'))
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd'), 'tr_petajab.idskpd', '=', 'a_skpd.idskpd')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
          ->leftjoin(\DB::Raw('(select tb_01.idskpd) idskpdss  from '.config('global.kepegawaian').'.tb_01'), function($join) use ($idskpd) {
            $join->on(\DB::raw('(IF(tr_petajab.idjenjab>4, tr_petajab.idjabjbt, IF(tr_petajab.idjenjab=2, tr_petajab.idjabfung, IF(tr_petajab.idjenjab=3, tr_petajab.idjabfungum, "-"))))=(IF(tb_01.idjenjab>4, tb_01.idjabjbt, IF(tb_01.idjenjab=2, tb_01.idjabfung, IF(tb_01.idjenjab=3, tb_01.idjabfungum, "-")))) and tb_01.idskpd LIKE "'.$idskpd.'%" and tb_01.idjenkedudupeg != "99" and tb_01.idjenkedudupeg != "21"') ,\DB::raw(''),\DB::raw(''))
              // ->where('tb_01.idskpd', 'LIKE', $idskpd.'%')
              // ->whereNotIn('tb_01.idjenkedudupeg',['99','21'])
            ;
          })
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_matkulpel'), 'tr_petajab.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
          ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tugasdokter as a_tugasdokter'), 'tr_petajab.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
          ->groupBy('tr_petajab.idskpd', 'tr_petajab.idjabfung', 'tr_petajab.idjabfungum','fungsionaldokter')
          ->where('tr_petajab.idskpd', 'LIKE', $idskpd.'%')
          ->sort()
          ->get();
    }

}

<?php
//============================>
namespace App\Http\Controllers;
//============================>
use Illuminate\Http\Request;
USE DB ;
use App\Models\Pegawai;
use App\Models\Potongan;
use App\Models\Absensi;

class pegawaicontroller extends Controller
{
    //==================================>
	
	public function page_daftar() {
		$jabatan = DB::table('tbl_jabatan')->get();
		$potongan = DB::table('tbl_potongan')->get();
		//===============================>
		$users = DB::table('tbl_pegawai')
					->join('tbl_jabatan', 'tbl_pegawai.idjabatan', '=', 'tbl_jabatan.id')
					->select(
						'tbl_pegawai.*' ,
						'tbl_jabatan.*' ,
						'tbl_pegawai.id as idpegawai' ,
						'tbl_jabatan.id as idjabatan'
					)
					->get();
        return view('page_daftar',
			[
				'users'=>$users	,
				'jabatan'=>$jabatan	,
				'potongan' => $potongan 
			]
		);
	}

	public function edit ($id){
		$jabatan = DB::table('tbl_jabatan')->get();
		$potongan = DB::table('tbl_potongan')->get();
		$pegawai = Pegawai::find($id);
		return view('update_pegawai',compact('pegawai','jabatan','potongan'));
	}

	public function tes(){
		return view('test');
	}

	

	public function update (Request $request){
		$a = Pegawai::where('id',$request->id)->update([
			
				'idjabatan' => $request->idjabatan ,
				'nama' => $request->nama ,
				'tgl' => $request->tgl ,
				'ttl' => $request->ttl ,
				'alamat' => $request->alamat ,
				'telp' => $request->telp 
		]); 
		return redirect()->back()->with(['success' => 'pegawai berhasil diupdate']);;
	}
	
	public function page_simpanpegawai( Request $request ){
		//==> Sebelum melakukan penyimpanan data . Cek Terlebih dahulu , rules yang berlaku
		//==> Informasi Jabatan Ada Pada Database .
		//==> Informasi Potongan Gadi Yang Di Simpan Tidak Boleh Double .

		$isSave = true ;
		
		//==> Cek Jika RFID Sudah Ada Pada Database . 
		$nDataPegawai = DB::table('tbl_pegawai')
							->where('tbl_pegawai.id' , $request->id )
							->count();


		//==> Cek Jika Jabatan Ada Di Database .
		$nDataJabatan = DB::table('tbl_jabatan')
							->where('tbl_jabatan.id' , $request->idjabatan )
							->count();

		//==> Cek Jika Potongan Gaji Tidak Bermasalah .
		$dataPotonganSiap = true ;
		$num = $request->counter ;
		for( $i = 0 ; $i <= (int)$num ; $i++ ){
			//===> cek jika TAG ada .
			$stat_ele = $request->input("jenispotongan-".$i ) !== null ;
			if( $stat_ele == true ){
				//==> Cek ID Jenis Potongan Di Database , apakah ada atau tidak .
				//==> Jika data potongan tidak di temukan di table , maka proses tidak bisa di lanjutkan . 
				//==> Jika data potongan di temukan , proses bisa di lanjutkan . 
				//==> Dapatkan ID Potongan :
				$id = $request->input("jenispotongan-".$i );
				$nDataPotongan = DB::table('tbl_potongan')
							->where('tbl_potongan.id' , $id )
							->count();
				if( $nDataPotongan == 0 ){
					$dataPotonganSiap = false ;
					break ;
				}
			}
		}

		//==> Jika Data Jabatan DI Temukan , maka lanjutkan proses penyimpanan .
		if( $nDataPegawai == 0 && $nDataJabatan > 0 && $dataPotonganSiap == false  ){

			

			// insert data ke table pegawai
			DB::table('tbl_pegawai')->insert([
				'id' => $request->id ,
				'idjabatan' => $request->idjabatan ,
				'nama' => $request->nama ,
				'tgl' => $request->tgl ,
				'ttl' => $request->ttl ,
				'alamat' => $request->alamat ,
				'telp' => $request->telp 
			]);
			//===============================> insert data ke potongan pegawai .
			//===> ambil informasi jumlah counter .
			//===> Temporary untuk menyimpan id data potongan , agar informasi tidak double .
			$data_ID = array("none");
			//===> Cek Jumlah Total Potongan .
			$num = $request->counter ;
			//===> Lakukan penyimpanan informasi satu persatu .
			for( $i = 0 ; $i <= (int)$num ; $i++ ){
				//===> cek jika TAG ada .
				$stat_ele = $request->input("jenispotongan-".$i ) !== null ;
				if( $stat_ele == true ){
					//==> Cek Terlebih dahulu , apakah informasi potongan ter duplikat .
					$dataTidakAda = false ;
					foreach( $data_ID as $item ){
						if( $item == $request->input("jenispotongan-".$i ) ){
							$dataTidakAda = true ;
							break ;
						}
					}

					$id = $request->input("jenispotongan-".$i );
					$nDataPotongan = DB::table('tbl_potongan')
								->where('tbl_potongan.id' , $id )
								->count();

					if( $dataTidakAda == false && $nDataPotongan > 0  ){
						array_push( $data_ID , $request->input("jenispotongan-".$i ) );
						DB::table('tbl_datapotongankaryawan')->insert([
							'idpegawai' => $request->id ,
							'idpotongan' => $request->input("jenispotongan-".$i )
						]);
					}
				}
			}
		}
		else{
			$isSave = false ;
		}
		//===============================>
		$jabatan = DB::table('tbl_jabatan')->get();
		$potongan = DB::table('tbl_potongan')->get();
		//===============================>
		$users = DB::table('tbl_pegawai')
					->join('tbl_jabatan', 'tbl_pegawai.idjabatan', '=', 'tbl_jabatan.id')
					->select(
						'tbl_pegawai.*' ,
						'tbl_jabatan.*' ,
						'tbl_pegawai.id as idpegawai' ,
						'tbl_jabatan.id as idjabatan'
					)
					->get();
        return view('page_daftar',
			[
				'users'=>$users	,
				'jabatan'=>$jabatan	,
				'potongan' => $potongan ,
				'isSave' => $isSave
			]
		);
	}
	
	public function page_deletepegawai( $id ){
		
		// DB::table('tbl_pegawai')->where('id', '=', $id)->delete();
		
		// DB::table('tbl_datapotongankaryawan')->where('idpegawai', '=', $id)->delete();
		$pegawai = Pegawai::find($id)->delete();
		$potongan= Potongan::where('idpegawai', $id)->delete();
		$pegawai = Absensi::where('idpegawai',$id)->delete();
		//===============================>
		$jabatan = DB::table('tbl_jabatan')->get();
		$potongan = DB::table('tbl_potongan')->get();
		//===============================>
		$users = DB::table('tbl_pegawai')
					->join('tbl_jabatan', 'tbl_pegawai.idjabatan', '=', 'tbl_jabatan.id')
					->select(
						'tbl_pegawai.*' ,
						'tbl_jabatan.*' ,
						'tbl_pegawai.id as idpegawai' ,
						'tbl_jabatan.id as idjabatan'
					)
					->get();
        return view('page_daftar',
			[
				'users'=>$users	,
				'jabatan'=>$jabatan	,
				'potongan' => $potongan 
			]
		);
	}
	
	public function page_updatepegawai( $id ){
		$users = DB::table('tbl_pegawai')
					->join('tbl_jabatan', 'tbl_pegawai.idjabatan', '=', 'tbl_jabatan.id')
					->select(
						'tbl_pegawai.*' ,
						'tbl_jabatan.*' ,
						'tbl_pegawai.id as idpegawai' ,
						'tbl_jabatan.id as idjabatan'
					)
					->where('tbl_pegawai.id' , $id )
					->get();
		//===============================>
		$jabatan = DB::table('tbl_jabatan')->get();
		$potongan = DB::table('tbl_potongan')->get();

        return view('page_update_pegawai',
			[
				'users'=>$users	,
				'jabatan'=>$jabatan	
			]
		);
	}
	
	public function page_updateitempegawai( Request $request ){
		// update data ke table potongan
		DB::table('tbl_pegawai')
			->where('id' , $request->id )
			->update(array(
				'idjabatan' => $request->idjabatan ,
				'nama' => $request->nama ,
				'tgl' => $request->tgl ,
				'ttl' => $request->ttl ,
				'alamat' => $request->alamat ,
				'telp' => $request->telp 
			));
			
		//===============================>
		$jabatan = DB::table('tbl_jabatan')->get();
		$potongan = DB::table('tbl_potongan')->get();
		//===============================>
		$users = DB::table('tbl_pegawai')
					->join('tbl_jabatan', 'tbl_pegawai.idjabatan', '=', 'tbl_jabatan.id')
					->select(
						'tbl_pegawai.*' ,
						'tbl_jabatan.*' ,
						'tbl_pegawai.id as idpegawai' ,
						'tbl_jabatan.id as idjabatan'
					)
					->get();
        return view('page_daftar',
			[
				'users'		=>	$users		,	
				'jabatan'	=>	$jabatan	,
				'potongan' 	=>	$potongan
			]
		);
	}
	//==================================>
	
	public function page_absensi() {
		//===============================>
		$jabatan = DB::table('tbl_jabatan')->get();
		$potongan = DB::table('tbl_potongan')->get();
		//===============================>
		$users = DB::table('tbl_pegawai')
					->join('tbl_jabatan', 'tbl_pegawai.idjabatan', '=', 'tbl_jabatan.id')
					->select(
						'tbl_pegawai.*' ,
						'tbl_jabatan.*' ,
						'tbl_pegawai.id as idpegawai' ,
						'tbl_jabatan.id as idjabatan'
					)
					->get();
		//===============================>
        return view('page_absensi'	,
			[
				'users'=>$users	,
				'jabatan'=>$jabatan	,
				'potongan' => $potongan
			]
		);
	}
	
	
	public function page_cari_data_absensi( Request $request){
		//===============================> ambil informasi get .
		$idpegawai = $request->idpegawai ;
		$tgl_awal = $request->tgl_awal ;
		$tgl_akhir = $request->tgl_akhir ;
		//===============================>
		$jabatan = DB::table('tbl_jabatan')->get();
		//===============================>
		$users = DB::table('tbl_pegawai')
					->join('tbl_jabatan', 'tbl_pegawai.idjabatan', '=', 'tbl_jabatan.id')
					->select(
						'tbl_pegawai.*' ,
						'tbl_jabatan.*' ,
						'tbl_pegawai.id as idpegawai' ,
						'tbl_jabatan.id as idjabatan'
					)
					->get();
		//=====> Ambil Informasi Absensi Pegawai .
		$absensi = DB::table('tbl_absensi')
			->join('tbl_pegawai', 'tbl_pegawai.id', '=', 'tbl_absensi.idpegawai')
			->join('tbl_jabatan', 'tbl_jabatan.id', '=', 'tbl_pegawai.idjabatan')
			->select(
						'tbl_absensi.*' ,
						'tbl_pegawai.*' ,
						'tbl_jabatan.*' ,
						'tbl_absensi.id as idabsensi' ,
						'tbl_pegawai.id as idpegawai' ,
						'tbl_jabatan.id as idjabatan' 
					)
			->where('tbl_absensi.idpegawai' , $idpegawai )
			->whereBetween('tbl_absensi.tanggal',array($tgl_awal,$tgl_akhir))
			->get();
			

			
		//=====> Panggil view .
		//===============================>
        return view('page_absensi'	,
			[
				'users'=>$users	,
				'jabatan'=>$jabatan	,
				'absensi'=>$absensi	
			]
		);
	}
	
	public function page_pengajian() {
		//===============================>
		$users = DB::table('tbl_pegawai')
					->join('tbl_jabatan', 'tbl_pegawai.idjabatan', '=', 'tbl_jabatan.id')
					->select(
						'tbl_pegawai.*' ,
						'tbl_jabatan.*' ,
						'tbl_pegawai.id as idpegawai' ,
						'tbl_jabatan.id as idjabatan'
					)
					->get();
		//===============================>
        return view('page_penggajian',
			[
				'users'=>$users	
			]);
	}

	public function page_bacapenggajian(Request $request){
		//==> Pada controller ini bertugas untuk melakukan pencarian informasi data penggajian dalam-
		//==> waktu 1 bulan . Jadi dalam waktu 1 bulan tersebut program akan , mencari informasi user-
		//==> Total Gaji yang di dapat . dengan rincian :
		//==> [ 1 ]. Gaji Pokok Dalam 1 Bulan .
		//==> [ 2 ]. Tunjangan Penggajian sesuai dengan jabatan .
		//==> [ 3 ]. Jumlah Jam lebur dalam 1 bulan .

		//==> Program juga akan mencari sumber informasi mengenai potongan gaji yang di dapat setiap bulan nya .
		//==> Pemotongan gaji ini adalah sesuai data yang akan mengurangi jumlah gaji total yang di-
		//==> dapat pegawai . dengan rincian :
		//==> [ 1 ]. Jumlah absensi / ketika user tidak masuk .
		//==> [ 2 ]. Potongan Gaji pegawai seperti [ Pajak dll ]

		//==> Prosedure pengambilan informasi data penggajian pegawai :
		//==> [ 1 ]. Koleksi data request untuk bulan penggajian yang di pilih.
		//==> [ 2 ]. Ambil informasi pegawai [ Gaji Pokok , Tunjangan dan Potongan Penggajian ]
		//==> [ 3 ]. Ambil data absensi perbulan dari user .
		//==> [ 4 ]. Proses data absensi untuk informasi [ absen masuk , jumlah jam lebur ].
		
		//======> koleksi dara dari request URL dari form penggajian user per-bulan . 
		$iduser	=	$request->idpegawai ; 	//==> Koleksi data "ID PEGAWAI" yang di pilih .
		$bulan 	=	$request->nobulan ;		//==> Koleksi data nama bulan yang di pilih .
		//====================> Generated informasi filter berdasarkan tanggal dan bulan yang telah dipilih.
		$tgl_awal 	= 	"2021-".$bulan."-01"	;
		$tgl_akhir	=	"2021-".$bulan."-31"	;

		//===============================>
		$users = DB::table('tbl_pegawai')
					->join('tbl_jabatan', 'tbl_pegawai.idjabatan', '=', 'tbl_jabatan.id')
					->select(
						'tbl_pegawai.*' ,
						'tbl_jabatan.*' ,
						'tbl_pegawai.id as idpegawai' ,
						'tbl_jabatan.id as idjabatan'
					)
					->get();
		//====================> Koleksi informsasi pegawai untuk [ gaji pokok , Tunjangan dan Potongan ]
		$pegawai  = DB::table('tbl_pegawai')
						->join('tbl_jabatan','tbl_jabatan.id','=','tbl_pegawai.idjabatan')
						->where('tbl_pegawai.id' , $iduser )
						->get();
		//=====> Ambil informasi gaji pokok user perbulan .
		//=====> dengan join data [ pegawai dengan data jabatan ] .
		//=====> data Gaji Pokok disini ada pada jabatan , karena gaji pokok di sesuakan dengan jabatan pada-
		//=====> pegawai atau setiap jabatan memiliki gaji pokok yang berbeda - beda .
		$gajipokok = DB::table('tbl_pegawai')
							->join('tbl_jabatan','tbl_jabatan.id','=','tbl_pegawai.idjabatan')
							->join('tbl_tunjangan','tbl_tunjangan.id','=','tbl_jabatan.idtunjangan')
							->select(
								'tbl_jabatan.gajipokok' ,
								'tbl_tunjangan.besar' 
							)
							->where('tbl_pegawai.id' , $iduser)
							->get();
		//=====> Ambil informasi tunjangan pegawai berdasarkan jabatan , jadi disini .
		//=====> Setiap jabatan memiliki tunjangan yang berbeda - beda .
		//=====> Setiap jabatan memiliki potongan gaji yang berbeda - beda .
		//=====> Jadi join table disini adalah [ Table Potongan Karyawan dengan data table table potongan].
		//=====> Table potongan karyawan : Berisi informasi koneksi id pegawai dengan data potongan gaji .
		//=====> Table Potongan : Berisi informasi jenis potongan yang ada , jadi ini adalah kumpulan data -
		//========================> potongan gaji .
		//=====> TUJUAN :
		//=====> Informasi data tunjangan dan data potongan gaji digunakan untuk mengumpulkan jumlah tambahan-
		//=====> biaya dari gaji pokok dan potongan gaji yang di terima oleh pegawai  .
		$data	 = DB::table('tbl_datapotongankaryawan')
							->join('tbl_potongan','tbl_potongan.id','=','tbl_datapotongankaryawan.idpotongan')
							->select(
									'tbl_potongan.jenis' ,
									'tbl_potongan.besar' ,
									'tbl_potongan.id as idpotongan'
							)
							->where('tbl_datapotongankaryawan.idpegawai' ,  $iduser )
							->get();
		//=====> Ambil Informasi Absensi Pegawai .
		//=====> Koleksi data ini untuk mengambil data infomasi tanggal masuk dan keluar pegawai mulai masuk kantor .
		//=====> data ini berasal dari data join dari table [ absensi , pegawai , jabatan ].
		//=====> Table absensi : pada table ini memiliki informasi absensi bulanan dengan data [ tgl , jam masuk , jam keluar ].
		//=====> lakukan pencarian berdasarkan dengan data pegawai tanggal awal dan tanggal akhir . 
		$absensi = DB::table('tbl_absensi')
			->where('tbl_absensi.idpegawai' , $iduser )
			->whereBetween('tbl_absensi.tanggal',array($tgl_awal,$tgl_akhir))
			->get();
		//=======> Proses data untuk pengambilan informasi jumlah masuk pegawai .
		//=======> jumlah total jam lembur .
		$absen = 0 ;
		$jamlembur = 0 ;
		$nominallembur = 0 ;
		//=======> Konversi ke array .
		$arr = $absensi->toArray();
		foreach( $arr as $item){
			//====> koleksi informasi data jam masuk .
			//====> koleksi informasi data jam keluar .
			$jammasuk 	= 	$item->jam_hadir 	;
			$jampulang	=	$item->jam_pulang 	;

			//===> Setelah kita mendapatkan informasi jam pada database . Untuk melakukan perhitungan-
			//===> jam lembur , maka untuk jam keluar harus lebih dari jam masuk per hari . 
			//===> contoh :
			//===> Jika total kerja perhari adalah 8 jam / Hari dan Setelah Absen Keluar -
			//===> Total Jam perhari adalah 14 jam. Maka program akan menganggap kelebihan-
			//===> kerja adalah lembur . 
			//===> hal diatas adalah hasil pengurangan dari jam keluar dengan jam masuk.
			//===> tetapi bisa saja hasil nya minus , dikarenakan pegawai pulang lebih awal . 
			//===> Jadi jika kedapatan minus , maka tidak dianggap atau di buang . 
			//===> hal ini bisa menyebabkan bug , karena nilai minus dari jam lembur . 

			//====> Hitung jumlah jam di kantor .
			$jam		=	 (strtotime($jampulang) - strtotime($jammasuk)) / 3600;
			//====> Jumlah total jam kerja perhari .
			$jamperhari = 	8 ;
			//====> Jadi jumlah jam lembur .
			$temp_jamlembur 	=	( $jam - $jamperhari );
			//====> Jika jam lembur lebih dari 1 , maka dianggap ada lembur di hari ini . 
			if( $temp_jamlembur > 0 ){
				$jamlembur += $temp_jamlembur ;
			}

			//====> Counter absen atau jumlah masuk kerja . 	
			$absen++ ;
		}
		//=======> Total Gaji Pokok Di Terima Selama Sebulan . 
		//=======> Total = Absen * Gaji Pokok Harian . 
		$TotalGajiSatuBulan = $absen * (int)$gajipokok[0]->gajipokok ;
		//=======> Total yang di dapat dari lembur .
		$nominallembur = (int)$jamlembur * 20000 ;
		//=======> Sekarang Hitung Gaji Total dengan menghitung semua informasi gaji . 
		//=======> parameter Gaji :
		//==> gaji Pokok , Tunjangan , Lebur |=> Gaji. 
		//==> Potongan Bulanan . 
		$totalgajiBulanan = 0 ;
		$totalgajiBulanan += $TotalGajiSatuBulan ;
		$totalgajiBulanan += (int)$gajipokok[0]->besar ;
		$totalgajiBulanan += (int)$nominallembur ;
		//===> sekaang lakukan potongan . 
		$npotongan = 0 ;
		$arr = $data->toArray();
		foreach( $arr as $item ){
			$potongan = $item->besar ;
			//===> lakukan pemotongan gaji . 
			$npotongan  += (int)$potongan ;
		}
		$totalgajiBulanan -= $npotongan ;
		//=======>
		return view(
			'page_penggajian' ,
			[
				'users'				=>	$users			,
				'pegawai' 			=> 	$pegawai		,
				'gaji'				=>	$gajipokok		,
				'data'				=>	$data			,
				'absensi'			=>	$absensi		,
				'jamlembur'			=>	$jamlembur		,
				'absen'				=>	$absen			,
				'nominallembur'		=>	$nominallembur  ,
				'totalgajiBulanan'	=>  $totalgajiBulanan
			]
		);
	}
}

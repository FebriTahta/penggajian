<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
USE DB ;

class umumcontroller extends Controller
{


	//==> Fungsi Test Code Akses Ke  ESP8266.
	public function testcom(){
		return '<html lang="en-US"><html><body>hello</body></html>';
	}


	//==> Fungsi untuk menghilangkan nilai rupiah dalam data format-
	//==> currency . 
	public function hapusFormatRupiah( $rupiah ){
		//==> Kode program untuk menghapus data format rupiah . 
		//==> Data [ "Rp" ] , [ "." ] , [ ",00" ] , [ "," ] 
		//==> Data [ " " ].
		$temp 	 = str_replace( "Rp"	, 	"" 	,	$rupiah	);
		$temp 	 = str_replace( "." 	, 	"" 	, 	$temp	);
		$temp 	 = str_replace( ",00" 	, 	"" 	, 	$temp	);
		$temp 	 = str_replace( ","		,	""	,	$temp	);
		$temp	 = str_replace(	" "		,	""	,	$temp	);
		//==> kembalikan kde kode pemanggil.
		return $temp ;
	
	}

	
	public function page_getDataUID(){
		//=================================>
		$db_res = DB::table('tbl_karturfid')
			->where('tbl_karturfid.id' , 1 )
			->get();
		//================================>
		echo json_encode( $db_res);
	}

    //=============================================================//
	//===> Fungsi untuk koneksi dengan module RFID dan Module Wifi ESP8266 . 
	//===> ESP8266 akan mengirimkan informasi parameter pada kode ini dengan data informasi -
	//===> UID dari kartu RFID dan parameter untuk identifikasi mode dari module . 
	//===> karena module RFID sendiri memiliki 2 mode . 
	//===> Mode dengan kode 0 , adalah mode pendaftaran . 
	//===> Mode dengan kode 1 , adalah mode absensi . 

	//===> Pada mode pendaftaran : ESp8266 akan mengirim informasi UID  Kartu RFID .
	//===> Pada mode ini data informasi akan disimpan pada table kartu , tujuan dari mode- 
	//===> adalah untuk di gunakan pada form pendaftaran , sehingga saat pendaftaran user -
	//===> hanya perlu meletakan kartu RFID pada perangkat dan UID secara otomatis akan-
	//===> muncul pada box input ID user . 
	
	//===> Pada mode absensi : ESP8266 akan mengiriman informasi UID kartu RFDI . 
	//===> Pada mode ini data informasi UID akan di proses untuk kebutuhan absensi user . 
	//===> Absensir dini adalah untuk kebutuhan absensi user saat masuk dan saat keluar.

	//===> contoh akses ke UID : http://192.168.1.86:9090/uploaddata/1223330,0
	public function page_uploaddata( $id ){


		//===> [ 1 ] Proses informasi dari parameter yang dikirimkan oleh ESP8266 . karena-
		//===> Parameter tersebut digabungkan dengan pembatas antar data adalah koma "," . 
		//===> jadi kita pisahkan terlebih dahulu . Gunakan fungsi explode dengan parameter-
		//===> Pembatas adalah koma .
		//===> contoh data : 123242432,1
		//===> Jika kita explode , maka data yang di dapat .
		//===> Index 0 = 123242432 |=> ini dalah data UID. 
		//===> Index 1 = 1 |=> ini adalah mode dari perangkat . 
		$arr  = explode( "," , $id );
		//===> Setelah itu pisahkan berdasarkan index . Index 0 adalah UID . 
		$user = $arr[0] ;
		//===> Parameter indx ke 1 adalah data mode .
		$mode = (int)$arr[1] ;
		
		//===> Inisial kan data tanggal , karena pada saat proses penyimpanan data tanggal-
		//===> ini diperlukan untuk identifikasi data absensi berdasarkan tanggal . 
		$date = date('y-m-d');

		//==========> mode 0 adallah mode pendaftaran . 
		//==========> Cek jika mode ini adalah mode pendaftaran .
		if( $mode == 0 ){

			//===> Proses pada mode pendaftaran adalah dengan di mulai cek data UID terlebih dahulu-
			//===> untuk mengetahui apakah kartu telah terdaftar atau belum . Jika memang sudah ter-
			//===> daftar ,maka kirim pesan balik dan data user ke module RFID . Jika belum terdaftar-
			//===> maka simpan pada table kartu RFID dan kirim informasi pada perangkat bahwa UID -
			//===> sukses di simpan.

			//===> Step - Step :
			//===> [1] Cek UID pada database . 
			//===> [2] Jika UID di temukan , maka kirim pesan ke Module RFID bahwa data sudah ada. 
			//===> [3] Jika data UID belum ada , maka simpan ke Table dan kirim pesan ke module-
			//====>		RFID data sukses disimpan .

			//====> [1] Proses pertama , cek informasi UID pada table pegawai . 
			$jumlah_user = DB::table('tbl_pegawai')
								->where('tbl_pegawai.id',$user)
								->count();

			//====> [2] Jika jumlah user sama dengan 0 atau tidak ada sama sekali pada database . 
			//====>		maka sudah dipastikan bahwa UID belum terdaftar . jadi lanjutkan ke proses-
			//====>		penyimpanan data pada table kartu RFID . 					
			if( $jumlah_user == 0 ){

				//====> [3] lalu simpan dalam database . 
				//====> karena hanya perlu satu data RFID pada table kartu  RFID , maka kita langsung -
				//====> menghapus semua data pada tble dan siap di isi dengan yang baru . 
				//====> Gunakan truncate().
				DB::table('tbl_karturfid')->truncate();
				//====> setelah itu simpan UID pada table RFID . 
				DB::table('tbl_karturfid')->insert(
					['value' => $user ]
				);
				//====> [4] Kirim pesan balik ke wemos ESP8266 . 
				//====> Setelah proses penyimpanan infromasi selesai , tahap terakhir adalah mengirim-
				//====> kembali informasi ke wemos ESP8266 . 
				echo "[success_daftar".",".$user.",".$arr[1]  . ",0]"; 
			}
			
			//====> [5] Kirim pesan ke wemos ESP8266 user ditemukan .
			//===> Jika informasi data user di temukan , maka kirim pesan ke wemos esp82266 . 
			//===> bahwa UID sudah ada dan tidak dapat di gunakan sebagai pendaftaran . 
			else{
			
				//====> yang pertama dilakukan adalah mengambil informasi data user pada database. 
				$user = DB::table('tbl_pegawai')
							->where('tbl_pegawai.id', $user )
							->get();
				echo "[found_daftar".",".$user[0]->nama.",".$arr[1]  . ",0]";

			}
		}
		else{
			//==========> Sekarang kita masuk kedalam proses absen data user . Pada fungsi ini-
			//==========> kita akan melakukan abensi data UID kartu RFID . 
			//==========> Untuk absensi sendiri kita memiliki 2 status yaitu :
			//==========> absensi untuk masuk dan absensi untuk keluar .
			//==========> jika dalam satu hari tidak ada absen terdaftar , maka dinyatakan masuk.
			//==========> Jika dalam satu hari terdeteksi absen masuk , maka dinyatakan keluar.
			//==========> pertama cek terlebih dahulu , apakah data UID telah terdaftar pada database.
		
			$jumlah_user = DB::table('tbl_pegawai')
								->where('tbl_pegawai.id' , $user )
								->count();
			$user_ = DB::table('tbl_pegawai')
								->where('tbl_pegawai.id' , $user )
								->get();
			//==========>
			$jumlah_absensi = DB::table('tbl_absensi')
								->where('tbl_absensi.idpegawai' , $user )
								->where('tbl_absensi.tanggal' , $date )
								->count();
			//====> Jika user ditemukan pada database , maka lanjutkan ke proses absensi . 					
			if( $jumlah_user > 0 ){
				//===> cek jika absensi user hari ini adalah 0 atau belum absensi sama sekali , maka-
				//===> user dianggap sedang melakukan kegiatan masuk . 
				if( $jumlah_absensi == 0 ){
					//===> Pada proses penyimpanan data keterangan masuk ke database , set data/kolom jam masuk sesuai -
					//===> jam sekarang dan kosongkan jam keluar . karena awalan kerja adalah masuk baru keluar . 
					//===> sehingga jam keluar dikosongkan ,karena memang belum ada . 
					DB::table('tbl_absensi')->insert([
						'idpegawai' => $user ,
						'tanggal' =>date('y-m-d') ,
						'jam_hadir' => date('H:i:s') ,
						'jam_pulang' => '00:00:00'
					]);
					//===> kirim pesan pada wemos ESp82266 . bahwa absensi telah berhasil . 
					//===> dengan parameter absen adalah masuk . informasi yang dikirim adalah-
					//===> perintah "success_absen" . nama pengguna . parameter absen masuk . 
					echo "[success_absen" . "," . $user_[0]->nama . ' ,masuk' . ",0]" ;
				}
				else{
					//===> Pada kode prorgam ini dimana kita akan menyimpan data UID dengan kondisi pulang.
					//===> Kondisi pulang tidak sama dengan kondisi ketika masuk . karena jika dalam kondisi masuk-
					//===> dengan mudah kita akan membuat baris table baru untuk proses masuk . 
					//===>  untuk proses masuk , maka kita akan meletakan data secara hati2 ke salah satu table-
					//===> dimana kita masuk.

					//===> Sekarang ambil informasi absen hari ini dari database 
					$db_res = DB::table('tbl_absensi')
										->where('tbl_absensi.idpegawai' , $user )
										->where('tbl_absensi.tanggal' , $date )
										->get();
					//==========>
					//echo  'User:' . $id . ' , Tanggal : ' . $date  ;

					//==========> Parameter cek apakah pada kolom absen hari ini telah penuh untuk kolom-
					//==========> jam masuk dan kolom jam keluar . karena proses awal adalah :
					//==========> [1] Cek absen hari ini sesua dengan UID . 
					//==========> [2] Karena sudah ada maka , disimpulkan absen ini adalah keluar . 
					//==========> [3] Jika Absen dilakukan ke tiga kali nya , maka ini bisa menjadi bug.
					//==========> maka parameter ini untuk mendeteksi jika absen untuk kolom masuk dan keluar-
					//==========> sudah penuh , sehingga prorgam bisa memberikan respon ke user , bahwa absen-
					//==========> telah usai . 
					//==========> Cara kerja adalah default true , akan tetapi jika ditemukan kolom keluar-
					//==========> kosong ,maka diset false ,yang artinya sedang absen masuk . 
					//==========> jadi cara kerja :
					//==========> Jika ditemukan kolom jam  keluar kosong ,maka set false. 
					//==========> Jika Tidak ditemukan kolom keluar kosong ,maka user telah absen keluar sebelumnya.
					//==========> jadi absen sudah selesai.
					$cekAbsenComplete = true  ;
					//==========> Sekarang cari informasi dimana baris table dengan kolom masuk berisi data jam-
					//==========> dan kolom jam keluar berisi infomasi "0:0:0" . 
					//==========> Syarat untuk pencarian kolom masuk :
					//==========>	[1]	Tanggal sekarang . 
					//==========> 	[2] Jam pada kolom masuk ada . 
					//==========>	[3] Jam pada kolom keluar berisi 0:0:0
					//==========> Setelah didapat maka ,lakukan proses update pada pada kolom jam keluar.
					
					//==========> Gunakan foreach untuk mengakses data jam pulang satu persatu dari data-
					//==========> yang di temukan . 
					foreach( $db_res as $value ){
						//===> cek data per baris untuk kolomjam pulang dengan data 0:0:0
						if ( (  strtotime($value->jam_pulang) ==  strtotime('00:00:00') ) == 1 ){
							//===================================>
							//===> Jika sudah di dapat , maka update data tersebut dengan data jam sekarang . 
							DB::table('tbl_absensi')
								->where('id' , $value->id )
								->update(array(
									'jam_pulang' => date('H:i:s')
								));
							//===> set false "cekAbsenComplete" untuk menandakan user sedang absen keluar.
							$cekAbsenComplete = false ;
						}
					}
					if( $cekAbsenComplete == false ){
						echo "[success_absen" ."," . $user_[0]->nama . ",pulang"  . ",0]";
					}else{
						echo "[success_absen" ."," . $user_[0]->nama . ",Sudah Absen"  . ",0]";
					}
				}
			}else{
				echo "[notfound,0]" ;
			}
		}
	}
	
	
	//=============================================================//
	
	public function page_potongan() {
		//=================================>
		$db_res = DB::select('select * from tbl_potongan');
        return view("page_potongan",['db_res'=>$db_res]);
	}
	
	public function page_simpanpotongan(Request $request){
		//=================================>
		// insert data ke table potongan
		DB::table('tbl_potongan')->insert([
			'jenis' => $request->nama,
			'besar' => $this->hapusFormatRupiah( $request->nominal )
		]);
		//=================================>
		$db_res = DB::table('tbl_potongan')->get();
        return view("page_potongan",['db_res'=>$db_res]);
	}
	
	public function page_updatepotongan($id){
		$potongan = DB::table('tbl_potongan')->where('id' , $id)->get();
        return view('page_update_potongan',['potongan'=>$potongan]);
	}
	
	public function page_updateitempotongan(Request $request ){
	
		// update data ke table potongan
		DB::table('tbl_potongan')
			->where('id' , $request->id )
			->update(array(
				'jenis' => $request->jenis ,
				'besar' => $this->hapusFormatRupiah( $request->besar )
			));
		//===> Kembali ke halaman tunjangan .
		$db_res = DB::table('tbl_potongan')->get();
        return view("page_potongan",['db_res'=>$db_res]);
	}
	
	public function page_hapuspotongan( $id ){
		//==> Hapus data tunjangan .
		DB::table('tbl_potongan')->where('id', '=', $id)->delete();
		//=================================>
		$db_res = DB::table('tbl_potongan')->get();
        return view("page_potongan",['db_res'=>$db_res]);
	}
	
	
	//=======================> Jabatan <=========================//
	
	public function page_jabatan() {
		//=================================>
		$tunjangan = DB::table('tbl_tunjangan')->get();
		$users = DB::table('tbl_jabatan')
					->join('tbl_tunjangan', 'tbl_tunjangan.id', '=', 'tbl_jabatan.idtunjangan')
					->select(
						'tbl_jabatan.*' ,
						'tbl_tunjangan.*' ,
						'tbl_jabatan.id as idjabatan',
						'tbl_tunjangan.id as idtunjangan'
					)
					->get();
		//=================================>
        return view('page_jabatan',
			[
				'users'=>$users ,
				'tunjangan'=>  $tunjangan 
			]
		);
	}
	
	public function page_hapusjabatan($id) {
		//=================================>
		DB::table('tbl_jabatan')->where('id', '=', $id)->delete();
		//=================================>
		$tunjangan = DB::table('tbl_tunjangan')->get();
		$users = DB::table('tbl_jabatan')
					->join('tbl_tunjangan', 'tbl_tunjangan.id', '=', 'tbl_jabatan.idtunjangan')
					->select(
						'tbl_jabatan.*' ,
						'tbl_tunjangan.*' ,
						'tbl_jabatan.id as idjabatan',
						'tbl_tunjangan.id as idtunjangan'
					)
					->get();
		//=================================>
        return view('page_jabatan',
			[
				'users'=>$users ,
				'tunjangan'=>$tunjangan
			]
		);
	}
	
	
	public function page_simpanjabatan(Request $request){
		//=================================>
		// insert data ke table pegawai
		DB::table('tbl_jabatan')->insert([
			'idtunjangan' => $request->idpotongan,
			'jabatan' => $request->nama,
			'gajipokok' => $this->hapusFormatRupiah($request->nominal)
		]);
		//=================================>
		$tunjangan = DB::select('select * from tbl_tunjangan');
		$users = DB::table('tbl_jabatan')
					->join('tbl_tunjangan', 'tbl_tunjangan.id', '=', 'tbl_jabatan.idtunjangan')
					->select(
						'tbl_jabatan.*' ,
						'tbl_tunjangan.*' ,
						'tbl_jabatan.id as idjabatan',
						'tbl_tunjangan.id as idtunjangan'
					)
					->get();
        return view('page_jabatan',
			[
				'users'=>$users ,
				'tunjangan'=>$tunjangan
			]
		);
	}
	

	//==> Fungsi kode programcontroller untuk mendaa
	public function page_updatejabatan($id){
		//=================================>
		$tunjangan = DB::table('tbl_tunjangan')->get();
		$jabatan = DB::table('tbl_jabatan')
					->join('tbl_tunjangan', 'tbl_tunjangan.id', '=', 'tbl_jabatan.idtunjangan')
					->select(
							'tbl_jabatan.*',
							'tbl_tunjangan.*',
							'tbl_tunjangan.id as idtunjangan',
							'tbl_jabatan.id as idjabatan'
						)
					->where('tbl_jabatan.id' , $id)
					->get();
		if(  isset( $jabatan[0]->idtunjangan ) == 1 ){
			return view('page_update_jabatan',
				[
					'jabatan'=>$jabatan ,
					'tunjangan' => $tunjangan
				]
			);
		}else{
			
			$users = DB::table('tbl_jabatan')
					->join('tbl_tunjangan', 'tbl_tunjangan.id', '=', 'tbl_jabatan.idtunjangan')
					->select(
						'tbl_jabatan.*' ,
						'tbl_tunjangan.*' ,
						'tbl_jabatan.id as idjabatan',
						'tbl_tunjangan.id as idtunjangan'
					)
					->get();
			//=================================>
			return view('page_jabatan',
				[
					'users'=>$users ,
					'tunjangan'=>$tunjangan ,
					'notfound' => 1
				]
			);
		}
	}
	
	public function page_updateitemjabatan(Request $request){
		// insert data ke table pegawai
		DB::table('tbl_jabatan')
			->where('id' , $request->id )
			->update(array(
				'jabatan' => $request->nama ,
				'gajipokok' => $this->hapusFormatRupiah( $request->nominal ),
				'idtunjangan' => $request->tunjangan
			));
		//=================================>
		$tunjangan = DB::table('tbl_tunjangan')->get();
		$users = DB::table('tbl_jabatan')
					->join('tbl_tunjangan', 'tbl_tunjangan.id', '=', 'tbl_jabatan.idtunjangan')
					->select(
						'tbl_jabatan.*' ,
						'tbl_tunjangan.*' ,
						'tbl_jabatan.id as idjabatan',
						'tbl_tunjangan.id as idtunjangan'
					)
					->get();
		//=================================>
        return view('page_jabatan',
			[
				'users'=>$users ,
				'tunjangan'=>$tunjangan
			]
		);
	}
	
	
	//=======================> Tunjangan <=========================//
	public function page_tunjangan() {
		$tb_result = DB::select('select * from  tbl_tunjangan');
        return view('page_tunjangan',['tbl_tunjangan'=>$tb_result]);
	}
	
	public function page_simpantunjangan(Request $request ){
		// insert data ke table tunjangan
		DB::table('tbl_tunjangan')->insert([
			'jenis' => $request->jenis,
			'besar' => $this->hapusFormatRupiah( $request->besar )
		]);
		//===> Kembali ke halaman tunjangan .
		$tb_result = DB::select('select * from  tbl_tunjangan');
        return view('page_tunjangan',['tbl_tunjangan'=>$tb_result]);
	}
	
	public function page_deletetunjangan($id){
		//==> Hapus data tunjangan .
		DB::table('tbl_tunjangan')->where('id', '=', $id)->delete();
		//===> Kembali ke halaman tunjangan .
		$tb_result = DB::select('select * from  tbl_tunjangan');
        return view('page_tunjangan',['tbl_tunjangan'=>$tb_result]);
	}
	
	public function page_updatetunjangan($id){
		$tunjangan = DB::table('tbl_tunjangan')->where('id' , $id)->get();
        return view('page_update_tunjangan',['tunjangan'=>$tunjangan]);
	}
	
	public function page_updateitemtunjangan(Request $request ){
		// insert data ke table pegawai
		DB::table('tbl_tunjangan')
			->where('id' , $request->id )
			->update(array(
				'jenis' => $request->jenis ,
				'besar' => $this->hapusFormatRupiah(  $request->besar )
			));
		//===> Kembali ke halaman tunjangan .
		$tb_result = DB::select('select * from  tbl_tunjangan');
        return view('page_tunjangan',['tbl_tunjangan'=>$tb_result]);
	}
	
}

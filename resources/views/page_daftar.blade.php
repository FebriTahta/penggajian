@include('page/pag_head')
@include('page/pag_navbar')
@include('page/pag_sidebar')
@include('page/pag_contentheader')

<!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('template/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('template/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8">
			<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form Input Pegawai</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="/simpanpegawai">
				 {{ csrf_field() }}
				 <input id="counter" name="counter" value="0" hidden>
                <div class="card-body">
				  <div class="form-group">
                    <label for="idpegawai">ID.Pegawai </label>
                    <input 
						type="text" 
						class="form-control" 
						id="idpegawai" 
						placeholder="ID Pegawai"
						autocomplete="off"
						name="id"
						value=""
						readonly
					>
                  </div>
                  <div class="form-group">
                    <label for="namauser">Nama </label>
                    <input 
						type="text" 
						class="form-control" 
						id="namauser" 
						placeholder="Nama Pegawai"
						autocomplete="off"
						name="nama"
						value=""
					>
                  </div>
				  <div class="form-group">
					<label>Tanggal Lahir </label>
					<div class="input-group date" id="dateawal" data-target-input="nearest">
						<input 
							type="text" 
							class="form-control datetimepicker-input" 
							data-target="#dateawal" 
							id="tgl-awal"
							autocomplete="off"
							name="tgl"
						>
								<div class="input-group-append" data-target="#dateawal" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
					</div>
				  </div>
				  <div class="form-group">
                    <label for="alamatuser">Tempat Lahir </label>
                    <input 
						type="text" 
						class="form-control" 
						id="alamatuser" 
						placeholder="Tempat Lahir"
						autocomplete="off"
						name="ttl"
					>
                  </div>
				  	<div class="form-group">
                        <label>Jabatan Pegawai</label>
                        <select 
							class="custom-select"
							name="idjabatan"
						>
                          @foreach ($jabatan as $index => $jabatan_item)
								<option 
									data-select2-id="31" 
									value="{{ $jabatan_item->id }}"
								>{{ $jabatan_item->jabatan }}</option>
							@endforeach
                        </select>
                    </div>
				    <div class="form-group" id="potongan-gaji-1">
						<div class="row">
							<label class="col-md-12">Potongan Gaji</label>
							<select 
								class="custom-select col-md-6"
								name="jenispotongan-0"
							>
								@foreach ($potongan as $index => $potongan_item)
									<option 
										data-select2-id="31" 
										value="{{ $jabatan_item->id }}"
									>{{ $potongan_item->jenis }}</option>
								@endforeach
							</select>
							<div class="col-md-2"></div>
							<div class="text-right">
								<a 
									name="hapuspotongan" 
									from="potongan-gaji-1"
									class="btn btn-primary btn-sm" >
									<i class="fas fa-folder">
									</i>
									Delete
								</a>
								<a
									name="tambahpotongan" 
									from="potongan-gaji-1"
									class="btn btn-primary btn-sm "  
								>
									<i class="fas fa-folder">
									</i>
									Tambah
								</a>
							</div>
						</div>
                    </div>
				  <div class="form-group">
                    <label for="alamatuser">Alamat </label>
					
					<textarea class="form-control" 
						id="alamatuser" 
						placeholder="Alamat Pegawai"
						autocomplete="off"
						name="alamat" cols="30" rows="3"></textarea>
                    <!-- <input 
						type="text" 
						
					> -->
                  </div>
                  <div class="form-group">
                    <label for="notelp">Telp</label>
                    <input 
						type="number" 
						class="form-control" 
						id="notelp" 
						placeholder="Nomor Telephone"
						autocomplete="off"
						name="telp"
					>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</div>
	</div>
</div>

<div class="container-fluid">
	
	<div class="row">
		<div class="col-lg-12" id="content-table">
			<!-- DataTales Example -->
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">DataTables Histori</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						  <thead>
							<tr>
							  <th>No</th>
							  <th>Nama</th>
							  <th>Jabatan</th>						
							  <th>Tanggal lahir</th>
							  <th>Tempat lahir</th>
							  <th>Alamat</th>
							  <th>Telp</th>
							  <th>Aksi</th>
							</tr>
						  </thead>
						  <tbody>
							@foreach ($users as $index => $user)
							<tr>
							  <th>{{ $index +1 }}</th>
							  <th>{{  $user->nama }}</th>
							  <th>{{  $user->jabatan }}</th>
							  <th>{{  $user->tgl }}</th>
							  <th>{{  $user->ttl }}</th>
							  <th>{{  $user->alamat }}</th>
							  <th>{{  $user->telp }}</th>
							  <th>
								<!-- 
								<a  
									href="/updatepegawai/{{$user->idpegawai}}"
									type="submit" 
									class="btn btn-primary"
								>Update</a>
								-->
								<!-- <a 
									href="/deletepegawai/{{$user->idpegawai}}" 
									type="submit" class="btn btn-primary"
								>Hapus</a> -->
								<input type="hidden" id="pegawai" value="{{$user->idpegawai}}" require>
								<button class="btn btn-danger btn-sm" onClick="ConfirmDelete()">
									hapus!
								</button>
								<a href="/update-pegawai/{{$user->idpegawai}}" class="btn btn-info btn-sm"  >
									Update
								</a>
							  </th>
							</tr>
							@endforeach
						  </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>		
	</div>
</div>



<script type="text/javascript">

	var p = $('#pegawai').val();
	console.log(p);
      function ConfirmDelete()
      {
            if (confirm("hapus pegawai?"))
        	location.href='/deletepegawai/'+p;
      }

</script>
<script>
<?php
	$value = "" ;
	foreach( $potongan  as $item )
		$value .= "<option data-select2-id='31' value='".$item->id."'>".$item->jenis."</<option>" ;
?>
var jenispotongan = "<?php echo $value ; ?>" ;
var countpotongan = 0 ;
$(document).ready(function(){
	
	try{
		$(document).on("click" , 'a[name="hapuspotongan"]' , function(event){
			try{
				var id_form = $(this).attr('from');
				$( "#" + id_form ).remove();
			}catch(e){
				alert("error saat eksekusi click tambah potongan : " + e );
			}
		});

		$(document).on("click" , 'a[name="tambahpotongan"]' , function(event){
			try{
				countpotongan++ ;
				//====>
				$("#counter").val(countpotongan);
				//====> 
				var	html = '' ; 
				html 	=	'<div class="form-group" id="potongan-gaji-' + countpotongan + '"> ';
				html	+=		'<div class="row">' ;
				html	+=			'<label class="col-md-12">Potongan Gaji </label>' ;
				html	+=			'<select class="custom-select col-md-6"	name="jenispotongan-'+countpotongan+'">';
				html	+=				jenispotongan ;
				html	+=			'</select>' ;
				html	+=			'<div class="col-md-2"></div>'
				html	+=				'<div class="text-right">' ;
				html	+=					'<a name="hapuspotongan"  from="potongan-gaji-' + countpotongan + '" ' ;
				html	+=					'class="btn btn-primary btn-sm">' ;
				html	+=					'<i class="fas fa-folder"></i>Delete</a>' ;
				html	+=					'<a name="tambahpotongan"  from="potongan-gaji-' + countpotongan + '" ' ;
				html	+=					' style="margin-left:3px;"'
				html	+=					'class="btn btn-primary btn-sm ">' ;
				html	+=					'<i class="fas fa-folder"></i>Tambah</a>' ;
				html	+=				'</div>' ;
				html	+=		'</div>' ;
				html	+=	'</div>' ;

				var id_form = $(this).attr('from');
				$( "#" + id_form ).after(html);
				

			}catch(e){
				alert("error saat eksekusi click tambah potongan : " + e );
			}
		});
	}catch(e){
		alert("error add potongan " + e ); 
	}
});

</script>

<script>
try{
	$(document).ready(function() {
		try{
			$('#dataTable').DataTable();
		}catch(e){
			console.log("error table :" + e );
		}
	});
}catch(e){
	alert(e);
}
</script>


 
<script type="text/javascript">
var loaddatanow = false ;
var updateInterval = 1200 ;
var lastdata = 0 ;

function realtimeData(){
	try{
		loaddatanow = true ;
		$.ajax({
			method: 'GET',
			url: "http://<?php echo $_SERVER['HTTP_HOST']; ?>/getData",
			dataType: "json",
			success : function( event ){
				$("#idpegawai").val(event[0]['value']);
				loaddatanow = false ;
			},
			error : function( r , h , s ){
				alert(" error JSON " + s );				
			}
		}); 
	}catch(e){
		alert(" error realtimeData : " + e );
	}
}

function __dataInterval(){
	try{
		if( !loaddatanow ){
			realtimeData();
		}
	}catch(e){
		alert(e);
	}
}

setInterval(function() {
     __dataInterval()
}, updateInterval);

</script>



<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('template/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('template/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('template/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<!-- Page specific script -->
<!-- DataTables  & Plugins -->
<script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('template/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('template/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>



<script>
try{
	$('#dateawal').datetimepicker({
			format: 'YYYY-MM-DD'
	});
}catch(e){
	alert(e);
}
</script>
<!-- Akhir halaman content --->
@include('page/page_bottom')
@include('page/pag_head')
@include('page/pag_navbar')
@include('page/pag_sidebar') 
@include('page/pag_contentheader')
<!-- awal halaman content --->

  <!-- daterange picker -->
  <link rel="stylesheet" href="template/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="template/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="template/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  
  
  <!-- DataTables -->
  <link rel="stylesheet" href="template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">



<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-7">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Halaman Absen User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="/cari_data_absensi">
				{{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <div class="form-group">
                        <label>Nama Pegawai</label>
                        <select class="form-control" id="nama" name="idpegawai">
							@foreach ($users as $index => $userpegawai)
								<option 
									data-select2-id="31" 
									value="{{ $userpegawai->idpegawai }}"
								>{{ $userpegawai->nama }}</option>
							@endforeach
                        </select>
                      </div>
                  </div>
				  <div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label>Date Awal:</label>
							<div class="input-group date" id="reservationdate" data-target-input="nearest">
								<input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" 
								id="tgl_awal"
								name="tgl_awal"
								autocomplete="off"
								>
								<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label>Date Akhir:</label>
							<div class="input-group date" id="reservationdate1" data-target-input="nearest">
								<input type="text" class="form-control datetimepicker-input" data-target="#reservationdate1"
								id="tgl_akhir"
								name="tgl_akhir"
								autocomplete="off"
								>
								<div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
							</div>
						</div>
					</div>
				  </div>
				  
				 
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" onclick="getdatatable()">Lihat</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
		</div>
		
		
		
		<div class="row">

		   <div class="col-lg-12" id="content-table">
				
		   </div>
		</div>
	</div>
</div>

@if(isset($absensi))
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12" id="content-table">
			<!-- DataTales Example -->
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">DataTables Absensi</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						  <thead>
							<tr>
							  <th>ID Pegawai</th>
							  <th>Nama</th>
							  <th>Tanggal</th>
							  <th>Jam Masuk</th>
							  <th>Jam Keluar</th>
							</tr>
						  </thead>
						  <tbody>
							<tr>
							  @foreach ($absensi as $index => $item_absensi)
							
								<tr>
								  <th>{{ $item_absensi->idpegawai }}</th>
								  <th>{{ $item_absensi->nama }}</th>
								  <th>{{ $item_absensi->tanggal }}</th>
								  <th>{{ $item_absensi->jam_hadir }}</th>
								  <th>{{ $item_absensi->jam_pulang }}</th>
								 
								</tr>
								@endforeach
							</tr>
						  </tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
				
	</div>
</div>
@endif

<!-- jQuery -->
<script src="template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- InputMask -->
<script src="template/plugins/moment/moment.min.js"></script>
<script src="template/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="template/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="template/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Page specific script -->
<!-- DataTables  & Plugins -->
<script src="template/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="template/plugins/jszip/jszip.min.js"></script>
<script src="template/plugins/pdfmake/pdfmake.min.js"></script>
<script src="template/plugins/pdfmake/vfs_fonts.js"></script>
<script src="template/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="template/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="template/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
try{
	$('#reservationdate').datetimepicker({
			format: 'YYYY-MM-DD'
	});
	$('#reservationdate1').datetimepicker({
			format: 'YYYY-MM-DD'
	});
}catch(e){
	alert(e);
}
</script>


<!-- Akhir halaman content --->
@include('page/page_bottom')
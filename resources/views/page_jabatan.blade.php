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


@if(isset($notfound))
	<script>
		alert("User Tidak Di Temukan");
	</script>
@endif

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-5">
			<div class="card card-primary">
              	<div class="card-header">
                	<h3 class="card-title">Input Data Jabatan</h3>
              	</div>
              	<!-- /.card-header -->
              	<!-- form start -->
              	<form method="POST" action="/simpanjabatan">
					{{ csrf_field() }}
					<div class="card-body">
						<div class="form-group">
							<label for="inputnama">Nama </label>
							<input 
								type="text" 
								name="nama" 
								class="form-control" 
								id="inputnama" 
								placeholder="Nama Jabatan"
								autocomplete="off"
							>
                  		</div>
						<div class="form-group">
							<label for="inputnominal">Nominal</label>
							<input 
								type="text" 
								name="nominal" 
								class="form-control" 
								id="inputnominal" 
								placeholder="nominal gaji pokok"
								autocomplete="off"
								data-type='currency'
								jns='nominal'
							>
						</div>
						<div class="form-group">
							<div class="form-group">
								<label>Pilih Tunjangan</label>
								<select class="form-control" 
									id="idalat"
									name="idpotongan"
								>
									@foreach ($tunjangan as $index => $tunjangan_item)
										<option 
											data-select2-id="31" 
											value="{{ $tunjangan_item->id }}"
										>{{ $tunjangan_item->jenis }}</option>
									@endforeach
								</select>
							</div>
						</div>
                	</div>
					<!-- /.card-body -->

					<div class="card-footer">
						<input type="submit" class="btn btn-primary" value="Submit">
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
					<h6 class="m-0 font-weight-bold text-primary">Daftar Jabatan</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						  <thead>
							<tr>
							  <th>No</th>
							  <th>Nama</th>
							  <th>Gaji Pokok</th>
							  <th>Jenis Tunjangan</th>
							  <th>Besar</th>
							  <th>Aksi</th>
							</tr>
						  </thead>
						  <tbody>
							@foreach ($users as $index => $user)
							
							<tr>
							  <th>{{ $index +1 }}</th>
							  <th>{{ $user->jabatan }}</th>
							  <th>@currency( $user->gajipokok )</th>
							  <th>{{ $user->jenis }}</th>
							  <th>@currency( $user->besar )</th>
							  <th>
								<a 
									href="/updatejabatan/{{$user->idjabatan}}"
									type="submit" 
									class="btn btn-primary"
								>Update</a>
								<a 
									href="/deletejabatan/{{$user->idjabatan}}" 
									type="submit" class="btn btn-primary"
								>Hapus</a>
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


<!-- Akhir halaman content --->
@include('page/page_bottom')
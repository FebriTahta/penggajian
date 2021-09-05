@include('page/pag_head')
@include('page/pag_navbar')
@include('page/pag_sidebar')
@include('page/pag_contentheader')
 

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

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-5">
			<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form Input Tunjangan Pegawai</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="GET" action="/updatetunjangan">
                <div class="card-body">
				  <div class="form-group">
                    <label for="namatunjangan">ID </label>
                    <input 
						type="text" 
						class="form-control" 
						id="namatunjangan" 
						name="id" 
						placeholder="Nama Tunjangan"
						value="{{ $tunjangan[0]->id }}"
						readonly="readonly"
					>
                  </div>
                  <div class="form-group">
                    <label for="namatunjangan">Jenis </label>
                    <input 
						type="text" 
						class="form-control" 
						id="namatunjangan" 
						name="jenis" 
						placeholder="Nama Tunjangan"
						value="{{ $tunjangan[0]->jenis }}"
					>
                  </div>
                  <div class="form-group">
                    <label for="besarnominal">Nominal</label>
                    <input 
						type="text" 
						class="form-control" 
						id="besarnominal" 
						name="besar" 
						placeholder="nominal tunjangan"
            data-type='currency'
            jns='nominal'
						value="@currency( $tunjangan[0]->besar )"
					>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input id="submit" type="submit" class="btn btn-primary" value="Submit" disabled>
                </div>
              </form>
            </div>
		</div>
	</div>
</div>



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

<!-- Akhir halaman content --->
@include('page/page_bottom')
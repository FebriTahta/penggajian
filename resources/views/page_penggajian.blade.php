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
                        <h3 class="card-title">Halaman Penggajian Pegawai</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="/bacapenggajian">
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Bulan</label>
                                        <select class="form-control" 
                                            id="bulan"
                                            name="nobulan"
                                        >
                                                <option value="1"  > JANUARI </option>
                                                <option value="2"  > FEBRUARY </option>
                                                <option value="3"  > MARET </option>
                                                <option value="4"  > APRIL </option>
                                                <option value="5"  > MEI </option>
                                                <option value="6"  > JUNI </option>
                                                <option value="7"  > JULY </option>
                                                <option value="8"  > AGUSTUS </option>
                                                <option value="9"  > SEPTEMBER </option>
                                                <option value="10"  > OKTOBER </option>
                                                <option value="11"  > NOVEMBER </option>
                                                <option value="12"  > DESEMBER </option>
                                        </select>
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
            </div>
            <!-- /.card -->
        </div>
	
	
	</div>
</div>

<script>
    $(document).ready(function(){
        try{
            $('#tgl_').daterangepicker({
                singleDatePicker: true ,
                format: 'MM/YYYY'
            });
        }catch(e){
            alert("err " + e );
        }
    });
</script>


@if(isset($absensi))
<div class="container-fluid">


    <!-- data informasi pegawai yang akan di proses penggajian nya [ awal ]-->
	<div class="row">
        <!-- DataTales Informasi Pegawai [ awal ]-->
		<div class="col-lg-6" id="content-table">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">INFORMASI PEGAWAI .</h6>
				</div>
				<div class="card-body">
					<form>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Nama Pegawai</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="nama" 
                                        value="{{$pegawai[0]->nama}}"
                                        readonly
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="jabatan" 
                                        value="{{$pegawai[0]->jabatan}}"
                                        readonly
                                    >
                                </div>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
		<!-- DataTales Informasi Pegawai [ akhir ]-->
	</div>
    <!-- data informasi pegawai yang akan di proses penggajian nya [ akhir ]-->




    <!-- data informasi detail penggajian [ awal ]-->
    <div class="row">

        <!-- DataTales Informasi pendapatan bruto [ awal ]-->
        <div class="col-lg-6" id="content-table">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">INFORMASI DETAIL GAJI PEGAWAI</h6>
                </div>
                <div class="card-body">
                    <form>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Gaji Pokok Harian</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="gajipokok" 
                                        value="@currency( $gaji[0]->gajipokok * $absen )"
                                        readonly
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Tunjangan</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="tunjangan" 
                                        value="@currency( $gaji[0]->besar )"
                                        readonly
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Uang Lembur</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="lembur" 
                                        value="@currency(  $nominallembur )"
                                        readonly
                                    >
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- DataTales Informasi pendapatan bruto [ akhir ]-->


        
        <!-- DataTales Informasi potongan pendapatan [ awal ]-->
        <div class="col-lg-6" id="content-table">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">INFORMASI POTONGAN GAJI</h6>
                </div>
                <div class="card-body">
                    <form>
                        <div class="card-body">
                            
                            <!-- Proses data potongan gaji terlebih dahulu [ awal ] . -->
                            @foreach( $data as $item )
                                <div class="form-group">
                                    <label>Potongan {{$item->jenis}}</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="jenis" 
                                        value="@currency(  $item->besar  )"
                                        readonly
                                    >
                                </div>
                            @endforeach
                            <!-- Proses data potongan gaji terlebih dahulu [ akhir ] . -->

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- DataTales Informasi potongan pendapatan bruto [ akhir ]-->



    </div>
    <!-- data informasi detail penggajian [ akhir ]-->


    <!-- data informasi TOTAL gaji [ awal ]-->
    <div class="row">
    <div class="col-lg-6" id="content-table"></div>
        <!-- DataTales Informasi total pendapatan [ awal ]-->
        <div class="col-lg-6" id="content-table">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Total Gaji Di Terima</h6>
                </div>
                <div class="card-body">
                    <form>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Gaji Pokok</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="nama" 
                                        value="@currency( $totalgajiBulanan )"
                                        readonly
                                    >
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- DataTales Informasi total pendapatan [ akhir ]-->
    </div>
    <!-- data informasi TOTAL gaji [ akhir ]-->

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
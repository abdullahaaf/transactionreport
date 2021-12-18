<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Transaksi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url()?>/template/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>/template/dist/css/adminlte.min.css">

  <!-- datatable -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

  <script src="<?php echo base_url()?>/jquery.cookie.js"></script>

  <script>

    $.ajax({
      url : window.location.origin+'/api/datauser',
      type: 'GET',
      dataType: 'JSON',
      headers:{'Authorization':"Bearer "+$.cookie('token')},
      error:function(){
        window.location.href=window.location.origin+'/';
      }
    });
    
  </script>

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="<?php echo base_url()?>/template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Laporan Transaksi</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="<?php echo base_url('merchant')?>" class="nav-link">Merchant</a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('outlet')?>" class="nav-link">Outlet</a>
          </li>
        </ul>
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            Selamat Datang
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h4 class="card-title">Laporan Transaksi Outlet</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                      <div class="form-group col">
                          <label for="">Tanggal Awal</label>
                          <input type="date" name="tanggal-awal" class="form-control" id="tanggal-awal" value="<?php echo date('Y-m-d')?>">
                      </div>
                      <div class="form-group col">
                          <label for="">Tanggal Akhir</label>
                          <input type="date" name="tanggal-akhir" class="form-control" id="tanggal-akhir" value="<?php echo date('Y-m-d')?>">
                      </div>
                      <div class="form-group col">
                          <label for="">Outlet</label>
                          <select name="outlet_id" class="form-control" id="outlet_id">
                              <option value="">Pilih outlet</option>
                          </select>
                      </div>
                  </div>
                  <button type="button" id="btn-submit" class="btn btn-sm btn-primary float-right">Submit</button>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Omset</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-data">
                        </tbody>
                    </table>
                </div>
            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>/template/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>/template/dist/js/demo.js"></script>

<script>
    $(document).ready(function() {

        var table = $('#example').DataTable();

        $.ajax({
          type : 'GET',
          url : window.location.origin+'/api/alloutlet',
          headers:{
            'Authorization':"Bearer "+$.cookie('token')
          },
          success:function(data){
            var html = "";
            for (const i in data){
              html += ""+
              "<option value="+data[i].id_outlet+">"+data[i].outlet_name+"</option>";
            }
            $('#outlet_id').html(html);
          }
        });

        $('body').on('click','#btn-submit',function(){
          var tanggal_awal = $('#tanggal-awal').val();
          var tanggal_akhir = $('#tanggal-akhir').val();
          var outlet = $('#outlet_id').val();

          var url = window.location.origin+'/api/outletapi?tanggal-awal='+tanggal_awal+'&tanggal-akhir='+tanggal_akhir+'&outlet_id='+outlet;

          $.ajax({
            type : 'GET',
            url : url,
            headers:{
              'Authorization':"Bearer "+$.cookie('token')
            },
            dataType : 'json',
            success : function(data){
              console.log(data);
              $('#example').DataTable().clear().destroy();
              var html = "";
              for (const i in data) {
                html += '<tr>'+
                '<td>'+data[i].tanggal+'</td>'+
                '<td>'+data[i].omset+'</td>'+
                '</tr>'; 
              }
              $('#tabel-data').html(html);
              table = $('#example').DataTable();
            }
          });
        });
    });
</script>

</body>
</html>
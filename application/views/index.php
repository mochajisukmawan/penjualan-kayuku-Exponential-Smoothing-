<?php
$data_bulan = array('Januari',
                    'Febuari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                  );

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Penjualan Kayu</title>

  <!-- Custom fonts for this theme -->
  <link href="<?=base_url()?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Theme CSS -->
  <link href="<?=base_url()?>assets/css/freelancer.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Penjualan Kayu</a>
      <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">Detail Tiap Bulan</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#mape">MAPE</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Nilai Aktual</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Nilai Prediksi Awal</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column " style="margin-bottom:150px">



      <h2 class="page-section-heading text-center text-uppercase  mb-0" style="margin-top:100px">Prediksi Jumlah Stok Bulan Depan</h2>

      <div class="divider-custom divider-light">
        <div class="divider-custom-line"></div>
      </div>
      <!-- Masthead Heading -->
      <h1 class="masthead-heading text-uppercase mb-0 add_prediksi_header"></h1>

      <!-- Icon Divider -->

      <!-- Masthead Subheading -->

    </div>
  </header>

  <!-- Portfolio Section -->
  <section class="page-section portfolio" id="portfolio">
    <div class="container">

      <!-- Portfolio Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Detail Tiap Bulan</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>

      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Aktual</th>
            <th>Prediksi α = 0.5</th>
            <th>Prediksi α = 0.7</th>
            <th>Prediksi α = 0.9</th>
            <th width="145">Rumus Algoritma
              <!-- Portfolio Item 1 -->
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          $this->db->order_by('tahun');
          $this->db->order_by('bulan');
          $data_aktual = $this->db->get('t_stok');
          $data_prakiraan_awal = $this->db->get_where('t_prakiraan',array('id_prakiraan'=>1))->row();
          $no = 0;
          $prediksi1 = 0;
          $prediksi2 = 0;
          $prediksi3 = 0;
          $prediksi_data1 = array();
          $prediksi_data2 = array();
          $prediksi_data3 = array();
          $mape1=array();
          $mape2=array();
          $mape3=array();
          $label=array();
          $total=array();
          foreach ($data_aktual->result() as $v_da) {
            if($no == 0){?>
              <tr>
                <td><?=$data_bulan[$v_da->bulan-1]?></td>
                <td><?=$v_da->tahun?></td>
                <td><?=round($v_da->aktual,3)?></td>
                <td><?=round($data_prakiraan_awal->prakiraanawal,3)?></td>
                <td><?=round($data_prakiraan_awal->prakiraanawal,3)?></td>
                <td><?=round($data_prakiraan_awal->prakiraanawal,3)?></td>
                <td>
                  <button class="btn btn-info" data-toggle="modal" data-target="#prakiraanawal<?=$no?>">Lihat</button>
                  <div class="portfolio-modal modal fade" id="prakiraanawal<?=$no?>" tabindex="-1" role="dialog" aria-labelledby="portfolioModal1Label" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                      <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">
                            <i class="fas fa-times"></i>
                          </span>
                        </button>
                        <div class="modal-body text-center">
                          <div class="container">
                            <div class="row justify-content-center">
                              <div class="col-lg-8">
                                <!-- Portfolio Modal - Title -->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Rumus Prakiraan</h2>
                                <!-- Icon Divider -->
                                <div class="divider-custom">
                                  <div class="divider-custom-line"></div>
                                </div>
                                <?php
                                $nilaiaktual = $v_da->aktual;
                                array_push($total,$v_da->aktual);
                                $nilaiperkiraan1 = $data_prakiraan_awal->prakiraanawal;
                                array_push($prediksi_data1,round($nilaiperkiraan1,3));
                                $prediksi1 =  $nilaiperkiraan1 + (0.5*($nilaiaktual - $nilaiperkiraan1));
                                $pengurangan1 = $nilaiaktual - $nilaiperkiraan1;
                                $kalialfa1 = 0.5*($nilaiaktual - $nilaiperkiraan1);
                                array_push($mape1,round(abs((($nilaiaktual - $nilaiperkiraan1)/$nilaiaktual) * 100),3));
                                array_push($label,''.$data_bulan[$v_da->bulan-1].' '.$v_da->tahun.'');

                                $nilaiperkiraan2 = $data_prakiraan_awal->prakiraanawal;
                                array_push($prediksi_data2,round($nilaiperkiraan2,3));
                                $prediksi2 =  $nilaiperkiraan2 + (0.7*($nilaiaktual - $nilaiperkiraan2));
                                $pengurangan2 = $nilaiaktual - $nilaiperkiraan2;
                                $kalialfa2 = 0.7*($nilaiaktual - $nilaiperkiraan2);
                                array_push($mape2,round(abs((($nilaiaktual - $nilaiperkiraan2)/$nilaiaktual)* 100),3));


                                $nilaiperkiraan3 = $data_prakiraan_awal->prakiraanawal;
                                array_push($prediksi_data3,round($nilaiperkiraan3,3));
                                $prediksi3 =  $nilaiperkiraan3 + (0.9*($nilaiaktual - $nilaiperkiraan3));
                                $pengurangan3 = $nilaiaktual - $nilaiperkiraan3;
                                $kalialfa3 = 0.9*($nilaiaktual - $nilaiperkiraan3);
                                array_push($mape3,round(abs((($nilaiaktual - $nilaiperkiraan3)/$nilaiaktual) * 100),3));

                                ?>
                                <pre class="text-left">
                            Ft = Prakiraan Permintaan sekarang
                            Ft-1 = Prakiraan Permintaan yang lalu
                            α = Konstanta Eksponensial (0.5 , 0.7, 0.9)
                            Dt-1 = Permintaan Nyata
                                </pre>
                                <pre class="text-left">
                            Ft = Ft–1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan1?> + 0.5 (<?=$nilaiaktual?> – <?=$nilaiperkiraan1?>)
                            Ft = <?=$nilaiperkiraan1?> + 0.5 (<?=$pengurangan1?>)
                            Ft = <?=$nilaiperkiraan1?> + (<?=$kalialfa1?>)
                            Ft = <?=$prediksi1?>


                                  </pre>
                                  <pre class="text-left">
                            Ft = Ft–1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan2?> + 0.7 (<?=$nilaiaktual?> – <?=$nilaiperkiraan1?>)
                            Ft = <?=$nilaiperkiraan2?> + 0.7 (<?=$pengurangan2?>)
                            Ft = <?=$nilaiperkiraan2?> + (<?=$kalialfa2?>)
                            Ft = <?=$prediksi2?>


                                    </pre>
                                    <pre class="text-left">
                            Ft = Ft–1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan3?> + 0.9 (<?=$nilaiaktual?> – <?=$nilaiperkiraan3?>)
                            Ft = <?=$nilaiperkiraan3?> + 0.9 (<?=$pengurangan3?>)
                            Ft = <?=$nilaiperkiraan3?> + (<?=$kalialfa3?>)
                            Ft = <?=$prediksi3?>


                                      </pre>



                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php
            }else{?>
              <tr>
                <td><?=$data_bulan[$v_da->bulan-1]?></td>
                <td><?=$v_da->tahun?></td>
                <td><?=round($v_da->aktual,3)?></td>
                <td><?=round($prediksi1,3)?></td>
                <td><?=round($prediksi2,3)?></td>
                <td><?=round($prediksi3,3)?></td>
                <td>
                  <button class="btn btn-info" data-toggle="modal" data-target="#prakiraan<?=$no?>">Lihat</button>
                  <div class="portfolio-modal modal fade" id="prakiraan<?=$no?>" tabindex="-1" role="dialog" aria-labelledby="portfolioModal1Label" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                      <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">
                            <i class="fas fa-times"></i>
                          </span>
                        </button>
                        <div class="modal-body text-center">
                          <div class="container">
                            <div class="row justify-content-center">
                              <div class="col-lg-8">
                                <!-- Portfolio Modal - Title -->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Rumus Prakiraan</h2>
                                <!-- Icon Divider -->
                                <div class="divider-custom">
                                  <div class="divider-custom-line"></div>
                                </div>
                                <?php

                                array_push($prediksi_data1,round($prediksi1,3));

                                $nilaiaktual = $v_da->aktual;
                                array_push($total,$v_da->aktual);
                                $nilaiperkiraan1 = $prediksi1;
                                $prediksi1 =  $nilaiperkiraan1 + (0.5*($nilaiaktual - $nilaiperkiraan1));
                                $pengurangan1 = $nilaiaktual - $nilaiperkiraan1;
                                $kalialfa1 = 0.5*($nilaiaktual - $nilaiperkiraan1);
                                array_push($mape1,round(abs((($nilaiaktual - $nilaiperkiraan1)/$nilaiaktual) * 100),3));
                                array_push($label,''.$data_bulan[$v_da->bulan-1].' '.$v_da->tahun.'');

                                array_push($prediksi_data2,round($prediksi2,3));
                                $nilaiperkiraan2 = $prediksi2;
                                $prediksi2 =  $nilaiperkiraan2 + (0.7*($nilaiaktual - $nilaiperkiraan2));
                                $pengurangan2 = $nilaiaktual - $nilaiperkiraan2;
                                $kalialfa2 = 0.7*($nilaiaktual - $nilaiperkiraan2);
                                array_push($mape2,round(abs((($nilaiaktual - $nilaiperkiraan2)/$nilaiaktual)* 100),3));

                                array_push($prediksi_data3,round($prediksi3,3));

                                $nilaiperkiraan3 = $prediksi3;
                                $prediksi3 =  $nilaiperkiraan3 + (0.9*($nilaiaktual - $nilaiperkiraan3));
                                $pengurangan3 = $nilaiaktual - $nilaiperkiraan3;
                                $kalialfa3 = 0.9*($nilaiaktual - $nilaiperkiraan3);
                                array_push($mape3,round(abs( (($nilaiaktual - $nilaiperkiraan3)/$nilaiaktual) * 100),3));


                                ?>
                                <pre class="text-left">
                            Ft = Prakiraan Permintaan sekarang
                            Ft-1 = Prakiraan Permintaan yang lalu
                            α = Konstanta Eksponensial (0.5 , 0.7, 0.9)
                            Dt-1 = Permintaan Nyata
                                </pre>
                                <pre class="text-left">
                            Ft = Ft–1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan1?> + 0.5 (<?=$nilaiaktual?> – <?=$nilaiperkiraan1?>)
                            Ft = <?=$nilaiperkiraan1?> + 0.5 (<?=$pengurangan1?>)
                            Ft = <?=$nilaiperkiraan1?> + (<?=$kalialfa1?>)
                            Ft = <?=$prediksi1?>


                                  </pre>
                                  <pre class="text-left">
                            Ft = Ft–1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan2?> + 0.7 (<?=$nilaiaktual?> – <?=$nilaiperkiraan1?>)
                            Ft = <?=$nilaiperkiraan2?> + 0.7 (<?=$pengurangan2?>)
                            Ft = <?=$nilaiperkiraan2?> + (<?=$kalialfa2?>)
                            Ft = <?=$prediksi2?>


                                    </pre>
                                    <pre class="text-left">
                            Ft = Ft–1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan3?> + 0.9 (<?=$nilaiaktual?> – <?=$nilaiperkiraan3?>)
                            Ft = <?=$nilaiperkiraan3?> + 0.9 (<?=$pengurangan3?>)
                            Ft = <?=$nilaiperkiraan3?> + (<?=$kalialfa3?>)
                            Ft = <?=$prediksi3?>


                                      </pre>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php
            }?>

          <?php
          $no++;
          }
          ?>
          <tr>
            <td colspan="3">prediksi</td><td><?=round($prediksi1,3)?></td><td><?=round($prediksi2,3)?></td><td><?=round($prediksi3,3)?></td><td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
  <section class="page-section mape" id="mape">
    <div class="container">

      <!-- About Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-secondary">MAPE</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>No</th>
            <th>mape = 0.5</th>
            <th>mape = 0.7</th>
            <th>mape = 0.9</th>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          $jum1=0;
          $jum2=0;
          $jum3=0;
          for($i = 0;$i < $no ; $i++){
            $jum1 = $jum1+$mape1[$i];
            $jum2 = $jum2+$mape2[$i];
            $jum3 = $jum3+$mape3[$i];
            $j = $i+1;
            echo '<tr>';
            echo '<td>'.$j.'</td>';
            echo '<td>'.round($mape1[$i],3).'</td>';
            echo '<td>'.round($mape2[$i],3).'</td>';
            echo '<td>'.round($mape3[$i],3).'</td>';
            echo '</tr>';

          };
          echo '<tr>';
          echo '<td>Total</td>';
          echo '<td>'.round($jum1/$no,3).'</td>';
          echo '<td>'.round($jum2/$no,3).'</td>';
          echo '<td>'.round($jum3/$no,3).'</td>';
          echo '</tr>';

          ?>
        </tbody>
      </table>


    </div>
    <div class="container">
      <!-- About Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-secondary">Chart Mape</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>
      <canvas id="canvas"></canvas>
      <h2 class="page-section-heading text-center text-uppercase text-secondary">Chart Mape Terkecil</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>
      <canvas id="canvas2"></canvas>
    </div>
  </section>

  <section class="page-section text-white mb-0" id="about">
    <div class="container">

      <!-- About Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-secondary">Nilai Aktual</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>

      <div class="divider-custom">
        <button class="btn btn-info" data-toggle="modal" data-target="#addaktual">Add Data</button>
      </div>


      <!-- About Section Content -->
      <div class="row">
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th>Bulan</th>
              <th>Tahun</th>
              <th>Nilai aktual</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php


            foreach ($data_aktual->result() as $v_da) {?>
              <tr>
                <td><?=$data_bulan[$v_da->bulan-1]?></td>
                <td><?=$v_da->tahun?></td>
                <td><?=round($v_da->aktual,3)?></td>
                <td><a href="<?=base_url()?>utama/delete_aktual/<?=$v_da->id?>"><button class="btn btn-danger">Delete</button></a></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>

    </div>
  </section>

  <section class="page-section text-white mb-0" id="contact">
    <div class="container">

      <!-- About Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-secondary">Nilai Prediksi Awal</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>
      <form action="<?=base_url()?>utama/updateprakiraan" method="post">
      <div class="divider-custom">


        <input class="form-control" style="text-align:center;" name="prakiraanawal" type="text" value="<?=$data_prakiraan_awal->prakiraanawal?>" placeholder="Masukan Nilai Prakiraan Awal" >
      </div>
      <div class="divider-custom">
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
      </form>


    </div>
  </section>



  <!-- Copyright Section -->
  <section class="copyright py-4 text-center text-white">
    <div class="container">
      <small>Copyright &copy; Your Website 2019</small>
    </div>
  </section>

  <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
  <div class="scroll-to-top d-lg-none position-fixed ">
    <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
      <i class="fa fa-chevron-up"></i>
    </a>
  </div>

  <!-- Portfolio Modals -->

  <!-- Portfolio Modal 1 -->




  <div class="portfolio-modal modal fade" id="addaktual" tabindex="-1" role="dialog" aria-labelledby="portfolioModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <i class="fas fa-times"></i>
          </span>
        </button>
        <div class="modal-body text-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <!-- Portfolio Modal - Title -->
                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Tambah Nilai Aktual</h2>
                <!-- Icon Divider -->
                <div class="divider-custom">
                  <div class="divider-custom-line"></div>
                </div>
                <form  method="post" action="<?=base_url()?>utama/simpan_aktual">
                  <div class="control-group">
                    <label>Bulan</label>
                      <select class="form-control" name="bulan" required="required">
                        <option disabled selected>=Pilih Bulan=</option>
                        <?php foreach ($data_bulan as $k_db => $v_db): ?>
                          <option value="<?=$k_db+1?>"><?=$v_db?></option>
                        <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="control-group">
                      <label>Tahun</label>
                      <input class="form-control" name="tahun" type="number" placeholder="Masukan Tahun" required="required">
                  </div>
                  <div class="control-group">
                      <label>Nilai Aktual</label>
                      <input class="form-control" name="aktual" placeholder="Masukan Nilai Aktual" required="required">
                  </div>

                  <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Portfolio Modal 2 -->

  <!-- Portfolio Modal 3 -->

  <!-- Portfolio Modal 4 -->

  <!-- Portfolio Modal 5 -->

  <!-- Portfolio Modal 6 -->

  <!-- Bootstrap core JavaScript -->

  <?php
  $label_json = json_encode($label);
  $mape1_json = json_encode($mape1);
  $mape2_json = json_encode($mape2);
  $mape3_json = json_encode($mape3);

  $jum1_json = json_encode($jum1);
  $jum2_json = json_encode($jum2);
  $jum3_json = json_encode($jum3);

  $prediksi1_json = json_encode(round($prediksi1,3));
  $prediksi2_json = json_encode(round($prediksi2,3));
  $prediksi3_json = json_encode(round($prediksi3,3));

  $prediksi_data1_json = json_encode($prediksi_data1);
  $prediksi_data2_json = json_encode($prediksi_data2);
  $prediksi_data3_json = json_encode($prediksi_data3);
  $total_json = json_encode($total);
   ?>
  <script src="<?=base_url()?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="<?=base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact Form JavaScript -->
  <script src="<?=base_url()?>assets/js/jqBootstrapValidation.js"></script>
  <script src="<?=base_url()?>assets/js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="<?=base_url()?>assets/js/freelancer.min.js"></script>

  <script src="<?=base_url()?>assets/chartjs/Chart.bundle.min.js"></script>
  <script src="<?=base_url()?>assets/chartjs/Chart.bundle.js"></script>
  <script src="<?=base_url()?>assets/chartjs/utils.js"></script>





  <script>

    var terbesar = 0;

    var label = JSON.parse('<?=$label_json?>');
    var mape1 = JSON.parse('<?=$mape1_json?>');
    var mape2 = JSON.parse('<?=$mape2_json?>');
    var mape3 = JSON.parse('<?=$mape3_json?>');
    var jum1 = JSON.parse('<?=$jum1_json?>');
    var jum2 = JSON.parse('<?=$jum2_json?>');
    var jum3 = JSON.parse('<?=$jum3_json?>');
    var prediksi1 = JSON.parse('<?=$prediksi1_json?>');
    var prediksi2 = JSON.parse('<?=$prediksi2_json?>');
    var prediksi3 = JSON.parse('<?=$prediksi3_json?>');

    var prediksi_data1 = JSON.parse('<?=$prediksi_data1_json?>');
    var prediksi_data2 = JSON.parse('<?=$prediksi_data2_json?>');
    var prediksi_data3 = JSON.parse('<?=$prediksi_data3_json?>');
    var total = JSON.parse('<?=$total_json?>');

    console.log(prediksi_data1);
    console.log(prediksi_data2);
    console.log(prediksi_data3);
    if(jum1<jum2){
      if(jum1<jum3){
          terbesar=jum1;
          nilai = prediksi_data1;
          warna = window.chartColors.red;
          nama = 'α = 0.5';
          prediksi = prediksi1;
      }else{
          terbesar=jum3;
          nilai = prediksi_data3;
          warna = window.chartColors.yellow;
          nama = 'α = 0.9';
          prediksi = prediksi3;


      }
    }else{
      if(jum2<jum3){
          terbesar=jum2;
          nilai = prediksi_data2;
          warna = window.chartColors.blue;
          nama = 'α = 0.7';
          prediksi = prediksi2;


      }else{
          terbesar=jum3;
          nilai = prediksi_data3;
          warna = window.chartColors.yellow;
          nama = 'α = 0.9';
          prediksi = prediksi3;


      }
    }

    $('.add_prediksi_header').html(prediksi);

    var config = {
      type: 'line',
      data: {
        labels: label,
        datasets: [{
          label: 'aktual',
          backgroundColor: window.chartColors.black,
          borderColor: window.chartColors.black,
          data: total,
          fill: false,
        },{
          label: 'α = 0.5',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: prediksi_data1,
          fill: false,
        }, {
          label: 'α = 0.7',
          fill: false,
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: prediksi_data2,
        }, {
          label: 'α = 0.9',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: prediksi_data3,
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: ''
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Nilai Aktual & Prediksi'
            }

          }]
        }
      }
    };

    var config2 = {
      type: 'line',
      data: {
        labels: label,
        datasets: [{
          label: 'aktual',
          backgroundColor: window.chartColors.black,
          borderColor: window.chartColors.black,
          data: total,
          fill: false,
        },{
          label: nama,
          backgroundColor: warna,
          borderColor: warna,
          data: nilai,
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: ''
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Nilai Aktual & Prediksi'
            }
          }]
        }
      }
    };

    window.onload = function() {
      var ctx = document.getElementById('canvas').getContext('2d');
      window.myLine = new Chart(ctx, config);

      var ctx2 = document.getElementById('canvas2').getContext('2d');
      window.myLine2 = new Chart(ctx2, config2);
    };



  </script>

</body>

</html>

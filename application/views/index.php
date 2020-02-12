<?php
$data_bulan = array('januari',
                    'febuari',
                    'maret',
                    'april',
                    'mei',
                    'juni',
                    'juli',
                    'agustus',
                    'september',
                    'oktober',
                    'november',
                    'desember'
                  );

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Penjualan kayuku</title>

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
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Penjualan kayuku</a>
      <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">Detail Tiap bulan</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Input Niai Aktual</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Nilai prakiraan Awal</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column " style="margin-bottom:150px">



      <h2 class="page-section-heading text-center text-uppercase  mb-0" style="margin-top:100px">Perkiraan Jumlah Stok Bulan Ini</h2>

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
      <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Detail Tiap bulan</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>

      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>aktual</th>
            <th>prakiraan α = 0.5</th>
            <th>prakiraan α = 0.7</th>
            <th>prakiraan α = 0.9</th>
            <th width="145">rumus prakiraan
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
          $mape1=array();
          $mape2=array();
          $mape3=array();
          $label=array();
          foreach ($data_aktual->result() as $v_da) {
            if($no == 0){?>
              <tr>
                <td><?=$data_bulan[$v_da->bulan-1]?></td>
                <td><?=$v_da->tahun?></td>
                <td><?=$v_da->aktual?></td>
                <td><?=$data_prakiraan_awal->prakiraanawal?></td>
                <td><?=$data_prakiraan_awal->prakiraanawal?></td>
                <td><?=$data_prakiraan_awal->prakiraanawal?></td>
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

                                $nilaiperkiraan1 = $data_prakiraan_awal->prakiraanawal;
                                $prediksi1 =  $nilaiperkiraan1 - 1 + (0.5*($nilaiaktual - $nilaiperkiraan1));
                                $pengurangan1 = $nilaiaktual - $nilaiperkiraan1;
                                $kalialfa1 = 0.5*($nilaiaktual - $nilaiperkiraan1);
                                array_push($mape1,abs((($nilaiaktual - $nilaiperkiraan1)/$nilaiaktual) * 100));
                                array_push($label,''.$data_bulan[$v_da->bulan-1].' '.$v_da->tahun.'');

                                $nilaiperkiraan2 = $data_prakiraan_awal->prakiraanawal;
                                $prediksi2 =  $nilaiperkiraan2 - 1 + (0.7*($nilaiaktual - $nilaiperkiraan2));
                                $pengurangan2 = $nilaiaktual - $nilaiperkiraan2;
                                $kalialfa2 = 0.7*($nilaiaktual - $nilaiperkiraan2);
                                array_push($mape2,abs((($nilaiaktual - $nilaiperkiraan2)/$nilaiaktual)* 100));


                                $nilaiperkiraan3 = $data_prakiraan_awal->prakiraanawal;
                                $prediksi3 =  $nilaiperkiraan3 - 1 + (0.9*($nilaiaktual - $nilaiperkiraan3));
                                $pengurangan3 = $nilaiaktual - $nilaiperkiraan3;
                                $kalialfa3 = 0.9*($nilaiaktual - $nilaiperkiraan3);
                                array_push($mape3,abs((($nilaiaktual - $nilaiperkiraan3)/$nilaiaktual) * 100));

                                ?>
                                <pre class="text-left">
                            Ft = Prakiraan Permintaan sekarang
                            Ft-1 = Prakiraan Permintaan yang lalu
                            α = Konstanta Eksponensial (0.5 , 0.7, 0.9)
                            Dt-1 = Permintaan Nyata
                                </pre>
                                <pre class="text-left">
                            Ft = Ft – 1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan1?> + 0.5 (<?=$nilaiaktual?> – <?=$nilaiperkiraan1?>)
                            Ft = <?=$nilaiperkiraan1?> + 0.5 (<?=$pengurangan1?>)
                            Ft = <?=$nilaiperkiraan1?> + (<?=$kalialfa1?>)
                            Ft = <?=$prediksi1?>


                                  </pre>
                                  <pre class="text-left">
                            Ft = Ft – 1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan2?> + 0.7 (<?=$nilaiaktual?> – <?=$nilaiperkiraan1?>)
                            Ft = <?=$nilaiperkiraan2?> + 0.7 (<?=$pengurangan2?>)
                            Ft = <?=$nilaiperkiraan2?> + (<?=$kalialfa2?>)
                            Ft = <?=$prediksi2?>


                                    </pre>
                                    <pre class="text-left">
                            Ft = Ft – 1 + α (Dt-1 – Ft-1)
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
                <td><?=$v_da->aktual?></td>
                <td><?=$prediksi1?></td>
                <td><?=$prediksi2?></td>
                <td><?=$prediksi3?></td>
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


                                $nilaiaktual = $v_da->aktual;

                                $nilaiperkiraan1 = $prediksi1;
                                $prediksi1 =  $nilaiperkiraan1 - 1 + (0.5*($nilaiaktual - $nilaiperkiraan1));
                                $pengurangan1 = $nilaiaktual - $nilaiperkiraan1;
                                $kalialfa1 = 0.5*($nilaiaktual - $nilaiperkiraan1);
                                array_push($mape1,abs((($nilaiaktual - $nilaiperkiraan1)/$nilaiaktual) * 100));
                                array_push($label,''.$data_bulan[$v_da->bulan-1].' '.$v_da->tahun.'');

                                $nilaiperkiraan2 = $prediksi2;
                                $prediksi2 =  $nilaiperkiraan2 - 1 + (0.7*($nilaiaktual - $nilaiperkiraan2));
                                $pengurangan2 = $nilaiaktual - $nilaiperkiraan2;
                                $kalialfa2 = 0.7*($nilaiaktual - $nilaiperkiraan2);
                                array_push($mape2,abs((($nilaiaktual - $nilaiperkiraan2)/$nilaiaktual)* 100));


                                $nilaiperkiraan3 = $prediksi3;
                                $prediksi3 =  $nilaiperkiraan3 - 1 + (0.9*($nilaiaktual - $nilaiperkiraan3));
                                $pengurangan3 = $nilaiaktual - $nilaiperkiraan3;
                                $kalialfa3 = 0.9*($nilaiaktual - $nilaiperkiraan3);
                                array_push($mape3,abs( (($nilaiaktual - $nilaiperkiraan3)/$nilaiaktual) * 100));


                                ?>
                                <pre class="text-left">
                            Ft = Prakiraan Permintaan sekarang
                            Ft-1 = Prakiraan Permintaan yang lalu
                            α = Konstanta Eksponensial (0.5 , 0.7, 0.9)
                            Dt-1 = Permintaan Nyata
                                </pre>
                                <pre class="text-left">
                            Ft = Ft – 1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan1?> + 0.5 (<?=$nilaiaktual?> – <?=$nilaiperkiraan1?>)
                            Ft = <?=$nilaiperkiraan1?> + 0.5 (<?=$pengurangan1?>)
                            Ft = <?=$nilaiperkiraan1?> + (<?=$kalialfa1?>)
                            Ft = <?=$prediksi1?>


                                  </pre>
                                  <pre class="text-left">
                            Ft = Ft – 1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan2?> + 0.7 (<?=$nilaiaktual?> – <?=$nilaiperkiraan1?>)
                            Ft = <?=$nilaiperkiraan2?> + 0.7 (<?=$pengurangan2?>)
                            Ft = <?=$nilaiperkiraan2?> + (<?=$kalialfa2?>)
                            Ft = <?=$prediksi2?>


                                    </pre>
                                    <pre class="text-left">
                            Ft = Ft – 1 + α (Dt-1 – Ft-1)
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
            <td colspan="3">prediksi</td><td><?=$prediksi1?></td><td><?=$prediksi2?></td><td><?=$prediksi3?></td><td></td>
          </tr>
        </tbody>
      </table>
    </div>
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
            $jum3 = $jum1+$mape3[$i];
            $j = $i+1;
            echo '<tr>';
            echo '<td>'.$j.'</td>';
            echo '<td>'.$mape1[$i].'</td>';
            echo '<td>'.$mape2[$i].'</td>';
            echo '<td>'.$mape3[$i].'</td>';
            echo '</tr>';

          };
          echo '<tr>';
          echo '<td>Total</td>';
          echo '<td>'.$jum1/$no.'</td>';
          echo '<td>'.$jum2/$no.'</td>';
          echo '<td>'.$jum3/$no.'</td>';
          echo '</tr>';

          ?>
        </tbody>
      </table>


    </div>
    <div class="container">
      <!-- About Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-secondary">chart mape</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>
      <canvas id="canvas"></canvas>
      <h2 class="page-section-heading text-center text-uppercase text-secondary">chart mape terkecil</h2>

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
      <h2 class="page-section-heading text-center text-uppercase text-secondary">Input Niai Aktual</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>

      <div class="divider-custom">
        <button class="btn btn-info" data-toggle="modal" data-target="#addaktual">add data</button>
      </div>


      <!-- About Section Content -->
      <div class="row">
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th>Bulan</th>
              <th>Tahun</th>
              <th>Nilai aktual</th>
              <th>action</th>
            </tr>
          </thead>
          <tbody>
            <?php


            foreach ($data_aktual->result() as $v_da) {?>
              <tr>
                <td><?=$data_bulan[$v_da->bulan-1]?></td>
                <td><?=$v_da->tahun?></td>
                <td><?=$v_da->aktual?></td>
                <td><a href="<?=base_url()?>utama/delete_aktual/<?=$v_da->id?>"><button class="btn btn-danger">delete</button></a></td>
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
      <h2 class="page-section-heading text-center text-uppercase text-secondary">Nilai prakiraan Awal</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>
      <form action="<?=base_url()?>utama/updateprakiraan" method="post">
      <div class="divider-custom">


        <input class="form-control" name="prakiraanawal" type="number" value="<?=$data_prakiraan_awal->prakiraanawal?>" placeholder="Masukan Nilai Prakiraan Awal" required="required">
      </div>
      <div class="divider-custom">
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
      </form>


    </div>
  </section>

  <!-- Footer -->
  <footer class="footer text-center">
    <div class="container">
      <div class="row">

        <!-- Footer Location -->
        <div class="col-lg-4 mb-5 mb-lg-0">
          <h4 class="text-uppercase mb-4">Location</h4>
          <p class="lead mb-0">2215 John Daniel Drive
            <br>Clark, MO 65243</p>
        </div>

        <!-- Footer Social Icons -->
        <div class="col-lg-4 mb-5 mb-lg-0">
          <h4 class="text-uppercase mb-4">Around the Web</h4>
          <a class="btn btn-outline-light btn-social mx-1" href="#">
            <i class="fab fa-fw fa-facebook-f"></i>
          </a>
          <a class="btn btn-outline-light btn-social mx-1" href="#">
            <i class="fab fa-fw fa-twitter"></i>
          </a>
          <a class="btn btn-outline-light btn-social mx-1" href="#">
            <i class="fab fa-fw fa-linkedin-in"></i>
          </a>
          <a class="btn btn-outline-light btn-social mx-1" href="#">
            <i class="fab fa-fw fa-dribbble"></i>
          </a>
        </div>

        <!-- Footer About Text -->
        <div class="col-lg-4">
          <h4 class="text-uppercase mb-4">About Freelancer</h4>
          <p class="lead mb-0">Freelance is a free to use, MIT licensed Bootstrap theme created by
            <a href="http://startbootstrap.com">Start Bootstrap</a>.</p>
        </div>

      </div>
    </div>
  </footer>

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
                      <input class="form-control" name="aktual" type="number" placeholder="Masukan Nilai Aktual" required="required">
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

  $prediksi1_json = json_encode($prediksi1);
  $prediksi2_json = json_encode($prediksi2);
  $prediksi3_json = json_encode($prediksi3);
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

    if(jum1<jum2){
      if(jum1<jum3){
          terbesar=jum1;
          nilai = mape1;
          warna = window.chartColors.red;
          nama = 'α = 0.5';
          prediksi = prediksi1;
      }else{
          terbesar=jum3;
          nilai = mape3;
          warna = window.chartColors.yellow;
          nama = 'α = 0.9';
          prediksi = prediksi3;


      }
    }else{
      if(jum2<jum3){
          terbesar=jum2;
          nilai = mape2;
          warna = window.chartColors.blue;
          nama = 'α = 0.7';
          prediksi = prediksi2;


      }else{
          terbesar=jum3;
          nilai = mape3;
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
          label: 'α = 0.5',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: mape1,
          fill: false,
        }, {
          label: 'α = 0.7',
          fill: false,
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: mape2,
        }, {
          label: 'α = 0.9',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: mape3,
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
              labelString: 'bulan'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Total Benar'
            },
            ticks: {
              min: 0,


              // forces step size to be 5 units
              stepSize: 5
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
              labelString: 'bulan'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Total Benar'
            },
            ticks: {
              min: 0,


              // forces step size to be 5 units
              stepSize: 5
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

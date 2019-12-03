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
            <th>prakiraan</th>
            <th width="145">rumus prakiraan
              <!-- Portfolio Item 1 -->
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          $this->db->order_by('tahun');
          $this->db->order_by('bulan');
          $data_aktual = $this->db->get('t_stok')->result();
          $data_prakiraan_awal = $this->db->get_where('t_prakiraan',array('id_prakiraan'=>1))->row();
          $no = 0;
          $prediksi = 0;
          foreach ($data_aktual as $v_da) {
            if($no == 0){?>
              <tr>
                <td><?=$data_bulan[$v_da->bulan-1]?></td>
                <td><?=$v_da->tahun?></td>
                <td><?=$v_da->aktual?></td>
                <td><?=$data_prakiraan_awal->prakiraanawal?></td>
                <td>
                  <button class="btn btn-info" data-toggle="modal" data-target="#prakiraanawal">Lihat</button>
                  <div class="portfolio-modal modal fade" id="prakiraanawal" tabindex="-1" role="dialog" aria-labelledby="portfolioModal1Label" aria-hidden="true">
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
                                $nilaiperkiraan = $data_prakiraan_awal->prakiraanawal;
                                $nilaiaktual = $v_da->aktual;

                                $prediksi =  $nilaiperkiraan - 1 + (0.2*($nilaiaktual - $nilaiperkiraan));
                                $pengurangan = $nilaiaktual - $nilaiperkiraan;
                                $kalialfa = 0.2*($nilaiaktual - $nilaiperkiraan)
                                ?>
                                <pre class="text-left">
                            Ft = Prakiraan Permintaan sekarang
                            Ft-1 = Prakiraan Permintaan yang lalu
                            α = Konstanta Eksponensial(0.2)
                            Dt-1 = Permintaan Nyata
                                </pre>
                                <pre class="text-left">
                            Ft = Ft – 1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan?> + 0.2 (<?=$nilaiaktual?> – <?=$nilaiperkiraan?>)
                            Ft = <?=$nilaiperkiraan?> + 0.2 (<?=$pengurangan?>)
                            Ft = <?=$nilaiperkiraan?> + (<?=$kalialfa?>)
                            Ft = <?=$prediksi?>

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
                <td><?=$prediksi?></td>
                <td>
                  <button class="btn btn-info" data-toggle="modal" data-target="#prakiraan">Lihat</button>
                  <div class="portfolio-modal modal fade" id="prakiraan" tabindex="-1" role="dialog" aria-labelledby="portfolioModal1Label" aria-hidden="true">
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
                                $nilaiperkiraan = $prediksi;
                                $nilaiaktual = $v_da->aktual;

                                $prediksi =  $nilaiperkiraan - 1 + (0.2*($nilaiaktual - $nilaiperkiraan));
                                $pengurangan = $nilaiaktual - $nilaiperkiraan;
                                $kalialfa = 0.2*($nilaiaktual - $nilaiperkiraan)

                                ?>
                                <pre class="text-left">
                            Ft = Prakiraan Permintaan sekarang
                            Ft-1 = Prakiraan Permintaan yang lalu
                            α = Konstanta Eksponensial(0.2)
                            Dt-1 = Permintaan Nyata
                                </pre>
                                <pre class="text-left">
                            Ft = Ft – 1 + α (Dt-1 – Ft-1)
                            Ft = <?=$nilaiperkiraan?> + 0.2 (<?=$nilaiaktual?> – <?=$nilaiperkiraan?>)
                            Ft = <?=$nilaiperkiraan?> + 0.2 (<?=$pengurangan?>)
                            Ft = <?=$nilaiperkiraan?> + (<?=$kalialfa?>)
                            Ft = <?=$prediksi?>
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

        </tbody>
      </table>
    </div>
  </section>

  <!-- About Section -->
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


            foreach ($data_aktual as $v_da) {?>
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
  <script src="<?=base_url()?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="<?=base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact Form JavaScript -->
  <script src="<?=base_url()?>assets/js/jqBootstrapValidation.js"></script>
  <script src="<?=base_url()?>assets/js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="<?=base_url()?>assets/js/freelancer.min.js"></script>

  <script>
    var prediksi = '<?=$prediksi?>';
    $('.add_prediksi_header').html(prediksi);
  </script>

</body>

</html>

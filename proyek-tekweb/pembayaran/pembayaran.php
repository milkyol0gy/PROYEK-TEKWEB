<?php 
    session_start();

    if (!isset($_SESSION['uname'])) {
        header("Location: ../sign-in.php");
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: ../sign-in.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLI n GO</title>

    <!-- <script src="C:\Users\Valencia\OneDrive\Documents\Teknologi Web F (SMT 3)\JQuery\code.jquery.com_jquery-3.7.1.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="pembayaran.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap"
    />

    <script>
      $(document).ready(function() {
        $.ajax({
            url: 'bayar.php?function=address',
            type: 'GET',
            success: function(data) {
                $('#user-address').html(data);
            },
            error: function() {
                console.log('Error fetching products.');
            }
        });

        $.ajax({
            url: 'bayar.php?function=item',
            type: 'GET',
            success: function(data) {
                $('#item-box').html(data);
            },
            error: function() {
                console.log('Error fetching products.');
            }
        });

        $.ajax({
            url: 'bayar.php?function=price',
            type: 'GET',
            success: function(data) {
                $('#harga-item').html(data);
            },
            error: function() {
                console.log('Error fetching products.');
            }
        });

        $(document).on('click', '.delivery-choice', function() {
          event.preventDefault();
          var deliveryId = $(this).closest('form').find('input[name="deliveryId"]').val();
          console.log(deliveryId);
          $.ajax({
              url: 'bayar.php?function=adminFees&id=' + deliveryId,
              type: 'GET',
              success: function(data) {
                  $('#biaya-admin').append(data);
              },
              error: function() {
                  console.log('Error fetching products.');
              }
          });
        });

        $(document).on('click', '.delivery-choice', function() {
          event.preventDefault();
          $.ajax({
            url: 'bayar.php?function=total',
            type: 'GET',
            success: function(data) {
                $('#total-harga').html(data);
            },
            error: function() {
                console.log('Error fetching products.');
            }
          });
        });


        $.ajax({
            url: 'bayar.php?function=total',
            type: 'GET',
            success: function(data) {
                $('#total-harga').html(data);
            },
            error: function() {
                console.log('Error fetching products.');
            }
        });

        var voucherId = $(this).closest('form').find('button[name="voucherButton"]').val();
        console.log('coucherId:'+voucherId);


        $.ajax({
            url: 'bayar.php?function=voucher&id=' + voucherId,
            type: 'GET',
            success: function(data) {
                $('#voucher-title').html(data);
            },
            error: function() {
                console.log('Error fetching products.');
            }
        });

        $("#btn-terapkan").click(function() {
            $.ajax({
                url: 'bayar.php?function=terapkan',
                type: 'GET',
                success: function(data) {
                    $("#voucher-applied").html(data);
                },
                error: function() {
                    console.log('Error fetching products.');
                }
            });
        });

        $("#btn-terapkan").click(function() {
          $.ajax({
            url: 'bayar.php?function=total',
            type: 'GET',
            success: function(data) {
                $('#total-harga').html(data);
            },
            error: function() {
                console.log('Error fetching products.');
            }
          });
        });

        $.ajax({
            url: 'bayar.php?function=deliveries',
            type: 'GET',
            success: function(data) {
                $('#delivery-opts').html(data);
            },
            error: function() {
                console.log('Error fetching products.');
            }
        });

      });
    </script>

</head>
<body>
    <nav class="navbar navbar-expand-sm fixed-top" id="navbar" style="background-color: whitesmoke;">
        <div class="container-fluid">
          <a class="navbar-brand" href="../homepage/homepage.php"><img src="../homepage/asset-homepage/logo bli n go 2 1.png" alt="logo" style="height: 1cm;"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link" href="../allProduct/allproduct.php" id="allproduct">All Product</a>
              </li>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
                <form action="pembayaran.php" method="post">
                    <button type="submit" class="btn btn-warning" name="logout">Log Out</button>
                </form>
                <a href="/proyek-tekweb1/keranjang/keranjang.php" class="btn"><img src="../homepage/asset-homepage/cart-shopping.svg" alt="keranjang"></a>
                <a href="/proyek-tekweb1/wishlist/wishlist.php" class="btn"><img src="../homepage/asset-homepage/wishlist.svg" alt="wishlist"></a>
            </div>
          </div>
        </div>
    </nav>

    <div class="container-pembayaran">
      <div class="container-1">
        <h6 id="judul">Pesanan</h6>
        <!-- isi keranjang -->
        <div class="box-of-items" id="item-box"></div>

        <h6 id="judul">Opsi Pengiriman</h6>
        <!-- alamat user -->
        <div class="border-box-kirim" id="user-address"></div>

        <!-- Modal Pengiriman-->
        <div class="modal fade" id="deliveryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="deliveryChoice" style="font-weight: 800;">Pilih Jasa Pengiriman</h5>
                <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
                </div>
                <div class="modal-body">
                      <!-- delivery options -->
                      <div id="delivery-opts"></div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>

        <div class="metode-bayar">
          <span id="judul">Metode Pembayaran</span>
          <span class="cod"><i>COD (Cash On Delivery)</i></span>
        </div>
      </div>

      <div class="container-2">
        <button type="button" class="btn-promo" data-bs-toggle="modal" data-bs-target="#promoModal">
          <i class="fa-solid fa-tag"></i>Apply Vouchers or Discounts
        </button>

        
        <!-- Modal Promo -->
        <div class="modal fade" id="promoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="font-weight: 800;">Pakai Promo</h5>
                <button id="reset-promo">Reset Promo</button>
                <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
                </div>
                <div class="modal-body">
                      <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="kode_promo" id="kode_promo" placeholder="Masukkan kode promo">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal" id="btn-terapkan">Terapkan</button>
                        </div>
                      </div>
                      <!-- voucher options -->
                      <label for="vouchers" class="title-vouchers">Voucher yang bisa dipakai</label>
                      <div id="voucher-title">
                        <!-- <button type="submit" class="vouchers" id="voucher15">Diskon 15%</button>
                        <button type="submit" class="vouchers" id="voucher15">Diskon 15%</button> -->
                      </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>

        <div class="ringkasan-belanja">
          <label for="ringkasan-belanja" class="ringkasan-title">Ringkasan Belanja</label>
          <label for="total-belanja" class="total-belanja">Total Belanja</label>
          <!-- total harga per item -->
          <div class="row" id="harga-item"></div>
          <label for="biaya-trans" class="total-belanja">Biaya Transaksi</label>
          <!-- biaya pengiriman, admin, dsb. -->
          <div class="row" id="biaya-admin">
            <div class='col-md-8'>
                        <p>Biaya Jasa Aplikasi</p>
                    </div>
                    <div class='col-md-4'>
                        <p>Rp. 1000</p>
                    </div>
          </div>
          <!-- vouchers -->
          <div class="row" id="voucher-applied"></div>
          <!-- total harga -->
          <div class="row" id="total-harga"></div>

          <form action="../pembayaran/completion.php">
            <button class="btn btn-success" type="button" id="bayar" name="bayar" style="width: 447px !important;" data-bs-toggle="modal" data-bs-target="#verifModal">
              <i class="fa-solid fa-money-bill"></i> Bayar
            </button>
          </form>

          <!-- Modal -->
          <div class="modal" id="verifModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Order Placed!</h5>
                  <a href="../rating/Rating.php">
                    <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </a>
                </div>
                <div class="modal-body">
                  <p>Thank you for shopping with Bli n Go! Feel free to leave a feedback about our services.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <script>
      function applyVoucher(voucherName){;
      document.getElementById("kode_promo").value = voucherName;
      }
    </script>
    
</body>
</html>
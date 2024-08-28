@extends('layouts.app')

@section('title')
  eBengkelku - Login
@endsection

@section('content')
  @php

    if (Session::has('id_pelanggan')) {
        header('Location: ' . route('home'));
        exit();
    }

    $page = 'login';

    if (isset($_GET['register'])) {
        $page = 'register';
    }
  @endphp


  <section class="section section-white"
    style="position: relative;overflow: hidden;padding-top: 100px;padding-bottom: 20px;">

    <div
      style="background-image: url(<?= url('logos/wallpaper.png') ?>);background-size: cover;background-position: center;background-attachment: fixed;background-repeat: no-repeat;position: absolute;width: 100%;top: 0;bottom: 0;left: 0;right: 0;">
    </div>
    <div class="bg-white" style="position: absolute;width: 100%;top: 0;bottom: 0;left: 0;right: 0;opacity: 0.7;"></div>

    <div class="container">

      <div class="row">
        <div class="col-md-12" align="center">
          <h4 class="text-primary">
            Join With Us
          </h4>
        </div>
      </div>

    </div>
  </section>

  <section class="section bg-white" style="padding-top: 50px;padding-bottom: 50px;">

    <div class="container">

      <div class="row">
        <div class="col-md-4">
          &nbsp;
        </div>
        <div class="col-md-4">

          <a href="<?= route('login') ?>">
            <button type="button" class="btn btn-sm btn-<?= $page == 'login' ? 'primary' : 'outline-primary' ?>"
              style="cursor: pointer;">
              <i class='fa-solid fa-arrow-right-to-bracket'></i> Login
            </button>
          </a>

          <a href="?register=data">
            <button type="button" class="btn btn-sm btn-<?= $page == 'register' ? 'primary' : 'outline-primary' ?>"
              style="cursor: pointer;">
              <i class='fa-solid fa-user-plus'></i> Register
            </button>
          </a>

          <p>&nbsp;</p>

          <?php if (isset($_GET['register'])) { ?>

          @include('login.register')

          <?php } else { ?>

          <div class="card">
            <div class="card-body">
              <div class="card-title"><b><img src="<?= url('logos/icon.png') ?>" style="width: 25px;"> Please Login</b>
              </div>
              <p>&nbsp;</p>

              @php
                if (session()->has('alert')) {
                    $explode = explode('_', session()->get('alert'));
                    echo '
                                                                                                                                                                                                                              <div class="alert alert-' .
                        $explode[0] .
                        '"><i class="fa-solid fa-circle-exclamation"></i> ' .
                        $explode[1] .
                        '</div>
                                                                                                                                                                                                                            ';
                }
              @endphp

              <form method="POST" enctype="multipart/form-data" action="<?= route('login.signin') ?>">
                <?= csrf_field() ?>

                <label>Email</label>
                <input type="email" name="email" value="<?= old('email') ?>" class="form-control" required=""
                  maxlength="255" placeholder="Required ..."><br>

                <label>Password</label>
                <input type="password" name="password" value="<?= old('password') ?>" class="form-control" required=""
                  maxlength="255" placeholder="Required ..."><br>

                <button type="submit" class="btn btn-sm btn-primary">
                  <i class='fa-solid fa-arrow-right-to-bracket'></i> Login
                </button>

                <p>&nbsp;</p>

                <p id="ellipsis" class="text-info" style="cursor: pointer;" data-toggle="modal"
                  data-target="#forgot_password">
                  Forgot password?
                </p>

              </form>

            </div>
          </div>

          <?php } ?>

        </div>
      </div>

    </div>
  </section>
@endsection

@section('script')
  <!-- Classic Modal -->
  <div class="modal fade" id="forgot_password" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <table style="width: 100%;">
            <tbody>
              <tr>
                <td>
                  <b>
                    <img src="<?= url('logos/icon.png') ?>" style="width: 25px;"> Forgot Your Password
                  </b>
                </td>
                <td align="right">
                  <span class="text-danger" data-dismiss="modal" style="cursor: pointer;">
                    <i class='fa-solid fa-circle-exclamation' style="font-size: 17px;"></i>
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-body">

          <?php
          if (session()->has('alert')) {
              $explode = explode('_', session()->get('alert'));
              echo '
                                                                                                                                                                                                                                                                                                                                    <div class="alert alert-' .
                  $explode[0] .
                  '"><i class="fa-solid fa-circle-exclamation"></i> ' .
                  $explode[1] .
                  '</div>
                                                                                                                                                                                                                                                                                                                                  ';
          }
          ?>

          <form method="POST" enctype="multipart/form-data" action="<?= route('login.forgot') ?>">
            <?= csrf_field() ?>

            <label>Email</label>
            <input type="email" name="email" value="<?= old('email') ?>" class="form-control" required=""
              maxlength="255" placeholder="Required ..."><br>

            <button type="submit" class="btn btn-sm btn-primary">
              <i class='fa-solid fa-envelope-circle-check'></i> Send to email
            </button>

          </form>

        </div>
      </div>
    </div>
  </div>
  <!--  End Modal -->
@endsection

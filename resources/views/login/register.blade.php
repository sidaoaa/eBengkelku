<div class="card">

  <div class="card-body">

    <div class="card-title"><b><img src="<?= url('logos/icon.png') ?>" style="width: 25px;"> Register Now</b></div>

    <p>&nbsp;</p>

    @php
      if (session()->has('alert')) {
          $explode = explode('_', session()->get('alert'));

          echo '
      
                <div class="alert alert-' .
              $explode[0] .
              '"><i class="bx bx-error-circle"></i> ' .
              $explode[1] .
              '</div>
      
              ';
      }
    @endphp


    <form method="POST" enctype="multipart/form-data" action="<?= route('login.register') ?>">

      @csrf

      <label>Full Name</label>

      <input type="nama" name="nama" value="<?= old('nama') ?>" class="form-control" required="" maxlength="255"
        placeholder="Required ..."><br>



      <label>Phone</label>

      <input type="number" name="telp" value="<?= old('telp') ?>" class="form-control" required="" maxlength="15"
        placeholder="Required ..."><br>



      <label>Email</label>

      <input type="email" name="email" value="<?= old('email') ?>" class="form-control" required=""
        maxlength="255" placeholder="Required ..."><br>



      <label>Password</label>

      <input type="password" name="password" value="<?= old('password') ?>" class="form-control" required=""
        maxlength="255" placeholder="Required ..."><br>



      <button type="submit" class="btn btn-sm btn-primary">

        <i class='fa-solid fa-user-plus'></i> Register

      </button>



    </form>



  </div>

</div>

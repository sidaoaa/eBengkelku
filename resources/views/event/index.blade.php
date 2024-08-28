@extends('layouts.app')


@section('title')
  eBengkelku - Event
@endsection

@section('content')
  <section class="section section-white"
    style="position: relative;overflow: hidden;padding-top: 100px;padding-bottom: 20px;">

    <div
      style="background-image: url(<?= url('logos/wallpaper.png') ?>);background-size: cover;background-position: center;background-attachment: fixed;background-repeat: no-repeat;position: absolute;width: 100%;top: 0;bottom: 0;left: 0;right: 0;">
    </div>
    <div class="bg-white" style="position: absolute;width: 100%;top: 0;bottom: 0;left: 0;right: 0;opacity: 0.7;"></div>

    <div class="container">

      <div class="row">
        <div class="col-md-12" align="center">
          <h4 class="text-primary">See Our Event</h4>
        </div>
      </div>
    </div>
  </section>
@endsection

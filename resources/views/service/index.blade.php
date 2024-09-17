@extends('layouts.app')


@section('title')
    eBengkelku - Workshop
@endsection

@section('content')
    @php
        $search = request()->get('search', '');
    @endphp

    <section class="section bg-white" style="padding-top: 50px;padding-bottom: 50px;">
        <div class="container">

            <div class="row">
                <div class="col-md-4">
                    <form method="GET">
                        <div class="input-group">
                            @if (request()->has('spare_parts'))
                                <input type="hidden" name="spare_parts" value="data" class="form-control" required
                                    maxlength="255" placeholder="Harap di isi ...">
                            @endif

                            <<input type="text" name="search" value="{{ old('search', $search) }}" required
                                maxlength="255" placeholder="Ketik kata kunci ..." class="form-control">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class='fa-solid fa-search-alt'></i>
                                    </button>
                                </div>

                        </div>
                    </form>
                    <p>&nbsp;</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">

                        <a href="<?= route('services') ?>">
                            <button type="button"
                                class="btn btn-sm btn-<?= $page == 'services' ? 'primary' : 'outline-primary' ?>">
                                Services
                            </button>
                        </a>

                        <a href="?spare_parts=data">
                            <button type="button"
                                class="btn btn-sm btn-<?= $page == 'spare_parts' ? 'primary' : 'outline-primary' ?>">
                                Spare Parts
                            </button>
                        </a>

                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>

            <?php if(isset($_GET['spare_parts'])){ ?>

            @include('services.spare_parts')

            <?php }else{ ?>

            @include('services.services')

            <?php } ?>

        </div>
    </section>
    =======
    <section class="section section-white"
        style="position: relative;overflow: hidden;padding-top: 100px;padding-bottom: 20px;">

        <div
            style="background-image: url(<?= url('logos/wallpaper.png') ?>);background-size: cover;background-position: center;background-attachment: fixed;background-repeat: no-repeat;position: absolute;width: 100%;top: 0;bottom: 0;left: 0;right: 0;">
        </div>
        <div class="bg-white" style="position: absolute;width: 100%;top: 0;bottom: 0;left: 0;right: 0;opacity: 0.7;"></div>

        <div class="container">

            <div class="row">
                <div class="col-md-12" align="center">
                    <h4 class="text-primary">See Our Workshop</h4>
                </div>
            </div>
        </div>
    </section>
@endsection

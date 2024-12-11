@extends('layouts.default')
@section('content')
<section class="hero-wrap hero-wrap-2" style="background-image: url(https://it.maranatha.edu/wp-content/uploads/2016/09/GWM-Lt.8-Lab-Komputer-IT-Maranatha.jpg);" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs mb-2"><span class="mr-2"><a href="{{ route('home') }}">Beranda <i class="fa fa-chevron-right"></i></a></span> <span>Ruangan <i class="fa fa-chevron-right"></i></span></p>
          <h1 class="mb-0 bread">Daftar Ruangan</h1>
        </div>
      </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            @php
                $rooms = [
                    ['name' => 'Ruang Networking', 'capacity' => 20],
                    ['name' => 'Programming 1', 'capacity' => 25],
                    ['name' => 'Programming 2', 'capacity' => 25],
                    ['name' => 'Enterprise 1', 'capacity' => 30],
                    ['name' => 'Enterprise 2', 'capacity' => 30],
                    ['name' => 'Internet 1', 'capacity' => 20],
                    ['name' => 'Internet 2', 'capacity' => 20],
                    ['name' => 'Advance Programming 1', 'capacity' => 15],
                    ['name' => 'Advance Programming 2', 'capacity' => 15],
                    ['name' => 'Advance Programming 3', 'capacity' => 15],
                    ['name' => 'Advance Programming 4', 'capacity' => 15],
                    ['name' => 'Database', 'capacity' => 20],
                    ['name' => 'Multimedia', 'capacity' => 25],
                ];
            @endphp

            @foreach ($rooms as $room)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img 
                        src="{{ asset('images/default-room.jpg') }}" 
                        class="card-img-top" 
                        alt="Gambar {{ $room['name'] }}" 
                        style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $room['name'] }}</h5>
                        <p class="card-text">Kapasitas: {{ $room['capacity'] }} orang</p>
                        <button class="btn btn-primary" id="buttonBorrowRoomModal" 
                            data-room-name="{{ $room['name'] }}" 
                            data-room-id="{{ $loop->index + 1 }}" 
                            data-toggle="modal" 
                            data-target="#borrowRoomModal">
                            Pinjam Sekarang
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="borrowRoomModal" tabindex="-1" role="dialog" aria-labelledby="borrowRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="borrowRoomModalLabel">Pinjam Ruang - Nama Ruang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="borrowRoomForm" method="POST" action="{{ route('api.v1.borrow-room-with-college-student', []) }}" class="appointment-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="full_name" value="{{ old('full_name') }}" type="text" class="form-control" placeholder="Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-wrap">
                                    <div class="icon"><span class="ion-md-calendar"></span></div>
                                    <input id="borrow_at" name="borrow_at" value="{{ old('borrow_at') }}" type="text" class="form-control appointment_date-check-in datetimepicker-input" placeholder="Tgl Mulai" data-toggle="datetimepicker" data-target="#borrow_at" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-wrap">
                                    <div class="icon"><span class="ion-md-calendar"></span></div>
                                    <input id="until_at" name="until_at" value="{{ old('until_at') }}" type="text" class="form-control appointment_date-check-out datetimepicker-input" placeholder="Tgl Selesai" data-toggle="datetimepicker" data-target="#until_at" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="room" value="{{ old('room') }}" type="text" class="form-control" placeholder="Nama Ruangan" readonly required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="nim" value="{{ old('nim') }}" type="text" class="form-control" placeholder="NIM" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Pinjam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@section('scripts')
<script>
    $(document).ready(function () {
    // Handle form submission
    $('#borrowRoomForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize(); // Serialize form data
        let formAction = $(this).attr('action'); // Get form action URL

        $.ajax({
            url: formAction,
            method: 'POST',
            data: formData,
            success: function (response) {
                // Show success message
                $('#successAlert').removeClass('d-none');

                // Close the modal
                $('#borrowRoomModal').modal('hide');

                // Reset the form
                $('#borrowRoomForm')[0].reset();
            },
            error: function (xhr) {
                // Handle error (optional)
                alert('Terjadi kesalahan, silakan coba lagi.');
            }
        });
    });
});

    $(document).on('click', '#buttonBorrowRoomModal', function() {
        var roomName = $(this).data('room-name');
        var roomId = $(this).data('room-id');

        $('input[name="room"]').val(roomId);
        $('#borrowRoomModalLabel').text('Pinjam Ruang - ' + roomName);
    });

    $(document).ready(function () {
    $('#borrow_at, #until_at').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        icons: {
            time: 'fa fa-clock',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-sun',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        }
    });
});
</script>
@endsection
@endsection

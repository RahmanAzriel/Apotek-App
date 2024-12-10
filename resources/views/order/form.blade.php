@extends('layouts.layout')
@section('content')
    <div class="container mt-3">
        <form action="{{ route('purchase.store') }}" class="card m-auto p-5" method="POST">
            @csrf
            {{-- Display validation error messages --}}
            @if ($errors->any())
                <ul class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            @if (Session::get('failed'))
                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @endif

            <p>Penanggung Jawab : <b>{{ Auth::user()->name }}</b></p>

            <div class="mb-3 row">
                <label for="name_customer" class="col-sm-2 col-form-label">Nama Pembeli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name_customer" name="name_customer">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="medicines" class="col-sm-2 col-form-label">Obat</label>
                <div class="col-sm-10">
                    <select name="medicines[]" id="medicines" class="form-select">
                        <option selected hidden disabled>---Pilih Obat---</option>
                        @foreach ($medicines as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }} (Stock: {{ $item['stock'] }})</option>
                        @endforeach
                    </select>
                    <div id="wrap-medicines"></div>
                    <br>
                    <p style="cursor: pointer;" class="text-primary" id="add-select">+ Add Medicines</p>
                </div>
            </div>
            <button type="submit" class="btn btn-block btn-lg btn-primary">Konfirmasi Pembelian</button>
        </form>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        let no = 2;
        // Ubah data medicines menjadi JSON agar bisa digunakan di JavaScript
        let medicines = @json($medicines);

        $("#add-select").on("click", function() {
            let options = '<option selected hidden disabled>Orders ' + no + '</option>';
            // Loop di JavaScript untuk menampilkan options
            medicines.forEach(function(item) {
                options += `<option value="${item.id}">${item.name} (Stock: ${item.stock})</option>`;
            });

            let html = `<br><select name="medicines[]" id="medicines" class="form-select">${options}</select>`;
            $("#wrap-medicines").append(html);
            no++;
        });
    </script>
@endpush

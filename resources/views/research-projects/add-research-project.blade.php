@extends('layouts.base')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/research-projects"><i class="fas fa-book"></i></a></li>
    <li class="breadcrumb-item"><a href="/research-projects/create">Research Projects</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Research Projects</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Add Research Projects</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form method="post" action="/research-projects">
                        @csrf

                        <div class="form-group">
                            <div class="input-group">
                                <textarea  value="{{ old('principal_investigator') }}"  name="principal_investigator"  placeholder="Prinipal investigator" class="form-control @error('principal_investigator') is-invalid @enderror"></textarea>
                            </div>
                            @error('principal_investigator')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <textarea  value="{{ old('grant_details') }}"  name="grant_details"  placeholder="Grant Details" class="form-control @error('grant_details') is-invalid @enderror"></textarea>
                            </div>
                            @error('grant_details')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <textarea  value="{{ old('title') }}"  name="title"  placeholder="Title" class="form-control @error('title') is-invalid @enderror"></textarea>
                            </div>
                            @error('title')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <textarea  value="{{ old('amount') }}"  name="amount"  placeholder="Amount" class="form-control @error('amount') is-invalid @enderror"></textarea>
                            </div>
                            @error('amount')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="date" value="{{ old('year') }}" name="year"  placeholder="Year" class="form-control @error('year') is-invalid @enderror"></input>
                            </div>
                            @error('year')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section ('custom-script')
    <script src="{{ asset("/js/shape/add-shape.js") }}"></script>

    @if(session()->has('type'))
        <script>
            $.notify({
                // options
                title: '<h4 style="color:white">{{ session('title') }}</h4>',
                message: '{{ session('message') }}',
            },{
                // settings
                type: '{{ session('type') }}',
                allow_dismiss: true,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3000,
                timer: 1000,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                }
            });
        </script>
    @endif
@endsection

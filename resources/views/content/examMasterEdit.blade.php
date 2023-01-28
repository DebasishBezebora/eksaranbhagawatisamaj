@extends('layout.content')
@section('main-section')
@push('breadcrumbs')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Exam Master Edit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Exam Master Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endpush

<div class="card-body">
    <div class="row">
        <div class="col-6">
            
            <form action="{{url('/')}}/exam-master/{{ $data1->EID }}" method="POST">
                @if(Session::has('Success'))
                    <div class="alert alert-success">{{Session::get('Success')}}</div>
                @endif
                @if(Session::has('Fail'))
                    <div class="alert alert-danger">{{Session::get('Fail')}}</div>
                @endif
                @csrf
                <input type="hidden" name="_method" value="PUT" />
                <div class="input-group mb-3">
                    <input type="text" name="name" id="" class="form-control" placeholder="Exam Name" value="{{ $data1->Exam_Name }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <small id="helpId" class="col-12 text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="input-group mb-3">
                    <div class="custom-control custom-radio" style="margin-right:10px;">
                        <input class="custom-control-input" type="radio" id="status1" name="exam_type" value="1" @if ($data1->Exam_Type == 1) checked="checked" @endif>
                        <label for="status1" class="custom-control-label">Even </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="status2" name="exam_type" value="0" @if ($data1->Exam_Type == 0) checked="checked" @endif>
                        <label for="status2" class="custom-control-label">Odd</label>
                    </div>
                    <small id="helpId" class="col-12 text-danger">
                        @error('exam_type')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="exam_category" id="" class="form-control" placeholder="Category" value="{{ $data1->Exam_Category }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <small id="helpId" class="col-12 text-danger">
                        @error('exam_category')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('sub-category.index') }}">Մենյուի բաժիններ </a></li>
                                        <li class="breadcrumb-item active">Փոփոխել</li>
                                    </ol>
                                </nav>
                            </h5>

                            <form action="{{ route('sub-category.update', $data->id) }}" method="post" enctype="multipart/form-data">
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-3 col-form-label">Վերնագիր </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="title"
                                            placeholder="Վերնագիր" value="{{ $data->title }}" >

                                        @error('title')
                                            <div class="mb-3 row ">
                                                <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                                </p>
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-3 col-form-label">Բովանդակություն </label>
                                    <div class="col-sm-9">

                                         <textarea class="tinymce-editor" name="content">{!! $data->content !!}</textarea>


                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary">Ստեղծել</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
        </section>

    </main><!-- End #main -->
@endsection

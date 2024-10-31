@extends('layouts.app')

@section('content')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Ենթամենյուի բաժիններ</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="{{ route('sub-category.index')}}">Ցանկ</a></li>
                <li class="breadcrumb-item active">Ստեղծել</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Ստեղծել նոր ենթաբաժին </h5>

                            <form action="{{ route('sub-category.store') }}" method="post" enctype="multipart/form-data">

                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-3 col-form-label">Մենյուի բաժիններ </label>
                                    <div class="col-sm-9">
                                        <select class="form-select" aria-label="Default select example"
                                            name ="category_id">
                                            <option value='' disabled>Մենյուի բաժիններ</option>

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="mb-3 row ">
                                                <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                                </p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-3 col-form-label">Վերնագիր </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="title"
                                            placeholder="Վերնագիր" value="{{ old('title') }}">
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

                                         <textarea class="tinymce-editor" name="content">
                                            <p>Hello World!</p>
                                            <p>This is TinyMCE <strong>full</strong> editor</p>
                                        </textarea>

                                        @error('content')
                                            <div class="mb-3 row ">
                                                <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                                </p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="row mb-3">
                                    <label for="items" class="col-sm-3 col-form-label">Ֆայլեր </label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" id="items" name="items[]" multiple>
                                        @error('items')
                                            <div class="mb-3 row ">
                                                <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                                </p>
                                            </div>
                                        @enderror
                                    </div>
                                </div> --}}


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


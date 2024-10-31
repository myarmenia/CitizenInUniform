@extends('layouts.app')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Ենթամենյուի բաժիններ</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="{{ route('sub-category.index')}}">Ցանկ</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="pull-left">
                                <div class = "d-flex justify-content-between">
                                    <h5 class="card-title">Ենթամենյուի բաժիններ</h5>
                                    <div class="pull-right d-flex justify-content-end m-3" >
                                        <a class="btn btn-primary  mb-2" href="{{ route('category.create')}}"><i class="fa fa-plus"></i> Ստեղծել նոր բաժին</a>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>Հ/Հ</th>
                                        <th>Վերնագիր</th>
                                        <th width="10%">Գործողություն</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $sub_category)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $sub_category->title }}</td>
                                            <td>
                                                <div class="dropdown action"data-id="{{ $sub_category->id }}" data-tb-name="category">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{route('sub-category.edit', $sub_category->id)}}"><i
                                                                class="bx bx-edit-alt me-1"></i>Խմբագրել</a>
                                                        <button type="button" class="dropdown-item click_delete_item"
                                                            data-bs-toggle="modal" data-bs-target="#smallModal"><i
                                                                class="bx bx-trash me-1"></i>
                                                            Ջնջել</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Bordered Table -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

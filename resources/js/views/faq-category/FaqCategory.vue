<template>
   <main id="main" class="main">



    <section class="section">
    <div class="row">

        <div class="col-lg-12">
        <div class="card">

            <div class="card-body">
                <div class = "d-flex justify-content-between">
                    <h5 class="card-title">

                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Աշխատակիցների/Այցելուների ցանկ</li>

                        </ol>
                    </nav>

                    </h5>
                    <div class="pull-right d-flex justify-content-end m-3" >
                        <router-link class="nav-link"  to="/faq-categories/create">



                        <i class="fa fa-plus"></i> Ստեղծել
                        </router-link>
                    </div>

                </div>
            <!-- Bordered Table -->

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Հ/Հ</th>
                    <th scope="col">ID</th>
                    <th scope="col">Նույնականացման կոդ</th>
                    <th scope="col">Նկար</th>
                    <th scope="col">Անուն</th>
                    <th scope="col">Ազգանուն</th>

                    <th scope="col">Հեռախոսահամար</th>
                    <th scope="col">Տեսակ</th>
                    <th scope="col">Գործողություն</th>
                </tr>
                </thead>
                <tbody>




                            <tr>
                                <td>1</td>
                                <th scope="row">1</th>
                                <th scope="row">1</th>
                                <td>

                                </td>
                                <td>


                                </td>
                                <td>


                                </td>
                                <td>

                                </td>
                                <td>

                                </td>

                                <td>

                                    <div class="dropdown action"data-id="4" data-tb-name="people">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>

                                        <div class="dropdown-menu">

                                                <a class="dropdown-item d-flex" href="javascript:void(0);">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input change_status" type="checkbox"
                                                            role="switch" data-field-name="status"
                                                          >
                                                    </div>Կարգավիճակ
                                                </a>


                                                <a class="dropdown-item d-flex" href="javascript:void(0);">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input change_status" type="checkbox"
                                                            role="switch" data-field-name="activation"
                                                           >
                                                    </div>Ակտիվացում
                                                </a>



                                            <a class="dropdown-item" href=""><i
                                                class="bx bx-edit-alt me-1"></i>Ժամանակացույց</a>




                                            <a class="dropdown-item" href=""><i
                                                    class="bx bx-edit-alt me-1"></i>Խմբագրել</a>
                                            <button type="button" class="dropdown-item click_delete_item"
                                                data-bs-toggle="modal" data-bs-target="#smallModal"><i
                                                    class="bx bx-trash me-1"></i>
                                                Ջնջել</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>





                </tbody>
            </table>

            <!-- End Bordered Table -->

            <!-- @if( $data !=null && count($data)>0)
                <div class="demo-inline-spacing">
                    {{ $data->links() }}
                </div>
                @endif -->
            </div>


        </div>





        </div>

    </div>

    </section>


</main>
</template>

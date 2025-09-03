@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'RTS | Login')
@section('content')
        <!-- Content -->
        <div class="container mt-10">
            <div class="col-md-6 offset-3">
                <div
                class="authentication-wrapper authentication-basic container-p-y"
             >
                <div class="authentication-inner">
                    <!-- Register -->
                    <div class="card px-sm-6 px-0">
                        <div class="card-body">
                            <!-- Logo -->
                            <div class="app-brand justify-content-center mb-8">
                                <a
                                    href="index.html"
                                    class="app-brand-link gap-2"
                                >
                                   
                                    <span
                                        class="app-brand-text demo text-heading fw-bold"
                                        >ADMIN</span
                                    >
                                </a>
                            </div>
                       
                           

                            <form
                                id="formAuthentication"
                                class="mb-6"
                                method="post"
                                action="{{ route('login') }}"
                            >
                            @csrf
                                <div class="mb-4">
                                    <label for="email" class="form-label"
                                        >Email</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        placeholder="Enter your email or username"
                                        autofocus
                                    />
                                </div>
                                <div class="mb-6 form-password-toggle">
                                    <label class="form-label" for="password"
                                        >Password</label
                                    >
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="password"
                                            id="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password"
                                        />
                                        <span
                                            class="input-group-text cursor-pointer"
                                            ><i class="bx bx-hide"></i
                                        ></span>
                                    </div>
                                </div>
                                
                                <div class="">
                                    <button
                                        class="btn btn-primary d-grid w-100"
                                        type="submit"
                                    >
                                        Login
                                    </button>
                                </div>
                            </form>

                        
                        </div>
                    </div>
                    <!-- /Register -->
                </div>
            </div>
            </div>
        </div>

        <!-- / Content -->

    

        @endsection
@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'Admin | Register')
@section('content')
    <!-- Content -->
    <div class="container mt-10">
        <div class="col-md-6 offset-3">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner">
                    <!-- Register Card -->
                    <div class="card px-sm-6 px-0">
                        <div class="card-body">
                            <!-- Logo -->
                            <div class="app-brand justify-content-center mb-8">
                                <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                    <span class="app-brand-text demo text-heading fw-bold">ADMIN</span>
                                </a>
                            </div>

                            <!-- Register Form -->
                            <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('register') }}">
                                @csrf
                                {{-- Name --}}
                                <div class="mb-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        name="name"
                                        placeholder="John Doe"
                                        required
                                    />
                                </div>

                                {{-- Email --}}
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        placeholder="example@email.com"
                                        required
                                    />
                                </div>

                                {{-- Password --}}
                                <div class="mb-4 form-password-toggle">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="password"
                                            id="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="********"
                                            required
                                        />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="mb-4 form-password-toggle">
                                    <label class="form-label" for="confirm_password">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="password"
                                            id="confirm_password"
                                            class="form-control"
                                            name="confirm_password"
                                            placeholder="********"
                                            required
                                        />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>

                                {{-- Hidden Role: Always Vendor --}}
                                <input type="hidden" name="roles[]" value="vendor">

                                {{-- Submit --}}
                                <div class="mb-4">
                                    <input class="btn btn-primary d-grid w-100" type="submit">
                                </div>
                            </form>
                            <!-- /Register Form -->

                        </div>
                    </div>
                    <!-- /Register Card -->
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
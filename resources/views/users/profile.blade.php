@extends('layouts.base')
@section('main')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-body d-flex flex-column">
                        <form action="{{ route('user-profile-information.update') }}"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="d-flex flex-column mb-7 col-md-6 fv-row">
                                    <label for="email"
                                           class="fw-bold form-label text-dark mb-2">{{ __('Addresse mail') }}</label>

                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') ?? auth()->user()->email }}" required readonly
                                           autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column mb-7 col-md-6 fv-row">
                                    <label for="name" class="fw-bold form-label text-dark mb-2">{{ __('Nom') }}</label>
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') ?? auth()->user()->name }}" required
                                           autocomplete="name">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex flex-column mb-7 col-md-6 fv-row">
                                    <label for="name"
                                           class="fw-bold form-label text-dark mb-2">{{ __('Avatar') }}</label>
                                    <input type="file" id="avatar" class="form-control form-control-file @error('avatar') is-invalid @enderror"
                                           name="avatar"/>
                                    @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col offset-md-0">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Enregistrer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row gy-5 g-xl-8">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-body d-flex flex-column">
                        <form action="{{ route('user-password.update') }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="d-flex flex-column mb-7 col-md-6 fv-row">
                                    <label for="current_password"
                                           class="fw-bold form-label text-dark mb-2">{{ __('Mot de passe actuel') }}</label>

                                    <input id="current_password" type="password"
                                           class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                           name="current_password"
                                           required autocomplete="new-password">

                                    @error('current_password', 'updatePassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex flex-column mb-7 col-md-6 fv-row">
                                    <label for="password"
                                           class="fw-bold form-label text-dark mb-2">{{ __('Mot de passe') }}</label>

                                    <input id="password" type="password"
                                           class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                           name="password"
                                           required autocomplete="new-password">

                                    @error('password', 'updatePassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex flex-column mb-7 col-md-6 fv-row">
                                    <label for="password-confirm"
                                           class="fw-bold form-label text-dark mb-2">{{ __('Confirmer mot de passe') }}</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col offset-md-0">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Enregistrer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

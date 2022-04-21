@extends("layouts.auth")

@section('main')
    <form class="form w-100" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="fv-row mb-7">
            <label class="form-label fw-bolder text-dark fs-6">{{__('Nom et Prénoms')}}</label>
            <input class="form-control form-control-lg form-control-solid  @error('name') is-invalid @enderror"
                   type="text" placeholder="" name="name"
                   value="{{ old('name') }}" required autocomplete="name" autofocus/>
            @error('name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="fv-row mb-7">
            <label for="city" class="form-label fw-bolder text-dark fs-6">{{__('Ville')}}</label>
            <select class="form-control form-control-lg form-control-solid  @error('city') is-invalid @enderror"
                    name="city" required>
                <option value="Ouagadougou">Ouagadougou</option>
                <option value="Lomé">Lomé</option>
            </select>
            @error('city')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <label class="form-label fw-bolder text-dark fs-6">{{__('Email')}}</label>
            <input class="form-control form-control-lg form-control-solid  @error('email') is-invalid @enderror"
                   type="email" placeholder="" name="email" value="{{ old('email') }}"
                   required autocomplete="email"/>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="mb-10 fv-row" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Label-->
                <label class="form-label fw-bolder text-dark fs-6">{{ __('Mot de passe') }}</label>
                <!--end::Label-->
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder=""
                           name="password" autocomplete="off"/>
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                          data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
            <!--end::Input wrapper-->
                <!--begin::Meter-->
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
                <!--end::Meter-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Hint-->
            <div class="text-muted">{{ __('Utiliser 8 caractères ou plus. Combiner avec des chiffres, des lettres & des symboles pour plus de sécurité.') }}</div>
            <!--end::Hint-->
        </div>
        <!--end::Input group=-->
        <!--begin::Input group-->
        <div class="fv-row mb-5">
            <label class="form-label fw-bolder text-dark fs-6">{{ __('Confirmer le mot de passe')}}</label>
            <input class="form-control form-control-lg form-control-solid" type="password" placeholder=""
                   name="password_confirmation" autocomplete="new-password"/>
        </div>
        <!--end::Input group-->
        <div class="text-center">
            <button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-primary">
                <span class="indicator-label">{{ __('Valider') }}</span>
                <span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
@endsection

<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
    <!--begin::Page title-->
    <div class="page-title d-flex flex-column me-3">
        <!--begin::Title-->
        <h1 class="d-flex text-white fw-bolder my-1 fs-3">{{ $title }}</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-white opacity-75">
                <a href="/home" class="text-white text-hover-primary">Accueil</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-white opacity-75">{{ $breadcrumb1 ?? '' }}</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
    <!--begin::Actions-->
    <div class="d-flex align-items-center py-3 py-md-1">
        <!--begin::Button-->
        <a href="{{ route('transfert.index') }}" class="btn btn-bg-white btn-active-color-primary"
           id="kt_toolbar_primary_button">{{ __('Transferts') }}</a>
        <!--end::Button-->
    </div>
    <!--end::Actions-->
</div>

@extends("layouts.base")
@section('main')

    <div class="row">
        <div class="col-xxl-12">
            <div class="card card-xxl-stretch mb-5 mb-xl-8">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex flex-stack flex-wrap">
                        <div class="me-2">
                            <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">Utilisateurs</a>
                            <div class="text-muted fs-7 fw-bold">Gestions des utilisateurs</div>
                        </div>
                        <div class="fw-bolder fs-3 text-primary">3</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                            <tr>
                                <th class="col-1 text-center">N°</th>
                                <th class="col-1">Avatar</th>
                                <th>Nom et prénom</th>
                                <th>Adresse mail</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="text-center">{{$user->id}}</td>
                                    <td>
                                        <img class="h-30px w-30px rounded"
                                             src="{{ $user->avatar ?? asset('assets/media/avatars/blank.png')}}"
                                             alt=""/>
                                    </td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if (auth()->user()->id != $user->id)
                                            <button class="btn btn-sm btn-danger btn-icon" onclick="deleteUserRecord('{{$user->id}}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                            <form id="remove-form-{{$user->id}}"
                                                  action="{{ route('utilisateurs.destroy', $user->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteUserRecord(id) {
            if (confirm('Souhaitez-vous vraiment supprimer?')) {
                document.getElementById('remove-form-' + id).submit();
            }
        }
    </script>
@endsection

@extends('layouts/admin')

@section('content')
    <div class="row">
        <div class="my-4">
            <a href="/admin/addiblock">
                <button type="submit" class="btn btn-primary">Создать iblock</button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="d-flex flex-column justify-content-start dashboard">
            @foreach($iblocks as $iblock)

                <div class="col-12 card d-flex flex-row">
                    <div class="card-body">
                        <a href="/admin/{{$iblock->id}}/iblockedit">
                            <h5 class="card-title">{{$iblock->name}}</h5>
                        </a>
                        <a href="#">
                            <a href="/admin/{{$iblock->id}}/elementlist">
                                <button class="btn btn-primary">элементы</button>
                            </a>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

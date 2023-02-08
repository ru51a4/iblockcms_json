@extends('layouts/admin')

@section('content')
    <div class="row">
        <div class="my-4">
            @foreach($breadcrumb as $item)
                <a href="/admin/{{$item["id"]}}/elementlist">{{$item["name"]}}</a>
                @if(end($breadcrumb) != $item)
                    -
                @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="my-4">
            <a href="/admin/{{$iblock->id}}/delete">
                <button class="btn btn-danger">delete</button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="/admin/{{$iblock->id}}/iblockedit" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">iblock name</label>
                        <input type="text" value="{{$iblock->name}}" class="form-control" name="name">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">изменить</button>
                    </div>
                </form>
                @foreach($iblock->properties as $prop)
                    <form action="/admin/{{$iblock->id}}/deletepropery">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">{{$prop->name}}</label>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">is_number - {{$prop->is_number}}</label>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">is_multy - {{$prop->is_multy}}</label>
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="id" value="{{$prop->id}}" class="btn btn-danger">удалить</button>
                        </div>
                    </form>
                @endforeach
                <form action="/admin/{{$iblock->id}}/propertyadd" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">название проперти</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="mb-3">
                        <label>is_number</label>
                        <input type="checkbox" id="is_number" name="is_number">
                    </div>
                    <div class="mb-3">
                        <label>is_multy</label>
                        <input type="checkbox" id="is_multy" name="is_multy">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">добавить property</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

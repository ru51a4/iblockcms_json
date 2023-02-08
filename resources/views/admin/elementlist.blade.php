@extends('layouts/admin')

@section('content')
    <div class="row">
        <div class="my-4">
            <a href="/admin/{{$iblock->id}}/addelement">
                <button type="submit" class="btn btn-primary">Создать элемент</button>
            </a>
        </div>
        <div class="my-4">
            <a href="/admin/">Home</a> /
        @foreach($breadcrumb as $item)
                <a href="/admin/{{$item["id"]}}/elementlist">{{$item["name"]}}</a>
                @if(end($breadcrumb) != $item)
                    /
                @endif
            @endforeach
        </div>
        <hr>
    </div>
    <div class="row">
        <div class="d-flex flex-column justify-content-start dashboard">
            @foreach($iblocks as $el)
                <div class="col-12 card d-flex flex-row">
                    <div class="card-body">
                        <a href="/admin/{{$el->id}}/iblockedit">
                            <h5 class="card-title">{{$el->name}}</h5>
                        </a>
                        <a href="/admin/{{$el->id}}/elementlist">
                            <button class="btn btn-primary">элементы</button>
                        </a>
                    </div>
                </div>
            @endforeach

            @foreach($elements as $el)
                <div class="col-12 card d-flex flex-row">
                    <div class="card-body">
                        <a href="#">
                            <h5 class="card-title">{{$el->name}}</h5>
                            <ul>
                                @foreach($el->propvalue as $prop)
                                    <li>
                                        @if($prop->prop->is_number)
                                            {{$prop->prop->name}} - {{$prop->value_number}}
                                        @else
                                            {{$prop->prop->name}} - {{$prop->value}}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </a>
                        <div class="d-flex">
                            <a href="/admin/{{$el->id}}/editelement">
                                <button class="btn btn-primary">edit</button>
                            </a>
                            <a class="mx-4" href="/admin/{{$el->id}}/deleteelement">
                                <button class="btn btn-danger">удалить</button>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
            <div class="col-12 mt-5">
                {{ $elements->links('pagination.default') }}
            </div>
        </div>
    </div>
@endsection

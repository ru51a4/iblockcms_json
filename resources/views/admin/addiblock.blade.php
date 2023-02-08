@extends('layouts/admin')

@section('content')
    <div class="row">
        <form action="/admin/addiblock" method="post">
            @csrf
            <div class="form-group">
                <label>Название</label>
                <input name="name" type="text">
            </div>

            <div class="form-group">
                <label>родитель</label>
                <select name="parent_id">
                    <option value="0">-</option>
                @foreach($iblocks as $iblock)
                        <option value="{{$iblock->id}}">{{$iblock->name}}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">add</button>
        </form>
    </div>
@endsection

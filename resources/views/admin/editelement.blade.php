@extends('layouts/admin')

@section('content')
    <div class="row">
        <form action="/admin/{{$iblock_element->id}}/editelement" method="post">
            @csrf
            <div class="form-group">
                <label>Название</label>
                <input name="name" value="{{$iblock_element->name}}" type="text">
            </div>

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">property
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">system property
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    @foreach($resProp as $prop)
                        @if($prop["iblock_id"] != 1)
                            <div class="form-group">
                                <label>{{$prop["name"]}}</label>
                                @if(!$prop["is_number"])
                                    <div class="d-flex flex-column multy-{{$prop["id"]}}">
                                        @if (!empty($prop["value"]))
                                            @foreach($prop["value"] as $id => $p)
                                                <input type="text" name="{{$prop["id"]}}[]" value="{{$p}}">
                                            @endforeach
                                        @else
                                            <input type="text" name="{{$prop["id"]}}[]" value="">
                                        @endif
                                        @if($prop["is_multy"])
                                            <span onclick="add({{$prop["id"]}}, event)">add</span>
                                        @endif

                                    </div>
                                @else
                                    <div class="d-flex flex-column multy-{{$prop["id"]}}">
                                        @if (!empty($prop["value"]))
                                            @foreach($prop["value"] as $id => $p)
                                                <input type="text" name="{{$prop["id"]}}[]" value="{{$p}}">
                                            @endforeach
                                        @else
                                            <input type="text" name="{{$prop["id"]}}[]" value="">
                                        @endif
                                        @if($prop["is_multy"])
                                            <span onclick="add({{$prop["id"]}}, event)">add</span>
                                        @endif

                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    @foreach($resProp as $prop)
                        @if($prop["iblock_id"] == 1)
                            <div class="form-group">
                                <label>{{$prop["name"]}}</label>
                                @if(!$prop["is_number"])
                                    <div class="d-flex flex-column multy-{{$prop["id"]}}">
                                        @if (!empty($prop["value"]))
                                            @foreach($prop["value"] as $id => $p)
                                                <input type="text" name="{{$prop["id"]}}[]" value="{{$p}}">
                                            @endforeach
                                        @else
                                            <input type="text" name="{{$prop["id"]}}[]" value="">
                                        @endif
                                        @if($prop["is_multy"])
                                            <span onclick="add({{$prop["id"]}}, event)">add</span>
                                        @endif

                                    </div>
                                @else
                                    <div class="d-flex flex-column multy-{{$prop["id"]}}">
                                        @if (!empty($prop["value"]))
                                            @foreach($prop["value"] as $id => $p)
                                                <input type="text" name="{{$prop["id"]}}[]" value="{{$p}}">
                                            @endforeach
                                        @else
                                            <input type="text" name="{{$prop["id"]}}[]" value="">
                                        @endif
                                        @if($prop["is_multy"])
                                            <span onclick="add({{$prop["id"]}}, event)">add</span>
                                        @endif

                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <button class="btn btn-primary">edit</button>
        </form>
    </div>
    <script>
        function add(id, e) {
            e.preventDefault();
            var parinput = document.createElement('input');
            $(parinput).attr("type", "text");
            $(parinput).attr("name", `${id}[]`);
            $(e.target.parentElement).append(parinput)
        }

        document.addEventListener("DOMContentLoaded", () => {

            var triggerTabList = [].slice.call(document.querySelectorAll('#pills-tab button'))
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)

                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })
        });
    </script>
@endsection

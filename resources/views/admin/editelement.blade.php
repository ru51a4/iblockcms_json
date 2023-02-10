@extends('layouts/admin')

@section('content')
    <div class="row">
        <form action="/admin/{{ $iblock_element->id }}/editelement" method="post">
            @csrf
            <div class="form-group">
                <label>Название</label>
                <input name="name" value="{{ $iblock_element->name }}" type="text">
            </div>

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                        type="button" role="tab" aria-controls="pills-home" aria-selected="true">property
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                        type="button" role="tab" aria-controls="pills-profile" aria-selected="false">system property
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    @foreach ($props as $prop)
                        @if ($prop->iblock_id != 1)
                            <div class="form-group">
                                <label>{{ $prop->name }}</label>
                                @if ($prop->is_multy)
                                    <div class="d-flex flex-column multy-{{ $prop->id }}">
                                        @if (!empty($resProp[\Str::slug($prop->name)]))
                                            @foreach ($resProp[\Str::slug($prop->name)] as $id => $p)
                                                <input type="text" name="{{ \Str::slug($prop->name) }}[]"
                                                    value="{{ $p }}">
                                            @endforeach
                                        @endif
                                        <span onclick="add('{{ \Str::slug($prop->name) }}', event)">add</span>
                                    </div>
                                @else
                                    <div class="d-flex flex-column">
                                        @if (!empty($resProp[\Str::slug($prop->name)]))
                                            <input type="text" name="{{ \Str::slug($prop->name) }}[]"
                                                value="{{ $resProp[\Str::slug($prop->name)] }}">
                                        @else
                                            <input type="text" name="{{ \Str::slug($prop->name) }}[]" value="">
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    @foreach ($props as $prop)
                        @if ($prop->iblock_id == 1)
                            <div class="form-group">
                                <label>{{ $prop->name }}</label>
                                @if ($prop->is_multy)
                                    <div class="d-flex flex-column multy-{{ $prop->id }}">
                                        @if (!empty($resProp[\Str::slug($prop->name)]))
                                            @foreach ($resProp[\Str::slug($prop->name)] as $id => $p)
                                                <input type="text" name="{{ \Str::slug($prop->name) }}[]"
                                                    value="{{ $p }}">
                                            @endforeach
                                        @endif
                                        <span onclick="add('{{ \Str::slug($prop->name) }}', event)">add</span>
                                    </div>
                                @else
                                    <div class="d-flex flex-column">
                                        @if (!empty($resProp[\Str::slug($prop->name)]))
                                            <input type="text" name="{{ \Str::slug($prop->name) }}[]"
                                                value="{{ $resProp[\Str::slug($prop->name)] }}">
                                        @else
                                            <input type="text" name="{{ \Str::slug($prop->name) }}[]" value="">
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
            triggerTabList.forEach(function(triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)

                triggerEl.addEventListener('click', function(event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })
        });
    </script>
@endsection

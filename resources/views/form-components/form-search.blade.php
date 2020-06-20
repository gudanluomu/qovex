@if(isset($formGroup))
    <form>
        <div class="form-row">
            @foreach($formGroup as $input)
                <div class="{{ $input['class'] ?? 'col-md-3' }} col-sm-12 mb-2">
                    <div class="input-group mb-2">
                        @if(isset($input['text']))
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{ $input['text'] }}:</div>
                            </div>
                        @endif
                        @switch($type=$input['type']??'text')
                            @case('text')
                            @case('password')
                            @component('form-components.search-text')
                                @slot('type') {{ $type }} @endslot
                                @slot('name') {{ $input['name'] }} @endslot
                            @endcomponent
                            @break('')
                        @endswitch
                    </div>
                </div>
            @endforeach
            <div class="col-md-3 col-sm-12 mb-4">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">搜索</button>
                    <a class="btn btn-secondary" href="{{ url()->current() }}">返回</a>
                </div>
            </div>
        </div>
    </form>
@endif

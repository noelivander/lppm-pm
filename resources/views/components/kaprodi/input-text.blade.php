@props(['lable_input', 'input_type'=>'text','categories'=>[], 'value'=>'', 'help'=>'','required'=>1])

<div class="form-group{{ $errors->has($lable_input) ? ' has-error' : '' }}">
    <label for="{{ $lable_input }}" class="col-form-label">{{ ucwords(str_replace('_',' ',$lable_input)) }}</label>

        @if($input_type=='text' || $input_type=='url' || $input_type=='number')
            <input id="{{ $lable_input }}" type="{{$input_type}}" class="form-control" name="{{ $lable_input }}" value="{{ $value }}" placeholder="masukkan {{ str_replace('_',' ', $lable_input) }} ..." 
                @if($required)
                    required
                @endif
            >
        @elseif($input_type=='selection')
            <select class="form-control" id="{{ $lable_input }}" name="{{ $lable_input }}" 
                @if($required)
                    required
                @endif
            >
                <option value="">{{ __("pilih ").strtolower(str_replace('_',' ',$lable_input)) }}</option>
                @foreach ($categories as $key => $val)
                    <option value="{{ $val->id }}"
                        @if($val->id==$value)
                            selected="selected"
                        @endif
                    >{{ $val->nama }}</option>
                @endforeach
            </select>
        @elseif($input_type=='selection-val')
            <select class="form-control" id="{{ $lable_input }}" name="{{ $lable_input }}" 
                @if($required)
                    required
                @endif
            >
                <option value="">{{ __("pilih ").strtolower(str_replace('_',' ',$lable_input)) }}</option>
                @foreach ($categories as $key => $val)
                    <option value="{{ $key }}"
                        @if($key==$value)
                            selected="selected"
                        @endif
                    >{{ $val }}</option>
                @endforeach
            </select>
        @elseif($input_type=='switch')
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"  id="{{ $lable_input }}" name="{{ $lable_input }}"
                @if($value==1)
                    checked
                @endif
                >
                <label class="form-check-label" for="{{ $lable_input }}">{help}</label>
            </div>
        @endif

        @if($help)
            <span id="{{$lable_input}}HelpInline" class="form-text">
                {{$help}}
            </span>
        @endif

        @if ($errors->has($lable_input))
            <span class="help-block">
                <strong>{{ $errors->first($lable_input) }}</strong>
            </span>
        @endif
</div>
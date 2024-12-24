<?php

use \Encore\Admin\Grid\Filter\Period;

?>
<div class="form-group">
    <label class="col-sm-2 control-label">{{$label}}</label>
    <div class="col-sm-8">
        <div class="row">

            <div class="col-sm-4">
                <select class="form-control" name="{{$name}}[type]" id="{{$name}}_type">
                    <option value="">{{ __('admin.choose') }}</option>
                    @foreach($periods as $period_key => $period_name)
                        <option value="{{ $period_key }}" {{ $period_key === $period_type ? 'selected' : '' }}>
                            {{ $period_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if (!empty($periods[Period::CUSTOM_DATE]))
                <div id="toggle_{{$name}}_custom_date" class="js-filter-period-toggle-item {{ $period_type === Period::CUSTOM_DATE ? '' : ' hidden' }}">
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar-o"></i>
                            </div>
                            <input type="date"
                                   class="form-control"
                                   name="{{$name}}[{{Period::CUSTOM_DATE}}][start]"
                                   value="{{ request()->input($column.'.'.Period::CUSTOM_DATE.'.start', \Illuminate\Support\Arr::get($value, 'start')) }}"
                            />

                            <span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>

                            <input type="date"
                                   class="form-control"
                                   name="{{$name}}[{{Period::CUSTOM_DATE}}][end]"
                                   value="{{ request()->input($column.'.'.Period::CUSTOM_DATE.'.end', \Illuminate\Support\Arr::get($value, 'end')) }}"
                            />
                        </div>
                    </div>

                </div>
            @endif

            @if (!empty($periods[Period::CUSTOM_DATETIME]))
                <div id="toggle_{{$name}}_custom_datetime" class="js-filter-period-toggle-item {{ $period_type === Period::CUSTOM_DATETIME ? '' : ' hidden' }}">
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text"
                                   class="form-control"
                                   id="{{$name}}_start"
                                   placeholder="{{$label}} start"
                                   name="{{$name}}[{{Period::CUSTOM_DATETIME}}][start]"
                                   value="{{ request()->input($column.'.'.Period::CUSTOM_DATETIME.'.start', \Illuminate\Support\Arr::get($value, 'start')) }}"
                                   autocomplete="off"
                            />

                            <span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>

                            <input type="text"
                                   class="form-control"
                                   id="{{$name}}_end"
                                   placeholder="{{$label}} end"
                                   name="{{$name}}[{{Period::CUSTOM_DATETIME}}][end]"
                                   value="{{ request()->input($column.'.'.Period::CUSTOM_DATETIME.'.end', \Illuminate\Support\Arr::get($value, 'end')) }}"
                                   autocomplete="off"
                            />
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

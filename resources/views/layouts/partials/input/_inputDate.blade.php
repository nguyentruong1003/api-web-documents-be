<div class="form-group" wire:ignore>
    <input type="date"
        name="@if(isset($name)){{$name}}@endif"
        class="input-date-kendo form-control mb-0"
        isDatePicker="1"
        id={{$input_id}}
        @if(isset($set_null_when_enter_invalid_date) && $set_null_when_enter_invalid_date) set-null-when-enter-invalid-date="1" @endif
        @if(isset($disable_input) && $disable_input) disabled="" @endif
        @if(isset($place_holder)) placeholder="{{$place_holder}}" @endif
           @if(isset($wire_model)) wire:model="{{$wire_model}}"  @endif
           @if(isset($default_date)) value={{$default_date}} @endif
         @if(isset($min_date))
           min_date={{$min_date}}
         @endif
         @if(isset($max_date))
           max_date={{$max_date}}
         @endif

           >

</div>
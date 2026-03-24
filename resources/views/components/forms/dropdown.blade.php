@if($containerClass)
<div class="{{ $containerClass }}">
@endif
    <div class="form-floating">
        <select
            class="{{ $getSelectClasses() }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            id="{{ $name }}"
            @if($multiple) multiple @endif
            {{ $attributes }}
        >
            {{-- Default placeholder option --}}
            @if(!$multiple && $placeholder)
                <option value="" disabled selected>{{ $placeholder }}</option>
            @endif

            {{-- Options from array --}}
            @foreach($options as $value => $text)
                <option
                    value="{{ $value }}"
                    {{ $isSelected((string)$value) ? 'selected' : '' }}
                >
                    {{ $text }}
                </option>
            @endforeach

            {{-- Slot content for custom options --}}
            {{ $slot }}
        </select>

        <label for="{{ $name }}">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    </div>
    {{-- Laravel validation error display --}}
    <p class="text-danger">{{ $errors->first($name) }}</p>
@if($containerClass)
</div>
@endif
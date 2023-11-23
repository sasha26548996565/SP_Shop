<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{ $filter->getTitle() }}</h5>
    @foreach ($filter->getValues() as $id => $label)
        <div class="form-checkbox">
            <input type="checkbox" name="{{ $filter->getInputName($id) }}"
                value="{{ $id }}" id="{{ $filter->getInputId($id) }}"
                @checked($filter->getRequestValue($id))
            >
            <label for="{{ $filter->getInputId($id) }}" class="form-checkbox-label">{{ $label }}</label>
        </div>
    @endforeach
</div>
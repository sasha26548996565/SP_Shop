@foreach ($filter->getValues() as $option => $optionValues)
    <div>
        <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{ $option }}</h5>
        @foreach ($optionValues as $optionValue)
            <div class="form-checkbox">
                <input type="checkbox" name="{{ $filter->getInputName($optionValue['id']) }}"
                    value="{{ $optionValue['id'] }}" id="{{ $filter->getInputId($optionValue['id']) }}"
                    @checked($filter->getRequestValue($optionValue['id']))>

                <label for="{{ $filter->getInputId($optionValue['id']) }}"
                    class="form-checkbox-label">{{ $optionValue['value'] }}</label>
            </div>
        @endforeach
    </div>
@endforeach

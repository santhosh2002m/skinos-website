

<option value="" disabled selected >{{ __('Select Country') }}</option>
@foreach (App\Models\Country::where('status', 1)->get() as $data)
    @php
        $user = Auth::user();
        $userStateId = $user && $user->state_id ? \App\Models\State::where('id', $user->state_id)->where('status', 1)->value('id') : 0;
        $userCityId = $user && $user->city_id ? \App\Models\City::where('id', $user->city_id)->where('state_id', $userStateId)->where('status', 1)->value('id') : 0;
        $hasMultipleCities = $user && $user->state_id ? \App\Models\City::where('state_id', $user->state_id)->where('status', 1)->count() > 0 : 0;
        $isSelected = $user && $user->country == $data->country_name;
        $hasStates = $data->states->count() > 0;
        $isUserLoggedIn = $user ? 1 : 0;
    @endphp
    <option value="{{ $data->country_name }}"
        data="{{ $data->id }}"
        rel="{{ $hasStates ? 1 : 0 }}"
        rel1="{{ $isUserLoggedIn }}"
        rel2="{{ $userStateId }}"
        rel8="{{ $userCityId }}"
        rel9="{{ $hasMultipleCities ? 1 : 0 }}"
        rel5="{{ $isSelected ? 1 : 0 }}"
        data-href="{{ route('country.wise.state', $data->id) }}">
        {{ $data->country_name }}
    </option>
@endforeach

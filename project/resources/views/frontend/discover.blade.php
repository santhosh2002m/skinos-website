@extends('layouts.frontend')

@section('content')
    <div class="container py-5">
        @if($ingredient && $details)
            <!-- Ingredient-Specific Page -->
            <h1>{{ $details['name'] }}</h1>
            <p>{{ $details['description'] }}</p>
            <a href="{{ route('front.discover') }}" class="btn btn-primary mt-3">Back to Discover</a>
        @else
            <!-- General Discover Page -->
            <h1>Discover Our Ingredients</h1>
            <p>Explore the key ingredients, natural oils, active compounds, and specialty ingredients that make our products exceptional.</p>

            <div class="row">
                <!-- Key Ingredients -->
                <div class="col-lg-3 col-md-6">
                    <h3>Key Ingredients</h3>
                    <ul>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'aloe-vera']) }}">Aloe Vera</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'sunflower-seed-oil']) }}">Sunflower Seed Oil</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'rapeseed-seed-oil']) }}">Rapeseed Seed Oil</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'propylene-glycol']) }}">Propylene Glycol</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'sodium-lactate']) }}">Sodium Lactate</a></li>
                    </ul>
                </div>

                <!-- Natural Oils -->
                <div class="col-lg-3 col-md-6">
                    <h3>Natural Oils</h3>
                    <ul>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'olive-oil']) }}">Olive Oil</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'jojoba-oil']) }}">Jojoba Oil</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'wheatgerm-oil']) }}">Wheatgerm Oil</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'sweet-almond-oil']) }}">Sweet Almond Oil</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'shea-butter']) }}">Shea Butter</a></li>
                    </ul>
                </div>

                <!-- Active Compounds -->
                <div class="col-lg-3 col-md-6">
                    <h3>Active Compounds</h3>
                    <ul>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'ceramide-complex']) }}">Ceramide Complex</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'pentavitin']) }}">Pentavitin</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'matrixyl-3000']) }}">Matrixyl-3000</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'hyaluronic-acid']) }}">Hyaluronic Acid</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'vitamin-e']) }}">Vitamin E</a></li>
                    </ul>
                </div>

                <!-- Specialty Ingredients -->
                <div class="col-lg-3 col-md-6">
                    <h3>Specialty Ingredients</h3>
                    <ul>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'hydroboost']) }}">Hydroboost</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'hydromanil']) }}">Hydromanil</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'himalayan-thermal-water']) }}">Himalayan Thermal Water</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'dimethicone']) }}">Dimethicone</a></li>
                        <li><a href="{{ route('front.discover', ['ingredient' => 'peg-40-hydrogenated-castor-oil']) }}">PEG-40 Hydrogenated Castor Oil</a></li>
                    </ul>
                </div>
            </div>
        @endif
    </div>
@endsection
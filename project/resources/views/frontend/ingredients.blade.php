@extends('layouts.front')
@section('content')
    <section class="ingredients-section">
        <div class="container custom-containerr">
            <h2 class="section-title">@lang('Discover Our Key Ingredients')</h2>
            @foreach ($formulations as $product => $ingredients)
                <div class="product-formulation mb-5">
                    <h3 class="product-title">{{ $product }}</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Ingredient</th>
                                    <th>INCI</th>
                                    <th>Country of Origin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ingredients as $ingredient)
                                    <tr>
                                        <td>{{ $ingredient['sno'] }}</td>
                                        <td>{{ $ingredient['ingredient'] }}</td>
                                        <td>{{ $ingredient['inci'] }}</td>
                                        <td>{{ $ingredient['country'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

<style>
    .ingredients-section {
    padding: 50px 0;
}

.section-title {
    text-align: center;
    margin-bottom: 40px;
    font-size: 2.5rem;
    color: #333;
}

.product-formulation {
    margin-bottom: 50px;
}

.product-title {
    font-size: 1.8rem;
    color: #463539;
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

.table th {
    background-color: #f8f8f8;
    font-weight: bold;
    color: #333;
}

.table td {
    color: #666;
}

.table-responsive {
    overflow-x: auto;
}
</style>
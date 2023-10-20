<div class="row mb-5">
    @forelse($fetch_product as $product)
    <div class="col-md-6 col-xl-4">
        <a href="{{ url('/product/details/'.$product->serial ) }}">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $product->medicine_name }}</h5>
                    <p class="card-text text-dark">
                        Type: <span class="text-success">{{
                            $product->medicine_type}}</span>
                    </p>
                    <p class="card-text text-dark">
                        Shop: {{ $product->store_name}}
                    </p>
                    <p class="card-text text-dark">
                        Location: {{ $product->address}}
                    </p>
                    <p class="card-text">Price: {{ $product->price }} BDT</p>
                    <p class="card-img-bottom">
                        @if($product->total_stock > 0)
                        <span class="badge bg-label-success">In stock</span>
                        @else
                        <span class="badge bg-label-warning">Out of stock</span>
                        @endif
                    </p>
                </div>
                <img class="card-img-bottom" src="{{ asset($product->main_image) }}" height="241px" width="300px" alt=" Card
                                            image cap">
            </div>
        </a>
    </div>
    @empty
    <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="310px"
        alt="Card image">
    @endforelse

</div>

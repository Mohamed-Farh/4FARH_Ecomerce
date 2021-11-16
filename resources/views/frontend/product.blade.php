@extends('layouts.frontend_app')

@section('title', 'Product')

@section('content')


    <!--  Modal -->
    <div class="modal fade" id="productView" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row align-items-stretch">
                        <div class="col-lg-6 p-lg-0"><a class="product-view d-block h-100 bg-cover bg-center"
                                style="background: url(img/product-5.jpg)" href="img/product-5.jpg"
                                data-lightbox="productview" title="Red digital smartwatch"></a><a class="d-none"
                                href="img/product-5-alt-1.jpg" title="Red digital smartwatch"
                                data-lightbox="productview"></a><a class="d-none" href="img/product-5-alt-2.jpg"
                                title="Red digital smartwatch" data-lightbox="productview"></a></div>
                        <div class="col-lg-6">
                            <button class="close p-4" type="button" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            <div class="p-5 my-md-4">
                                <ul class="list-inline mb-2">
                                    <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                                    <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                                    <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                                    <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                                    <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                                </ul>
                                <h2 class="h4">Red digital smartwatch</h2>
                                <p class="text-muted">$250</p>
                                <p class="text-small mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut
                                    ullamcorper leo, eget euismod orci. Cum sociis natoque penatibus et magnis dis
                                    parturient montes nascetur ridiculus mus. Vestibulum ultricies aliquam convallis.</p>
                                <div class="row align-items-stretch mb-4">
                                    <div class="col-sm-7 pr-sm-0">
                                        <div class="border d-flex align-items-center justify-content-between py-1 px-3">
                                            <span class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                                            <div class="quantity">
                                                <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                                                <input class="form-control border-0 shadow-0 p-0" type="text" value="1">
                                                <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 pl-sm-0"><a
                                            class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0"
                                            href="cart.html">Add to cart</a></div>
                                </div><a class="btn btn-link text-dark p-0" href="#"><i class="far fa-heart mr-2"></i>Add to
                                    wish list</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6">
                    <!-- PRODUCT SLIDER-->
                    <div class="row m-sm-0">
                        <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0">
                            <div class="owl-thumbs d-flex flex-row flex-sm-column" data-slider-id="1">
                                @foreach($product->media as $media)
                                    <div class="owl-thumb-item flex-fill mb-2 {{ !$loop->last ? 'mr-2 mr-sm-0' : null }}">
                                        <img class="w-100" src="{{ asset('assets/products/'.$media->file_name) }}" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-10 order-1 order-sm-2">
                            <div class="owl-carousel product-slider" data-slider-id="1">
                                @foreach($product->media as $media)
                                <a class="d-block" href="{{ asset('assets/products/'.$media->file_name) }}" data-lightbox="product" title="{{ $product->name }}">
                                    <img class="img-fluid" src="{{ asset('assets/products/'.$media->file_name) }}" alt="{{ $product->name }}">
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PRODUCT DETAILS-->
                <div class="col-lg-6">
                    <ul class="list-inline mb-2">
                        @if ($reviews_avg_ratings != '')
                            @for ($i = 0; $i < 5; $i++)
                                <li class="list-inline-item m-0"><i class="{{ round($reviews_avg_ratings) <= $i ? 'far' : 'fas' }} fa-star fa-sm text-warning"></i></li>
                            @endfor
                        @else
                            <li class="list-inline-item m-0"><i class="far fa-star fa-sm text-warning"></i></li>
                            <li class="list-inline-item m-0"><i class="far fa-star fa-sm text-warning"></i></li>
                            <li class="list-inline-item m-0"><i class="far fa-star fa-sm text-warning"></i></li>
                            <li class="list-inline-item m-0"><i class="far fa-star fa-sm text-warning"></i></li>
                            <li class="list-inline-item m-0"><i class="far fa-star fa-sm text-warning"></i></li>
                        @endif
                    </ul>
                    <h1>{{ $product->name }}</h1>
                    <p class="text-muted lead">${{ $product->price }}</p>
                    <p class="text-small mb-4">
                        {!! $product->description !!}
                    </p>

                    {{-- هنا بستخدم البرودكت غلشان ااقدر استخدمه في اللايف وبر --زي بالظبط الكومباكت (compact) بتالعت لارافبل --}}
                    <livewire:frontend.show-product-component :product="$product" />


                    <br>
                    <ul class="list-unstyled small d-inline-block">
                        <li class="px-3 py-2 mb-1 bg-white text-muted">
                            <strong class="text-uppercase text-dark">Category:</strong>
                            <a class="reset-anchor ml-2" href="#">{{ $product->category->name }}</a>
                        </li>
                        <li class="px-3 py-2 mb-1 bg-white text-muted">
                            <strong class="text-uppercase text-dark">Tags:</strong>
                            @foreach($product->tags as $tag)
                                <a class="reset-anchor ml-2" href="#{{ $tag->id }}">{{ $tag->name }}</a>
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>

            <!-- DETAILS TABS-->
            <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                </li>
            </ul>

            <div class="tab-content mb-5" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <div class="p-4 p-lg-5 bg-white">
                        <h6 class="text-uppercase">Product description </h6>
                        <p class="text-muted text-small mb-0">
                            {!! $product->description !!}
                        </p>
                    </div>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <div class="p-4 p-lg-5 bg-white">
                        <div class="row">
                            <div class="col-lg-8">
                                @forelse($product->reviews as $review)
                                <div class="media mb-3">
                                    <img class="rounded-circle" src="{{ asset('frontend/img/customer-1.png') }}" alt="" width="50">
                                    <div class="media-body ml-3">
                                        <h6 class="mb-0 text-uppercase">{{ $review->name }}</h6>
                                        <p class="small text-muted mb-0 text-uppercase">{{ $review->created_at->format('d M, Y') }}</p>
                                        <ul class="list-inline mb-1 text-xs">
                                            @if ($review->rating != '')
                                                @for ($i = 0; $i < 5; $i++)
                                                    <li class="list-inline-item m-0">
                                                        <i class="{{ round($review->rating) <= $i ? 'far' : 'fas' }} fa-star fa-sm text-warning"></i>
                                                    </li>
                                                @endfor
                                            @else
                                                <li class="list-inline-item m-0"><i class="far fa-star fa-sm text-warning"></i></li>
                                                <li class="list-inline-item m-0"><i class="far fa-star fa-sm text-warning"></i></li>
                                                <li class="list-inline-item m-0"><i class="far fa-star fa-sm text-warning"></i></li>
                                                <li class="list-inline-item m-0"><i class="far fa-star fa-sm text-warning"></i></li>
                                                <li class="list-inline-item m-0"><i class="far fa-star fa-sm text-warning"></i></li>
                                            @endif
                                        </ul>
                                        <p class="mb-0">{{ $review->title }}</p>
                                        <p class="text-small mb-0 text-muted">
                                            {!! $review->message !!}
                                        </p>
                                    </div>
                                </div>
                                @empty
                                    <div class="media mb-3">
                                        <div class="media-body ml-3">
                                            No Reviews Found.
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- RELATED PRODUCTS-->



            <livewire:frontend.related-products-component :relatedProducts="$relatedProducts" />
        </div>
    </section>
@endsection

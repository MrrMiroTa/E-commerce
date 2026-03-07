@extends('layouts.app')

@section('title', 'Shipping Information')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="mb-4">Shipping Information</h1>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">🚚 Delivery Options</h5>
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Location</th>
                                <th>Shipping Cost</th>
                                <th>Delivery Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>📍 Phnom Penh</td>
                                <td><strong>$1.00</strong></td>
                                <td>2-5 business days</td>
                            </tr>
                            <tr>
                                <td>🏙️ Other Provinces</td>
                                <td><strong>$2.50</strong></td>
                                <td>5-10 business days</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="text-muted small mt-2">
                        * Free shipping promotions may apply to qualifying orders
                    </p>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">📋 Shipping Process</h5>
                    <ol class="mt-3">
                        <li class="mb-2"><strong>Order Confirmation:</strong> You'll receive an email confirmation once your order is placed.</li>
                        <li class="mb-2"><strong>Processing:</strong> Orders are processed within 1-2 business days.</li>
                        <li class="mb-2"><strong>Shipped:</strong> You'll receive a tracking number when your order is dispatched.</li>
                        <li class="mb-2"><strong>Delivery:</strong> Our delivery partner will contact you before delivery.</li>
                    </ol>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">📦 Package Protection</h5>
                    <ul>
                        <li>All packages are carefully packed to ensure safe delivery</li>
                        <li>Fragile items are marked and handled with extra care</li>
                        <li>Insurance is included for high-value orders</li>
                    </ul>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">⚠️ Delivery Notes</h5>
                    <ul>
                        <li>Please ensure someone is available to receive the package</li>
                        <li>Provide a valid phone number for delivery coordination</li>
                        <li>Double-check your shipping address before placing your order</li>
                        <li>For office deliveries, include company name and floor/room number</li>
                    </ul>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">🗺️ Service Areas</h5>
                    <p>We deliver to all provinces in Cambodia:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li>Phnom Penh</li>
                                <li>Siem Reap</li>
                                <li>Battambang</li>
                                <li>Banteay Meanchey</li>
                                <li>Kampong Cham</li>
                                <li>Kampong Chhnang</li>
                                <li>Kampong Speu</li>
                                <li>Kampong Thom</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>Kampot</li>
                                <li>Kandal</li>
                                <li>Koh Kong</li>
                                <li>Kratié</li>
                                <li>Mondul Kiri</li>
                                <li>Preah Sihanouk</li>
                                <li>Pursat</li>
                                <li>Takeo</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">❓ Questions About Shipping?</h5>
                    <p>If you have any questions about shipping, please don't hesitate to contact us.</p>
                    <a href="{{ route('shop.contact') }}" class="btn btn-primary">Contact Us</a>
                    <a href="{{ route('shop.faq') }}" class="btn btn-outline-secondary">View FAQs</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

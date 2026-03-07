@extends('layouts.app')

@section('title', __('messages.shipping_info'))

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="mb-4">Shipping Information</h1>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">🚚 {{ __('messages.delivery_options') }}</h5>
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>{{ app()->getLocale() == 'kh' ? 'ទីតាំង' : 'Location' }}</th>
                                <th>{{ __('messages.shipping_cost') }}</th>
                                <th>{{ __('messages.delivery_time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>📍 {{ __('messages.phnom_penh') }}</td>
                                <td><strong>$1.00</strong></td>
                                <td>{{ app()->getLocale() == 'kh' ? '2-5 ថ្ងៃ ធ្វើការ' : '2-5 business days' }}</td>
                            </tr>
                            <tr>
                                <td>🏙️ {{ __('messages.other_provinces') }}</td>
                                <td><strong>$2.50</strong></td>
                                <td>{{ app()->getLocale() == 'kh' ? '5-10 ថ្ងៃ ធ្វើការ' : '5-10 business days' }}</td>
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
                    <h5 class="card-title">📋 {{ app()->getLocale() == 'kh' ? 'ដំណើរការដឹកជញ្ជូន' : 'Shipping Process' }}</h5>
                    <ol class="mt-3">
                        <li class="mb-2"><strong>{{ app()->getLocale() == 'kh' ? 'ការបញ្ជាក់ការបញ្ជាទិញ:' : 'Order Confirmation:' }} </strong>{{ app()->getLocale() == 'kh' ? 'អ្នកនឹងទទួលបានការបញ្ជាក់តាមអ៊ីមែលបន្ទាប់ពីការបញ្ជាទិញរបស់អ្នក។' : 'You\'ll receive an email confirmation once your order is placed.' }}</li>
                        <li class="mb-2"><strong>{{ app()->getLocale() == 'kh' ? 'កំពុងដំណើរការ:' : 'Processing:' }} </strong>{{ app()->getLocale() == 'kh' ? 'ការបញ្ជាទិញនឹងត្រូវបានដំណើរការ within 1-2 ថ្ងៃ ធ្វើការ។' : 'Orders are processed within 1-2 business days.' }}</li>
                        <li class="mb-2"><strong>{{ app()->getLocale() == 'kh' ? 'បានដឹកជញ្ជូន:' : 'Shipped:' }} </strong>{{ app()->getLocale() == 'kh' ? 'អ្នកនឹងទទួលបានលេខ tracking នៅពេលការបញ្ជាទិញរបស់អ្នកត្រូវបានផ្ញើ។' : 'You\'ll receive a tracking number when your order is dispatched.' }}</li>
                        <li class="mb-2"><strong>{{ app()->getLocale() == 'kh' ? 'ការដឹកជញ្ជូន:' : 'Delivery:' }} </strong>{{ app()->getLocale() == 'kh' ? 'ដៃគូដឹកជញ្ជូនរបស់យើងនឹងទាក់ទងអ្នកមុនពេលដឹកជញ្ជូន។' : 'Our delivery partner will contact you before delivery.' }}</li>
                    </ol>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">📦 {{ app()->getLocale() == 'kh' ? 'ការការពារកញ្ចប់' : 'Package Protection' }}</h5>
                    <ul>
                        <li>{{ app()->getLocale() == 'kh' ? 'កញ្ចប់ទាំងអស់ត្រូវបានវេចខ្ចប់យ៉ាងប្រុងប្រៀបដើម្បីធានាការដឹកជញ្ជូនមានសុវត្ថិភាព' : 'All packages are carefully packed to ensure safe delivery' }}</li>
                        <li>{{ app()->getLocale() == 'kh' ? 'ទំនិញងាយខូចត្រូវបានសម្គាល់ និងដោះស្រាយដោយការប្រុងប្រៀបពិសេស' : 'Fragile items are marked and handled with extra care' }}</li>
                        <li>{{ app()->getLocale() == 'kh' ? 'ធានារ៉ាប់រងត្រូវបានរួមបញ្ចូលសម្រាប់ការបញ្ជាទិញតម្លៃខ្ពស់' : 'Insurance is included for high-value orders' }}</li>
                    </ul>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">⚠️ {{ app()->getLocale() == 'kh' ? 'ចំណាំដឹកជញ្ជូន' : 'Delivery Notes' }}</h5>
                    <ul>
                        <li>{{ app()->getLocale() == 'kh' ? 'សូមធានាថាមាននរណាម្នាក់អាចទទួលបានកញ្ចប់' : 'Please ensure someone is available to receive the package' }}</li>
                        <li>{{ app()->getLocale() == 'kh' ? 'ផ្តល់លេខទូរស័ព្ទត្រឹមត្រូវសម្រាប់ការសម្របសម្រួលដឹកជញ្ជូន' : 'Provide a valid phone number for delivery coordination' }}</li>
                        <li>{{ app()->getLocale() == 'kh' ? 'ពិនិត្យអាសយដ្ឋានដឹកជញ្ជូនរបស់អ្នកម្តងទៀតមុនពេលដាក់ការបញ្ជាទិញ' : 'Double-check your shipping address before placing your order' }}</li>
                        <li>{{ app()->getLocale() == 'kh' ? 'សម្រាប់ការដឹកជញ្ជូនទៅការិយាល័យ បញ្ចូលឈ្មោះក្រុមហ៊ុន និងលេខបន្ទប់/ជាន់' : 'For office deliveries, include company name and floor/room number' }}</li>
                    </ul>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">🗺️ {{ app()->getLocale() == 'kh' ? 'តំបន់សេវកម្ម' : 'Service Areas' }}</h5>
                    <p>{{ app()->getLocale() == 'kh' ? 'យើងដឹកជញ្ជូនទៅកាន់ខេត្តទាំងអស់នៅកម្ពុជា:' : 'We deliver to all provinces in Cambodia:' }}</p>
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
                    <h5 class="card-title">❓ {{ app()->getLocale() == 'kh' ? 'សំណួរអំពីការដឹកជញ្ជូន?' : 'Questions About Shipping?' }}</h5>
                    <p>{{ app()->getLocale() == 'kh' ? 'ប្រសិនបើអ្នកមានសំណួរណាមួយអំពីការដឹកជញ្ជូន សូមកុំចាំបាច់ទាក់ទងយើង។' : 'If you have any questions about shipping, please don\'t hesitate to contact us.' }}</p>
                    <a href="{{ route('shop.contact') }}" class="btn btn-primary">{{ __('messages.contact_us') }}</a>
                    <a href="{{ route('shop.faq') }}" class="btn btn-outline-secondary">{{ __('messages.faq') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="mb-4">Frequently Asked Questions</h1>
            
            <div class="accordion" id="faqAccordion">
                <!-- Ordering -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ordering">
                            📦 Ordering
                        </button>
                    </h2>
                    <div id="ordering" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <strong>How do I place an order?</strong>
                                <p>Simply browse our shop, add items to your cart, and proceed to checkout. You'll need to provide your shipping details and payment method.</p>
                            </div>
                            <div class="mb-3">
                                <strong>Can I modify or cancel my order?</strong>
                                <p>You can modify or cancel your order as long as it hasn't been shipped yet. Please contact us immediately if you need to make changes.</p>
                            </div>
                            <div class="mb-3">
                                <strong>How do I track my order?</strong>
                                <p>Once your order ships, you'll receive a tracking number via email. You can also track your order in your account dashboard.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping">
                            🚚 Shipping
                        </button>
                    </h2>
                    <div id="shipping" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <strong>What are the shipping costs?</strong>
                                <p>Shipping is $1.00 for orders delivered within Phnom Penh, and $2.50 for all other provinces in Cambodia.</p>
                            </div>
                            <div class="mb-3">
                                <strong>How long does delivery take?</strong>
                                <p>Standard delivery takes 2-5 business days within Phnom Penh, and 5-10 business days for other provinces.</p>
                            </div>
                            <div class="mb-3">
                                <strong>Do you ship internationally?</strong>
                                <p>Currently, we only ship within Cambodia. We're working on expanding our shipping options soon.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Returns -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#returns">
                            🔄 Returns & Refunds
                        </button>
                    </h2>
                    <div id="returns" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <strong>What is your return policy?</strong>
                                <p>We offer a 7-day return policy for most items. Products must be unused, in original packaging, and accompanied by the receipt.</p>
                            </div>
                            <div class="mb-3">
                                <strong>How do I return an item?</strong>
                                <p>Contact our support team with your order number and details about the item. We'll provide you with return instructions.</p>
                            </div>
                            <div class="mb-3">
                                <strong>When will I receive my refund?</strong>
                                <p>Refunds are processed within 5-7 business days after we receive and inspect the returned item. The amount will be credited to your original payment method.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment">
                            💳 Payment
                        </button>
                    </h2>
                    <div id="payment" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <strong>What payment methods do you accept?</strong>
                                <p>We accept Cash on Delivery (COD), Bank Transfer, and major credit/debit cards.</p>
                            </div>
                            <div class="mb-3">
                                <strong>Is my payment information secure?</strong>
                                <p>Yes, all payments are processed securely. We don't store your complete payment details on our servers.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#account">
                            👤 Account
                        </button>
                    </h2>
                    <div id="account" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <strong>How do I create an account?</strong>
                                <p>Click on the "Register" link in the navigation menu and fill out the registration form with your details.</p>
                            </div>
                            <div class="mb-3">
                                <strong>How do I reset my password?</strong>
                                <p>Click on "Forgot Password" on the login page and follow the instructions to reset your password via email.</p>
                            </div>
                            <div class="mb-3">
                                <strong>Can I update my account information?</strong>
                                <p>Yes, log in to your account and navigate to the Profile section to update your personal information.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#products">
                            🛍️ Products
                        </button>
                    </h2>
                    <div id="products" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <strong>How do I know if a product is in stock?</strong>
                                <p>Product availability is shown on each product page. If the item is out of stock, you'll see a notification.</p>
                            </div>
                            <div class="mb-3">
                                <strong>Do you offer product warranties?</strong>
                                <p>Some products come with manufacturer warranties. Check the product details page for warranty information.</p>
                            </div>
                            <div class="mb-3">
                                <strong>Can I request a product that isn't on your site?</strong>
                                <p>Yes! Contact us with your request and we'll do our best to source the product for you.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 p-4 bg-light rounded">
                <h5>Still have questions?</h5>
                <p>Can't find the answer you're looking for? Please contact our support team.</p>
                <a href="{{ route('shop.contact') }}" class="btn btn-primary">Contact Us</a>
            </div>
        </div>
    </div>
</div>
@endsection

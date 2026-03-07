@extends('layouts.app')

@section('title', __('messages.faq'))

@section('styles')
<style>
    .faq-content {
        display: none;
    }
    .faq-content.active {
        display: block;
    }
    .faq-button:not(.collapsed) .faq-icon {
        transform: rotate(180deg);
    }
    .faq-icon {
        transition: transform 0.3s ease;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="mb-4">{{ __('messages.frequently_asked_questions') }}</h1>
            
            <div class="accordion" id="faqAccordion">
                <!-- Ordering -->
                <div class="accordion-item mb-3 border rounded">
                    <h2 class="accordion-header">
                        <button class="faq-button accordion-button w-full flex items-center justify-between p-4 bg-white border-0 rounded-t" type="button" onclick="toggleFaq('ordering')">
                            <span>📦 {{ app()->getLocale() == 'kh' ? 'ការបញ្ជាទិញ' : 'Ordering' }}</span>
                            <svg class="faq-icon w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="ordering" class="faq-content">
                        <div class="accordion-body p-4 bg-gray-50">
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីធ្វើយ៉ាងណាដើម្បីបញ្ជាទិញ?' : 'How do I place an order?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'គ្រាន់តែរកមើលហាងរបស់យើង បន្ថែមទំនិញទៅក្នុងកន្ត្រក ហើយទៅកាន់ការទូទាត់។ អ្នកនឹងត្រូវផ្តល់ព័ត៌មានដឹកជញ្ជូននិងវិធីសាស្ត្របង់ប្រាក់។' : 'Simply browse our shop, add items to your cart, and proceed to checkout. You\'ll need to provide your shipping details and payment method.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីខ្ញុំអាចកែប្រែឬលុបការបញ្ជាទិញបានទេ?' : 'Can I modify or cancel my order?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'អ្នកអាចកែប្រែឬលុបការបញ្ជាទិញបាន ប្រសិនបើវាមិនទាន់ត្រូវបានដឹកជញ្ជូនទេ។ សូមទាក់ទងយើងភ្លាមៗប្រសិនបើអ្នកត្រូវការធ្វើការផ្លាស់ប្តូរ។' : 'You can modify or cancel your order as long as it hasn\'t shipped yet. Please contact us immediately if you need to make changes.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីធ្វើយ៉ាងណាតាមដានការបញ្ជាទិញ?' : 'How do I track my order?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'នៅពេលការបញ្ជាទិញរបស់អ្នកត្រូវបានដឹកជញ្ជូន អ្នកនឹងទទួលបានលេខតាមដានតាមអ៊ីមែល។ អ្នកក៏អាចតាមដានការបញ្ជាទិញក្នុងគណនីផ្ទាត់គ្រប់គ្រងរបស់អ្នកបានផងដែរ។' : 'Once your order ships, you\'ll receive a tracking number via email. You can also track your order in your account dashboard.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping -->
                <div class="accordion-item mb-3 border rounded">
                    <h2 class="accordion-header">
                        <button class="faq-button accordion-button w-full flex items-center justify-between p-4 bg-white border-0 rounded-t collapsed" type="button" onclick="toggleFaq('shipping')">
                            <span>🚚 {{ app()->getLocale() == 'kh' ? 'ដឹកជញ្ជូន' : 'Shipping' }}</span>
                            <svg class="faq-icon w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="shipping" class="faq-content">
                        <div class="accordion-body p-4 bg-gray-50">
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តម្លៃដឹកជញ្ជូនគឺប៉ុន្មាន?' : 'What are the shipping costs?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'ដឹកជញ្ជូនគឺ $1.00 សម្រាប់ការដឹកជញ្ជូននៅក្នុងភ្នំពេញ និង $2.50 សម្រាប់ខេត្តផ្សេងទៀតនៅកម្ពុជា។' : 'Shipping is $1.00 for orders delivered within Phnom Penh, and $2.50 for all other provinces in Cambodia.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីការដឹកជញ្ជូនចំនួនថ្ងៃប៉ុន្មាន?' : 'How long does delivery take?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'ការដឹកជញ្ជូនស្តាប់ត្រូវចាប់ពី 2-5 ថ្ងៃធ្វើការនៅក្នុងភ្នំពេញ និង 5-10 ថ្ងៃធ្វើការសម្រាប់ខេត្តផ្សេងទៀត។' : 'Standard delivery takes 2-5 business days within Phnom Penh, and 5-10 business days for other provinces.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីអ្នកដឹកជញ្ជូនទៅក្រៅប្រទេសទេ?' : 'Do you ship internationally?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'បច្ចុប្បន្ន យើងដឹកជញ្ជូនតែនៅក្នុងប្រទេសកម្ពុជាប៉ុណ្ណោះ។ យើងកំពុងធ្វើការដើម្បីពង្រីកជម្រើសដឹកជញ្ជូនរបស់យើងឆាប់ៗ។' : 'Currently, we only ship within Cambodia. We\'re working on expanding our shipping options soon.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Returns -->
                <div class="accordion-item mb-3 border rounded">
                    <h2 class="accordion-header">
                        <button class="faq-button accordion-button w-full flex items-center justify-between p-4 bg-white border-0 rounded-t collapsed" type="button" onclick="toggleFaq('returns')">
                            <span>🔄 {{ app()->getLocale() == 'kh' ? 'ត្រូវការ & សេចក្តីបង្វែរ' : 'Returns & Refunds' }}</span>
                            <svg class="faq-icon w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="returns" class="faq-content">
                        <div class="accordion-body p-4 bg-gray-50">
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'គោលការណ៍ត្រូវការរបស់អ្នកគឺអ្វី?' : 'What is your return policy?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'យើងផ្តល់គោលការណ៍ត្រូវការ 7 ថ្ងៃសម្រាប់ទំនិញភាគច្រើន។ ផលិតផលត្រូវតែមិនបានប្រើ នៅក្នុងវេចញ original ហើយត្រូវមានបង្ការនេះ។' : 'We offer a 7-day return policy for most items. Products must be unused, in original packaging, and accompanied by the receipt.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីធ្វើយ៉ាងណាត្រូវការទំនិញ?' : 'How do I return an item?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'ទាក់ទងក្រុមគាំទ្ររបស់យើងជាមួយលេខការបញ្ជាទិញរបស់អ្នក និងព័ត៌មានលម្អិតអំពីទំនិញ។ យើងនឹងផ្តល់ការណែនាំត្រលប់មកវិញ។' : 'Contact our support team with your order number and details about the item. We\'ll provide you with return instructions.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីខ្ញុំនឹងទទួលបានការសងប្រាក់វិញនៅពេលណា?' : 'When will I receive my refund?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'ការសងប្រាក់នឹងត្រូវបានដំណើរការ�within 5-7 ថ្ងៃធ្វើការបន្ទាប់ពីយើងទទួលនិងត្រួតពិនិត្យទំនិញត្រលប់មកវិញ។ ទឹកប្រាក់នឹងត្រូវបានបញ្ចូលទៅក្នុងវិធីសាស្ត្របង់ប្រាក់ដើម្បីរបស់អ្នក។' : 'Refunds are processed within 5-7 business days after we receive and inspect the returned item. The amount will be credited to your original payment method.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment -->
                <div class="accordion-item mb-3 border rounded">
                    <h2 class="accordion-header">
                        <button class="faq-button accordion-button w-full flex items-center justify-between p-4 bg-white border-0 rounded-t collapsed" type="button" onclick="toggleFaq('payment')">
                            <span>💳 {{ app()->getLocale() == 'kh' ? 'ការបង់ប្រាក់' : 'Payment' }}</span>
                            <svg class="faq-icon w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="payment" class="faq-content">
                        <div class="accordion-body p-4 bg-gray-50">
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'វិធីសាស្ត្របង់ប្រាក់ណាខ្លះដែលអ្នកទទួលយក?' : 'What payment methods do you accept?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'យើងទទួលយក ការបង់ប្រាក់ពេលទទួល (COD) បញ្ជាក់ធនាគារ និងកាតឥណទាន/ឥណពន្ធ។' : 'We accept Cash on Delivery (COD), Bank Transfer, and major credit/debit cards.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីព័ត៌មានការបង់ប្រាក់របស់ខ្ញុំមានសុវត្ថិភាពទេ?' : 'Is my payment information secure?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'បាទ ការបង់ប្រាក់ទាំងអស់ត្រូវបានដំណើរការយ៉ាងសុវត្ថិភាព។ យើងមិនរក្សាទុកព័ត៌មានការបង់ប្រាក់ពេញលេញរបស់អ្នកនៅលើម៉ាស៊ីនមេរបស់យើងទេ។' : 'Yes, all payments are processed securely. We don\'t store your complete payment details on our servers.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account -->
                <div class="accordion-item mb-3 border rounded">
                    <h2 class="accordion-header">
                        <button class="faq-button accordion-button w-full flex items-center justify-between p-4 bg-white border-0 rounded-t collapsed" type="button" onclick="toggleFaq('account')">
                            <span>👤 {{ app()->getLocale() == 'kh' ? 'គណនី' : 'Account' }}</span>
                            <svg class="faq-icon w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="account" class="faq-content">
                        <div class="accordion-body p-4 bg-gray-50">
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីធ្វើយ៉ាងណាបង្កើតគណនី?' : 'How do I create an account?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'ចុចលើ "ចុះឈ្មោះ" នៅក្នុងម៉ឺនុយទាំងឡាយ ហើយបំពេញទម្រង់ចុះឈ្មោះជាមួយព័ត៌មានរបស់អ្នក។' : 'Click on the "Register" link in the navigation menu and fill out the registration form with your details.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីធ្វើយ៉ាងណាកំណត់ពាក្យសំងាត់ឡើងវិញ?' : 'How do I reset my password?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'ចុចលើ "ភ្លេចពាក្យសំងាត់" នៅលើទំព័រចូល ហើយធ្វើតាមការណែនាំដើម្បីកំណត់ពាក្យសំងាត់ឡើងវិញតាមអ៊ីមែល។' : 'Click on "Forgot Password" on the login page and follow the instructions to reset your password via email.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីខ្ញុំអាចធ្វើបច្ចុប្បន្នភាពព័ត៌មានគណនីបាទេ?' : 'Can I update my account information?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'បាទ ចូលគណនីរបស់អ្នក ហើយទៅកាន់ផ្នែកប្រវត្តិរូប ដើម្បីធ្វើបច្ចុប្បន្នភាពព័ត៌មានផាសុខុមនៃអ្នក។' : 'Yes, log in to your account and navigate to the Profile section to update your personal information.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="accordion-item mb-3 border rounded">
                    <h2 class="accordion-header">
                        <button class="faq-button accordion-button w-full flex items-center justify-between p-4 bg-white border-0 rounded-t collapsed" type="button" onclick="toggleFaq('products')">
                            <span>🛍️ {{ app()->getLocale() == 'kh' ? 'ផលិតផល' : 'Products' }}</span>
                            <svg class="faq-icon w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="products" class="faq-content">
                        <div class="accordion-body p-4 bg-gray-50">
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីខ្ញុំដឹងបានយ៉ាងណាថាផលិតផលមានស្តុក?' : 'How do I know if a product is in stock?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'ភាពអាចរកបាននៃផលិតផល ត្រូវបានបង្ហាញនៅលើទំព័រផលិតផលនីមួយៗ។ ប្រសិនបើទំនិញអស់ពីស្តុក អ្នកនឹងឃើញការជូនដំណឹង។' : 'Product availability is shown on each product page. If the item is out of stock, you\'ll see a notification.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីអ្នកផ្តល់ការធានាផលិតផលទេ?' : 'Do you offer product warranties?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'ផលិតផលមួយចំនួនមកជាមួយការធានាពីក្រុមហ៊ុនផលិត។ ពិនិត្យទំព័រលម្អិតផលិតផល សម្រាប់ព័ត៌មានធានា។' : 'Some products come with manufacturer warranties. Check the product details page for warranty information.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>{{ app()->getLocale() == 'kh' ? 'តេីខ្ញុំអាចស្នើរកផលិតផលដែលអ្នកមាននៅលើគេហទំព័ររបស់អ្នកទេ?' : 'Can I request a product that isn\'t on your site?' }}</strong>
                                <p>{{ app()->getLocale() == 'kh' ? 'បាទ! ទាក់ទងយើងជាមួយសំណូករបស់អ្នក ហើយយើងនឹងព្យាយាមរកផលិតផលនោះសម្រាប់អ្នក។' : 'Yes! Contact us with your request and we\'ll do our best to source the product for you.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 p-4 bg-light rounded">
                <h5>{{ app()->getLocale() == 'kh' ? 'នៅមានសំណួរ?' : 'Still have questions?' }}</h5>
                <p>{{ app()->getLocale() == 'kh' ? 'មិនអាចរកចម្លើយដែលអ្នកកំពុងរ寻找? សូមទាក់ទងក្រុមគាំទ្ររបស់យើង។' : 'Can\'t find the answer you\'re looking for? Please contact our support team.' }}</p>
                <a href="{{ route('shop.contact') }}" class="btn btn-primary">{{ __('messages.contact_us') }}</a>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFaq(id) {
    const content = document.getElementById(id);
    const button = content.previousElementSibling.querySelector('.faq-button');
    
    // Toggle current item
    if (content.classList.contains('active')) {
        content.classList.remove('active');
        button.classList.add('collapsed');
    } else {
        content.classList.add('active');
        button.classList.remove('collapsed');
    }
}
</script>
@endsection

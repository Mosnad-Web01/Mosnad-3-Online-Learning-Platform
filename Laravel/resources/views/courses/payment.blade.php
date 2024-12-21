<x-layout>
    <main class="bg-white dark:bg-gray-900 text-black dark:text-white min-h-screen w-full flex justify-center items-center">
        <div class="w-full p-6 bg-gray-100 dark:bg-gray-800 rounded-t-lg shadow-lg mt-8">
            <h1 class="text-2xl font-bold text-center mb-4">Payment for {{ $course->course_name }}</h1>
            <p class="text-lg text-center mb-6">Price: ${{ $course->price }}</p>

            <form method="POST" action="/payment">
                @csrf
                <input type="hidden" name="course_user_id" value="{{ $courseUser->id }}">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2" for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" value="{{ $course->price }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Choose payment method</label>
                    <div class="flex flex-col space-y-3">
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="stripe" class="mr-2">
                            <span>Stripe payment</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="paypal" class="mr-2">
                            <span>PayPal</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="credit_card" class="mr-2" checked>
                            <span>Credit card</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2" for="payment_date">Payment Date</label>
                    <input type="date" id="payment_date" name="payment_date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2" for="status">Payment Status</label>
                    <select id="status" name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="save_card" class="mr-2">
                        <span>Save card for future use</span>
                    </label>
                </div>

                <div class="text-center">
                    <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Continue - Total cost ${{ $course->price }}
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-layout>

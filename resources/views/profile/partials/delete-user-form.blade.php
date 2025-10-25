<section class="space-y-6">
    <p class="text-sm text-gray-700 mb-4">
        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
    </p>

    <button
        type="button"
        onclick="document.getElementById('delete-modal').classList.remove('hidden')"
        class="px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-red rounded-lg font-semibold hover:from-red-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-300 shadow-lg">
        <i class="fas fa-trash-alt mr-2"></i>Delete Account
    </button>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-3xl text-red-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Delete Account?
                </h2>
                <p class="text-sm text-gray-600">
                    Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.
                </p>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-key mr-2 text-red-600"></i>Confirm Password
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 bg-gray-50"
                        placeholder="Enter your password"
                        required
                    />
                    @error('password', 'userDeletion')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button
                        type="button"
                        onclick="document.getElementById('delete-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-300">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-black rounded-lg font-semibold hover:from-red-700 hover:to-pink-700 transition-all duration-300 shadow-lg">
                        <i class="fas fa-trash-alt mr-2"></i>Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($errors->userDeletion->isNotEmpty())
        <script>
            document.getElementById('delete-modal').classList.remove('hidden');
        </script>
    @endif
</section>

<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-key mr-2 text-orange-600"></i>Current Password
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-gray-50" 
                autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-orange-600"></i>New Password
            </label>
            <input id="update_password_password" name="password" type="password" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-gray-50" 
                autocomplete="new-password">
            @error('password', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-check-circle mr-2 text-orange-600"></i>Confirm Password
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-gray-50" 
                autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" 
                class="px-6 py-3 bg-gradient-to-r from-green-600 to-blue-400 text-black rounded-lg font-semibold hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all duration-300 shadow-lg">
                <i class="fas fa-save mr-2"></i>Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>Password updated successfully!
                </p>
            @endif
        </div>
    </form>
</section>

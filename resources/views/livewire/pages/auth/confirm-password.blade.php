<div>
    <div class="mb-4 text-sm">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form wire:submit="confirmPassword">
        <!-- Password -->
        <div>
            <flux:label for="password" :value="__('Password')" />

            <flux:input wire:model="password"
                          id="password"
                          class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <flux:error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <flux:button variant="primary">
                {{ __('Confirm') }}
            </flux:button>
        </div>
    </form>
</div>

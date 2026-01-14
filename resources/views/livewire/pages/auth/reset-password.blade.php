<div>
    <form wire:submit="resetPassword">
        <div>
            <flux:label>Email</flux:label>
            <flux:input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <flux:error name="email" class="mt-2" />
        </div>

        <div class="mt-4">
            <flux:label>Password</flux:label>
            <flux:input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <flux:error name="password" class="mt-2" />
        </div>

        <div class="mt-4">
            <flux:label>Confirm Password</flux:label>
            <flux:input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <flux:error name="password_confirmation" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <flux:button variant="primary">
                {{ __('Reset Password') }}
            </flux:button>
        </div>
    </form>
</div>
<div>
    <div class="mb-4 text-sm">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <div>
            <flux:input wire:model="email" id="email" type="email" label="Email" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <flux:button type="submit" variant="primary">
                {{ __('Email Password Reset Link') }}
            </flux:button>
        </div>
    </form>
</div>

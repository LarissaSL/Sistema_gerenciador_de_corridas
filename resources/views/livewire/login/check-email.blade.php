<div>
    {{-- Manter o Name e as tags de wire --}}
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email"
            value="{{ old('email', session('email')) }}"
            wire:model="email" 
            wire:blur="checkEmail" 
            class="form-control {{ $isAdmin ? '' : 'is-invalid' }}" 
            placeholder="Digite seu e-mail">
    
    @if(!$isAdmin)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @endif
</div>

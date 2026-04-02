@extends('layouts.app')

@section('title', 'EduFlow | Reinitialiser le mot de passe')

@section('content')
    <section class="auth-wrap">
        <div class="auth-card">
            <div class="hero" style="margin-bottom: 1.5rem;">
                <span class="tag">Securite</span>
                <h2>Reinitialisation du mot de passe</h2>
                <p>Utilisez le token recu par email pour definir un nouveau mot de passe.</p>
            </div>

            <form id="reset-form" class="stack">
                <div class="form-grid">
                    <div>
                        <label for="reset-email">Email</label>
                        <input id="reset-email" type="email" required>
                    </div>
                    <div>
                        <label for="reset-token">Token</label>
                        <input id="reset-token" type="text" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="reset-password">Nouveau mot de passe</label>
                        <input id="reset-password" type="password" required>
                    </div>
                    <div>
                        <label for="reset-password-confirmation">Confirmation</label>
                        <input id="reset-password-confirmation" type="password" required>
                    </div>
                </div>

                <div class="actions">
                    <button class="btn btn-primary" type="submit">Reinitialiser</button>
                    <a class="btn btn-secondary" href="/login">Retour connexion</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const params = new URLSearchParams(window.location.search);
    document.getElementById('reset-email').value = params.get('email') || '';
    document.getElementById('reset-token').value = params.get('token') || '';

    document.getElementById('reset-form').addEventListener('submit', async (event) => {
        event.preventDefault();

        try {
            await apiFetch('/api/auth/reset-password', {
                method: 'POST',
                body: JSON.stringify({
                    email: document.getElementById('reset-email').value,
                    token: document.getElementById('reset-token').value,
                    password: document.getElementById('reset-password').value,
                    password_confirmation: document.getElementById('reset-password-confirmation').value,
                }),
            });

            showToast('Mot de passe reinitialise.', 'success');
            window.location.href = '/login';
        } catch (error) {
            showToast(error.message, 'error');
        }
    });
</script>
@endpush

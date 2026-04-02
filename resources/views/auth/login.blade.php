@extends('layouts.app')

@section('title', 'EduFlow | Connexion')

@section('content')
    <section class="auth-wrap">
        <div class="auth-card">
            <div class="hero" style="margin-bottom: 1.5rem;">
                <span class="tag">Connexion</span>
                <h2>Accedez a votre espace EduFlow</h2>
                <p>Connectez-vous avec votre compte etudiant ou enseignant pour utiliser la plateforme.</p>
            </div>

            <form id="login-form" class="stack">
                <div>
                    <label for="email">Adresse email</label>
                    <input id="email" type="email" placeholder="exemple@eduflow.com" required>
                </div>

                <div>
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" placeholder="Votre mot de passe" required>
                </div>

                <div class="actions">
                    <button class="btn btn-primary" type="submit">Se connecter</button>
                    <a class="btn btn-secondary" href="/register">Creer un compte</a>
                </div>
            </form>

            <div class="panel" style="margin-top: 1.5rem; box-shadow: none;">
                <h3>Mot de passe oublie</h3>
                <p class="helper-text">Recevez un lien de reinitialisation par email.</p>

                <form id="forgot-form" class="actions" style="margin-top: 0.9rem;">
                    <input id="forgot-email" type="email" placeholder="Votre email" required>
                    <button class="btn btn-ghost" type="submit">Envoyer le lien</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.getElementById('login-form').addEventListener('submit', async (event) => {
        event.preventDefault();

        const button = event.target.querySelector('button[type="submit"]');
        button.disabled = true;

        try {
            const payload = await apiFetch('/api/auth/login', {
                method: 'POST',
                body: JSON.stringify({
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
                }),
            });

            setToken(payload.token);
            setStoredUser(payload.user.data ?? payload.user);
            showToast('Connexion reussie.', 'success');

            const user = payload.user.data ?? payload.user;
            window.location.href = user.role === 'teacher' ? '/dashboard' : '/courses';
        } catch (error) {
            showToast(error.message, 'error');
        } finally {
            button.disabled = false;
        }
    });

    document.getElementById('forgot-form').addEventListener('submit', async (event) => {
        event.preventDefault();

        try {
            await apiFetch('/api/auth/forgot-password', {
                method: 'POST',
                body: JSON.stringify({
                    email: document.getElementById('forgot-email').value,
                }),
            });

            showToast('Lien de reinitialisation envoye.', 'success');
        } catch (error) {
            showToast(error.message, 'error');
        }
    });
</script>
@endpush

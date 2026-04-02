@extends('layouts.app')

@section('title', 'EduFlow | Inscription')

@section('content')
    <section class="auth-wrap">
        <div class="auth-card">
            <div class="hero" style="margin-bottom: 1.5rem;">
                <span class="tag">Inscription</span>
                <h2>Creez un compte en quelques secondes</h2>
                <p>Les etudiants peuvent choisir leurs centres d'interet pour recevoir des cours recommandes.</p>
            </div>

            <form id="register-form" class="stack">
                <div class="form-grid">
                    <div>
                        <label for="name">Nom complet</label>
                        <input id="name" type="text" placeholder="Votre nom" required>
                    </div>

                    <div>
                        <label for="email">Adresse email</label>
                        <input id="email" type="email" placeholder="exemple@eduflow.com" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" placeholder="6 caracteres minimum" required>
                    </div>

                    <div>
                        <label for="role">Role</label>
                        <select id="role" required>
                            <option value="student">Etudiant</option>
                            <option value="teacher">Enseignant</option>
                        </select>
                    </div>
                </div>

                <div id="interest-wrapper" class="stack">
                    <div>
                        <label for="interest-select">Centres d'interet</label>
                        <select id="interest-select" multiple size="6"></select>
                        <p class="helper-text">Maintenez Ctrl ou Cmd pour choisir plusieurs interets.</p>
                    </div>
                </div>

                <div class="actions">
                    <button class="btn btn-primary" type="submit">Creer mon compte</button>
                    <a class="btn btn-secondary" href="/login">J'ai deja un compte</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const roleSelect = document.getElementById('role');
    const interestWrapper = document.getElementById('interest-wrapper');
    const interestSelect = document.getElementById('interest-select');

    function updateInterestVisibility() {
        interestWrapper.classList.toggle('hidden', roleSelect.value !== 'student');
    }

    roleSelect.addEventListener('change', updateInterestVisibility);

    document.getElementById('register-form').addEventListener('submit', async (event) => {
        event.preventDefault();
        const button = event.target.querySelector('button[type="submit"]');
        button.disabled = true;

        try {
            const selectedInterests = Array.from(interestSelect.selectedOptions).map((option) => Number(option.value));

            const payload = await apiFetch('/api/auth/register', {
                method: 'POST',
                body: JSON.stringify({
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
                    role: roleSelect.value,
                    interest_ids: roleSelect.value === 'student' ? selectedInterests : [],
                }),
            });

            setToken(payload.token);
            setStoredUser(payload.user.data ?? payload.user);
            showToast('Compte cree avec succes.', 'success');

            const user = payload.user.data ?? payload.user;
            window.location.href = user.role === 'teacher' ? '/dashboard' : '/courses';
        } catch (error) {
            showToast(error.message, 'error');
        } finally {
            button.disabled = false;
        }
    });

    const interests = @json($interests);
    interestSelect.innerHTML = interests.map((interest) => `
        <option value="${interest.id}">${escapeHtml(interest.nom)}</option>
    `).join('');

    updateInterestVisibility();
</script>
@endpush

@extends('layouts.app')

@section('title', 'EduFlow | Mes inscriptions')

@section('content')
    <section class="hero">
        <span class="tag">Mes cours</span>
        <h2>Suivi des inscriptions et statut</h2>
        <p>Retrouvez ici vos cours inscrits, votre groupe et votre statut d'inscription.</p>
    </section>

    <section id="my-courses-list" class="stack"></section>
@endsection

@push('scripts')
<script>
    async function initMyCourses() {
        if (!requireAuth()) {
            return;
        }

        const user = await hydrateUser();
        const wrapper = document.getElementById('my-courses-list');

        if (user?.role !== 'student') {
            wrapper.innerHTML = `
                <div class="empty-state">
                    <h3>Page reservee aux etudiants</h3>
                    <p>Seuls les etudiants peuvent consulter leurs inscriptions.</p>
                </div>
            `;
            return;
        }

        try {
            const inscriptions = await apiFetch('/api/inscriptions/me');

            if (!inscriptions.length) {
                wrapper.innerHTML = `
                    <div class="empty-state">
                        <h3>Aucune inscription pour le moment</h3>
                        <p>Explorez le catalogue et rejoignez votre premier cours.</p>
                    </div>
                `;
                return;
            }

            wrapper.innerHTML = inscriptions.map((item) => `
                <article class="panel">
                    <div class="row-between">
                        <div>
                            <span class="tag">Inscription #${item.id}</span>
                            <h3>${escapeHtml(item.course?.titre || 'Cours')}</h3>
                            <p>Enseignant: ${escapeHtml(item.course?.teacher?.name || 'Non defini')}</p>
                        </div>
                        <div>
                            <span class="status confirmed">${statusBadgeText('confirmed')}</span>
                        </div>
                    </div>

                    <div class="inline-list" style="margin-top: 1rem;">
                        <span class="pill">Prix: ${formatPrice(item.course?.prix)}</span>
                        <span class="pill">Groupe #${item.group?.id || '-'}</span>
                    </div>

                    <div class="card-actions">
                        <a class="btn btn-secondary" href="/courses/${item.course_id}">Voir le cours</a>
                        <button class="btn btn-danger" type="button" onclick="cancelInscription(${item.id})">Se retirer</button>
                    </div>
                </article>
            `).join('');
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    async function cancelInscription(id) {
        try {
            await apiFetch(`/api/inscriptions/${id}`, { method: 'DELETE' });
            showToast('Inscription annulee.', 'success');
            initMyCourses();
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    initMyCourses();
</script>
@endpush

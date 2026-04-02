@extends('layouts.app')

@section('title', 'EduFlow | Cours')

@section('content')
    <section class="hero">
        <span class="tag">Catalogue</span>
        <h2>Explorez les cours disponibles</h2>
        <p>Recherchez un cours, consultez ses details, ajoutez-le aux favoris ou lancez une inscription.</p>

        <div class="form-grid" style="margin-top: 1rem;">
            <div>
                <label for="search-course">Recherche</label>
                <input id="search-course" type="search" placeholder="Titre, enseignant ou mot-cle...">
            </div>
        </div>
    </section>

    <section id="courses-wrapper" class="grid cards"></section>
@endsection

@push('scripts')
<script>
    let allCourses = [];

    function renderCourses(courses) {
        const wrapper = document.getElementById('courses-wrapper');

        if (!courses.length) {
            wrapper.innerHTML = `
                <div class="empty-state">
                    <h3>Aucun cours trouve</h3>
                    <p>Essayez une autre recherche ou revenez plus tard.</p>
                </div>
            `;
            return;
        }

        const user = getStoredUser();
        const isStudent = user?.role === 'student';

        wrapper.innerHTML = courses.map((course) => `
            <article class="card">
                <div class="card-header">
                    <div>
                        <span class="tag">Cours</span>
                        <h3>${escapeHtml(course.titre)}</h3>
                    </div>
                    <strong>${formatPrice(course.prix)}</strong>
                </div>

                <p>${escapeHtml(course.description || 'Aucune description pour le moment.')}</p>

                <div class="inline-list">
                    <span class="pill">Enseignant: ${escapeHtml(course.teacher?.name || 'Non defini')}</span>
                </div>

                <div class="tag-list" style="margin-top: 0.85rem;">
                    ${(course.interests || []).map((interest) => `
                        <span class="tag">${escapeHtml(interest.nom)}</span>
                    `).join('')}
                </div>

                <div class="card-actions">
                    <a class="btn btn-secondary" href="/courses/${course.id}">Voir details</a>
                    ${isStudent ? `<button class="btn btn-primary" type="button" onclick="subscribeToCourse(${course.id})">S'inscrire</button>` : ''}
                    ${isStudent ? `<button class="btn btn-accent" type="button" onclick="addToFavorites(${course.id})">Ajouter aux favoris</button>` : ''}
                    ${isStudent ? `<button class="btn btn-ghost" type="button" onclick="payForCourse(${course.id})">Payer avec Stripe</button>` : ''}
                </div>
            </article>
        `).join('');
    }

    function filterCourses() {
        const term = document.getElementById('search-course').value.toLowerCase().trim();
        if (!term) {
            renderCourses(allCourses);
            return;
        }

        const filtered = allCourses.filter((course) => {
            const haystack = [
                course.titre,
                course.description,
                course.teacher?.name,
                ...(course.interests || []).map((interest) => interest.nom),
            ].join(' ').toLowerCase();

            return haystack.includes(term);
        });

        renderCourses(filtered);
    }

    async function subscribeToCourse(courseId) {
        try {
            await apiFetch('/api/inscriptions', {
                method: 'POST',
                body: JSON.stringify({ course_id: courseId }),
            });
            showToast('Inscription enregistree.', 'success');
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    async function addToFavorites(courseId) {
        try {
            await apiFetch('/api/favorites', {
                method: 'POST',
                body: JSON.stringify({ course_id: courseId }),
            });
            showToast('Cours ajoute aux favoris.', 'success');
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    async function payForCourse(courseId) {
        try {
            const response = await apiFetch('/api/payment/checkout', {
                method: 'POST',
                body: JSON.stringify({ course_id: courseId }),
            });

            if (response.url) {
                showToast('Redirection vers Stripe...', 'info');
                window.location.href = response.url;
            }
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    async function initCoursesPage() {
        if (!requireAuth()) {
            return;
        }

        try {
            const response = await apiFetch('/api/courses');
            allCourses = response.data || [];
            renderCourses(allCourses);
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    document.getElementById('search-course').addEventListener('input', filterCourses);
    initCoursesPage();
</script>
@endpush

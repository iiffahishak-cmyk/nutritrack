@extends('layouts.admin')
@section('title', 'Edit Meal — NutriTrack Admin')

@push('styles')
<style>
:root {
    --blue:#176BFF;
    --blue-dark:#0B3D91;
    --blue-soft:#EAF2FF;
    --green:#16A34A;
    --green-soft:#EAFBF1;
    --orange:#F97316;
    --orange-soft:#FFF4E8;
    --purple:#7C3AED;
    --purple-soft:#F3E8FF;
    --red:#DC2626;
    --red-soft:#FEE2E2;
    --text:#0F172A;
    --muted:#64748B;
    --line:rgba(23,107,255,.12);
    --shadow:0 18px 45px rgba(15,23,42,.07);
}

.form-shell {
    max-width:1200px;
}

.page-hero {
    border-radius:30px;
    padding:1.5rem;
    color:white;
    background:
        radial-gradient(circle at 88% 10%, rgba(255,255,255,.16), transparent 25%),
        linear-gradient(135deg,#071B46,#176BFF);
    margin-bottom:1.2rem;
    box-shadow:0 24px 65px rgba(23,107,255,.16);
}

.page-hero h1 {
    margin:0;
    font-weight:900;
    letter-spacing:-.05em;
    line-height:1.05;
}

.page-hero p {
    margin:.35rem 0 0;
    color:rgba(255,255,255,.78);
}

.panel {
    background:white;
    border:1px solid var(--line);
    border-radius:28px;
    box-shadow:var(--shadow);
    overflow:hidden;
}

.panel-head {
    padding:1rem 1.2rem;
    border-bottom:1px solid rgba(23,107,255,.08);
    background:linear-gradient(180deg,#FFFFFF,#FAFCFF);
}

.panel-head h5 {
    margin:0;
    font-weight:900;
    color:var(--text);
    font-size:1rem;
}

.panel-head small {
    color:var(--muted);
    font-weight:600;
    font-size:.78rem;
}

.panel-body {
    padding:1.2rem;
}

.form-label-modern {
    color:var(--muted);
    font-size:.72rem;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
    margin-bottom:.45rem;
}

.form-control,
.form-select {
    border-radius:16px;
    border:1px solid rgba(23,107,255,.16);
    background:#F8FBFF;
    padding:.8rem .95rem;
    font-weight:700;
}

.form-control:focus,
.form-select:focus {
    background:white;
    border-color:var(--blue);
    box-shadow:0 0 0 4px rgba(23,107,255,.1);
}

textarea.form-control {
    min-height:130px;
    line-height:1.55;
}

.section-stack {
    display:grid;
    gap:1rem;
}

.preview-card {
    border-radius:28px;
    overflow:hidden;
    border:1px solid rgba(23,107,255,.1);
    background:white;
    box-shadow:var(--shadow);
}

.preview-img-wrap {
    position:relative;
    background:var(--blue-soft);
}

.preview-img {
    width:100%;
    height:250px;
    object-fit:cover;
    display:block;
}

.preview-badge {
    position:absolute;
    left:1rem;
    top:1rem;
    background:rgba(255,255,255,.92);
    color:var(--blue-dark);
    border-radius:999px;
    padding:.4rem .7rem;
    font-size:.72rem;
    font-weight:900;
    box-shadow:0 8px 24px rgba(15,23,42,.08);
}

.preview-body {
    padding:1rem;
}

.preview-title {
    font-weight:900;
    color:var(--text);
    font-size:1rem;
    line-height:1.3;
}

.preview-sub {
    color:var(--muted);
    font-size:.8rem;
    margin-top:.25rem;
}

.macro-grid {
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:.75rem;
}

.macro-card {
    border-radius:20px;
    padding:.9rem;
    background:#F8FBFF;
    border:1px solid rgba(23,107,255,.08);
}

.macro-card input {
    background:white;
}

.image-box {
    border-radius:22px;
    background:#F8FBFF;
    border:1px solid rgba(23,107,255,.1);
    padding:1rem;
}

.image-help {
    color:var(--muted);
    font-size:.76rem;
    line-height:1.5;
    margin-top:.4rem;
}

.image-actions {
    display:grid;
    gap:.75rem;
}

.fetch-btn {
    border-radius:999px;
    font-weight:900;
    min-height:46px;
}

.meal-time-grid {
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:.65rem;
}

.cuisine-grid {
    display:grid;
    grid-template-columns:repeat(5, 1fr);
    gap:.65rem;
}

.option-card input {
    display:none;
}

.option-box {
    cursor:pointer;
    border-radius:20px;
    padding:.85rem .55rem;
    text-align:center;
    background:#F8FBFF;
    border:1px solid rgba(23,107,255,.1);
    transition:.18s ease;
    height:100%;
    min-height:92px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
}

.option-box:hover {
    transform:translateY(-2px);
    background:var(--blue-soft);
}

.option-card input:checked + .option-box {
    background:linear-gradient(135deg,var(--blue),var(--blue-dark));
    color:white;
    box-shadow:0 14px 34px rgba(23,107,255,.25);
}

.option-icon {
    display:block;
    font-size:1.35rem;
    margin-bottom:.35rem;
}

.option-title {
    display:block;
    font-weight:900;
    font-size:.78rem;
}

.action-footer {
    position:sticky;
    bottom:1rem;
    z-index:20;
    margin-top:1.2rem;
    padding:1rem 1.1rem;
    background:rgba(255,255,255,.92);
    border:1px solid rgba(23,107,255,.12);
    border-radius:26px;
    box-shadow:0 16px 46px rgba(15,23,42,.12);
    backdrop-filter:blur(14px);
}

.submit-btn {
    min-height:50px;
    border:0;
    border-radius:999px;
    background:linear-gradient(135deg,var(--blue),var(--blue-dark));
    color:white;
    font-weight:900;
    padding:.8rem 1.5rem;
    transition:.2s ease;
}

.submit-btn:hover {
    transform:translateY(-2px);
    color:white;
}

.delete-btn {
    border-radius:999px;
    font-weight:900;
}

@media(max-width:991px) {
    .macro-grid {
        grid-template-columns:repeat(2, 1fr);
    }

    .meal-time-grid,
    .cuisine-grid {
        grid-template-columns:repeat(2, 1fr);
    }

    .action-footer {
        position:static;
    }
}

@media(max-width:575px) {
    .macro-grid,
    .meal-time-grid,
    .cuisine-grid {
        grid-template-columns:1fr;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid py-3 form-shell">

    <div class="page-hero">
        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <div style="font-size:.72rem;font-weight:900;letter-spacing:.08em;text-transform:uppercase;opacity:.8;">
                    Editing Meal
                </div>

                <h1>{{ $meal->meal_name }}</h1>

                <p>
                    Update meal details, nutrition values, category, and image used by the recommendation system.
                </p>
            </div>

            <form action="{{ route('admin.meals.destroy', $meal->meal_id) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this meal permanently?')">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-light delete-btn px-4 text-danger">
                    <i class="bi bi-trash3 me-1"></i>
                    Delete Meal
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <strong>Please check the form:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="meal-update-form"
          action="{{ route('admin.meals.update', $meal->meal_id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4 align-items-start">

            <div class="col-12 col-xl-7">
                <div class="section-stack">

                    <div class="panel">
                        <div class="panel-head">
                            <h5>
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                Basic Information
                            </h5>
                            <small>Meal name, description, and ingredients.</small>
                        </div>

                        <div class="panel-body">
                            <div class="mb-4">
                                <label class="form-label-modern">Meal Name</label>
                                <input type="text"
                                       name="meal_name"
                                       value="{{ old('meal_name', $meal->meal_name) }}"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label-modern">Description</label>
                                <textarea name="description"
                                          class="form-control"
                                          rows="5">{{ old('description', $meal->description) }}</textarea>
                            </div>

                            <div>
                                <label class="form-label-modern">Ingredients</label>
                                <input type="text"
                                       name="ingredients"
                                       value="{{ old('ingredients', $meal->ingredients) }}"
                                       class="form-control"
                                       placeholder="Example: rice, chicken, egg, cucumber">
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-head">
                            <h5>
                                <i class="bi bi-bar-chart text-primary me-2"></i>
                                Nutritional Values
                            </h5>
                            <small>Used for calories, recommendation score, and diary tracking.</small>
                        </div>

                        <div class="panel-body">
                            <div class="macro-grid">
                                @foreach([
                                    'calories' => 'Calories',
                                    'protein' => 'Protein',
                                    'carbs' => 'Carbs',
                                    'fat' => 'Fat',
                                ] as $field => $label)
                                    <div class="macro-card">
                                        <label class="form-label-modern">{{ $label }}</label>
                                        <input type="number"
                                               step="0.1"
                                               name="{{ $field }}"
                                               value="{{ old($field, $meal->$field) }}"
                                               class="form-control"
                                               required>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-head">
                            <h5>
                                <i class="bi bi-clock text-primary me-2"></i>
                                Meal Time
                            </h5>
                            <small>Choose the meal slot for recommendation filtering.</small>
                        </div>

                        <div class="panel-body">
                            <div class="meal-time-grid">
                                @foreach([
                                    'Breakfast' => '🌅',
                                    'Lunch' => '☀️',
                                    'Dinner' => '🌙',
                                    'Snack' => '🍎',
                                ] as $time => $icon)
                                    <label class="option-card">
                                        <input type="radio"
                                               name="meal_time"
                                               value="{{ $time }}"
                                               {{ old('meal_time', $meal->meal_time) === $time ? 'checked' : '' }}
                                               required>

                                        <div class="option-box">
                                            <span class="option-icon">{{ $icon }}</span>
                                            <span class="option-title">{{ $time }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-head">
                            <h5>
                                <i class="bi bi-globe2 text-primary me-2"></i>
                                Cuisine Type
                            </h5>
                            <small>Use the official NutriTrack cuisine categories.</small>
                        </div>

                        <div class="panel-body">
                            <div class="cuisine-grid">
                                @foreach(['Malay','Chinese','Indian','Western','Middle Eastern'] as $cuisine)
                                    <label class="option-card">
                                        <input type="radio"
                                               name="cuisine_type"
                                               value="{{ $cuisine }}"
                                               {{ old('cuisine_type', $meal->cuisine_type) === $cuisine ? 'checked' : '' }}
                                               required>

                                        <div class="option-box">
                                            <span class="option-icon">
                                                @if($cuisine === 'Malay') 🍛
                                                @elseif($cuisine === 'Chinese') 🥢
                                                @elseif($cuisine === 'Indian') 🫓
                                                @elseif($cuisine === 'Western') 🥗
                                                @else 🧆
                                                @endif
                                            </span>
                                            <span class="option-title">{{ $cuisine }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="section-stack">

                    <div class="preview-card">
                        <div class="preview-img-wrap">
                            <img src="{{ old('image_url', $meal->image_url) ?: 'https://placehold.co/800x450/EAF2FF/176BFF?text=No+Meal+Image' }}"
                                 class="preview-img"
                                 alt="{{ $meal->meal_name }}"
                                 id="meal-preview-image">

                            <div class="preview-badge">
                                Live Preview
                            </div>
                        </div>

                        <div class="preview-body">
                            <div class="preview-title">
                                {{ $meal->meal_name }}
                            </div>

                            <div class="preview-sub">
                                {{ $meal->meal_time }} · {{ $meal->cuisine_type ?? 'No cuisine' }}
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <span class="badge rounded-pill bg-primary">{{ $meal->calories }} kcal</span>
                                <span class="badge rounded-pill bg-light text-dark border">P {{ $meal->protein }}g</span>
                                <span class="badge rounded-pill bg-light text-dark border">C {{ $meal->carbs }}g</span>
                                <span class="badge rounded-pill bg-light text-dark border">F {{ $meal->fat }}g</span>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-head">
                            <h5>
                                <i class="bi bi-image text-primary me-2"></i>
                                Meal Image
                            </h5>
                            <small>Choose one image method below.</small>
                        </div>

                        <div class="panel-body">
                            <div class="image-actions">

                                <div class="image-box">
                                    <label class="form-label-modern">Upload Image Yourself</label>
                                    <input type="file"
                                           name="image_file"
                                           id="image_file"
                                           class="form-control"
                                           accept="image/jpeg,image/png,image/jpg,image/webp">

                                    <div class="image-help">
                                        Best option for accurate meal photos. Accepted: JPG, PNG, WEBP.
                                    </div>
                                </div>

                                <div class="image-box">
                                    <label class="form-label-modern">Paste Image URL</label>
                                    <input type="url"
                                           name="image_url"
                                           id="image_url"
                                           value="{{ old('image_url', $meal->image_url) }}"
                                           class="form-control"
                                           placeholder="https://example.com/meal-photo.jpg">

                                    <div class="image-help">
                                        Use this if the image is already online. Uploaded image will be prioritized if both are provided.
                                    </div>
                                </div>

                                <button type="button"
                                        class="btn btn-outline-primary fetch-btn w-100"
                                        onclick="document.getElementById('fetch-image-form').submit();">
                                    <i class="bi bi-image me-1"></i>
                                    Fetch New Image Automatically
                                </button>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="action-footer d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <div class="fw-bold text-dark">Ready to update this meal?</div>
                <div class="text-muted small">
                    Save after editing details, nutrition, meal time, cuisine, or image.
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.meals.index') }}" class="btn btn-light rounded-pill px-4 fw-bold border">
                    Cancel
                </a>

                <button type="submit" class="submit-btn">
                    <i class="bi bi-check-lg me-1"></i>
                    Save Changes
                </button>
            </div>
        </div>

    </form>

    <form id="fetch-image-form"
          action="{{ route('admin.meals.fetch-image', $meal->meal_id) }}"
          method="POST"
          class="d-none">
        @csrf
    </form>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageFileInput = document.getElementById('image_file');
    const imageUrlInput = document.getElementById('image_url');
    const previewImage = document.getElementById('meal-preview-image');

    if (imageFileInput && previewImage) {
        imageFileInput.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                previewImage.src = event.target.result;
            };

            reader.readAsDataURL(file);
        });
    }

    if (imageUrlInput && previewImage) {
        imageUrlInput.addEventListener('input', function () {
            const value = this.value.trim();

            if (value !== '') {
                previewImage.src = value;
            }
        });
    }
});
</script>
@endpush
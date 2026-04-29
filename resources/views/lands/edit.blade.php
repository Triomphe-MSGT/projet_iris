@extends('layouts.terrainvente')

@section('title', 'Modifier: ' . $land->title)

@section('content')
<div class="page-wrap-sm">
    <div class="page-header">
        <a href="{{ route('lands.show', $land) }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Retour à l'annonce
        </a>
        <h1>Modifier l'annonce</h1>
        <p>Mettez à jour les informations de votre terrain.</p>
    </div>

    <form action="{{ route('lands.update', $land) }}" method="POST" enctype="multipart/form-data" class="card card-body">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="form-label">Titre de l'annonce</label>
            <input type="text" name="title" id="title" class="form-input" value="{{ old('title', $land->title) }}" required>
            @error('title') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description détaillée</label>
            <textarea name="description" id="description" rows="5" class="form-textarea" required>{{ old('description', $land->description) }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="price_cfa" class="form-label">Prix (FCFA)</label>
                <div class="input-prefix-wrap">
                    <span class="input-prefix">CFA</span>
                    <input type="number" name="price_cfa" id="price_cfa" class="form-input" value="{{ old('price_cfa', $land->price_cfa) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Statut</label>
                <select name="status" id="status" class="form-select">
                    <option value="disponible" {{ $land->status == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="en_attente" {{ $land->status == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="vendu"      {{ $land->status == 'vendu'      ? 'selected' : '' }}>Vendu</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="location" class="form-label">Quartier / Localisation</label>
            <input type="text" name="location" id="location" class="form-input" value="{{ old('location', $land->location) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Image du terrain</label>

            <!-- Image actuelle ou nouvelle prévisualisation -->
            <div id="preview-box" style="margin-bottom:1rem; position:relative; border-radius:14px; overflow:hidden; border:2px solid var(--primary); aspect-ratio:16/9; max-height:260px; {{ $land->image_path ? '' : 'display:none;' }}">
                <img id="preview-img"
                     src="{{ $land->image_path ? asset('storage/' . $land->image_path) : '' }}"
                     alt="Aperçu" style="width:100%;height:100%;object-fit:cover;">
                <button type="button" id="remove-img" style="position:absolute;top:.5rem;right:.5rem;background:rgba(0,0,0,0.6);color:white;border:none;border-radius:50%;width:28px;height:28px;cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;">✕</button>
            </div>

            <div class="upload-zone" id="upload-zone" style="{{ $land->image_path ? 'display:none;' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 0.75rem;opacity:.35;color:var(--primary)"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <p><span class="upload-cta">Cliquez pour remplacer</span> ou glissez une image</p>
                <p style="font-size:.8rem;margin-top:.25rem;">PNG, JPG, WEBP jusqu'à 2MB</p>
                <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
            </div>
            @error('image') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div style="padding-top:1rem;">
            <button type="submit" class="btn btn-primary btn-full" style="padding:1rem;font-size:1rem;justify-content:center;">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

<script>
(function () {
    const input      = document.getElementById('image');
    const previewBox = document.getElementById('preview-box');
    const previewImg = document.getElementById('preview-img');
    const removeBtn  = document.getElementById('remove-img');
    const uploadZone = document.getElementById('upload-zone');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            previewBox.style.display = 'block';
            uploadZone.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    removeBtn.addEventListener('click', function () {
        input.value = '';
        previewImg.src = '';
        previewBox.style.display = 'none';
        uploadZone.style.display = 'block';
    });

    // Drag & drop
    uploadZone.addEventListener('dragover', function (e) {
        e.preventDefault();
        this.style.borderColor = 'var(--primary)';
        this.style.background  = 'var(--primary-light)';
    });
    uploadZone.addEventListener('dragleave', function () {
        this.style.borderColor = '';
        this.style.background  = '';
    });
    uploadZone.addEventListener('drop', function (e) {
        e.preventDefault();
        this.style.borderColor = '';
        this.style.background  = '';
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            input.dispatchEvent(new Event('change'));
        }
    });
})();
</script>
@endsection

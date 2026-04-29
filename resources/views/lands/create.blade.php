@extends('layouts.terrainvente')

@section('title', 'Mettre en vente un Terrain')

@section('content')
<div class="page-wrap-sm">
    <div class="page-header">
        <a href="{{ route('dashboard') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Retour au tableau de bord
        </a>
        <h1>Nouvelle Annonce</h1>
        <p>Remplissez les informations ci-dessous pour lister votre terrain à Dschang.</p>
    </div>

    <form action="{{ route('lands.store') }}" method="POST" enctype="multipart/form-data" class="card card-body">
        @csrf

        <div class="form-group">
            <label for="title" class="form-label">Titre de l'annonce</label>
            <input type="text" name="title" id="title" class="form-input" placeholder="Ex: Terrain titré à Foto, 500m²" required value="{{ old('title') }}">
            @error('title') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description détaillée</label>
            <textarea name="description" id="description" rows="5" class="form-textarea" placeholder="Décrivez les atouts du terrain, l'accès, l'environnement..." required>{{ old('description') }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="price_cfa" class="form-label">Prix (FCFA)</label>
                <div class="input-prefix-wrap">
                    <span class="input-prefix">CFA</span>
                    <input type="number" name="price_cfa" id="price_cfa" class="form-input" placeholder="0" required value="{{ old('price_cfa') }}">
                </div>
                @error('price_cfa') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="location" class="form-label">Quartier / Localisation</label>
                <input type="text" name="location" id="location" class="form-input" placeholder="Ex: Keleng, Dschang" required value="{{ old('location', 'Dschang') }}">
                @error('location') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Photographie du terrain</label>

            <!-- Prévisualisation -->
            <div id="preview-box" style="display:none; margin-bottom:1rem; position:relative; border-radius:14px; overflow:hidden; border:2px solid var(--primary); aspect-ratio:16/9; max-height:260px;">
                <img id="preview-img" src="" alt="Aperçu" style="width:100%;height:100%;object-fit:cover;">
                <button type="button" id="remove-img" style="position:absolute;top:.5rem;right:.5rem;background:rgba(0,0,0,0.6);color:white;border:none;border-radius:50%;width:28px;height:28px;cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;">✕</button>
            </div>

            <div class="upload-zone" id="upload-zone">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 0.75rem;opacity:.35;color:var(--primary)"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <p id="upload-label"><span class="upload-cta">Cliquez pour choisir</span> ou glissez une image ici</p>
                <p style="font-size:.8rem;margin-top:.25rem;">PNG, JPG, WEBP jusqu'à 2MB</p>
                <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
            </div>
            @error('image') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div style="padding-top:1rem;">
            <button type="submit" class="btn btn-primary btn-full" style="padding:1rem;font-size:1rem;justify-content:center;">
                Publier l'annonce
            </button>
        </div>
    </form>
</div>

<script>
(function () {
    const input     = document.getElementById('image');
    const previewBox= document.getElementById('preview-box');
    const previewImg= document.getElementById('preview-img');
    const removeBtn = document.getElementById('remove-img');
    const uploadZone= document.getElementById('upload-zone');
    const uploadLabel=document.getElementById('upload-label');

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

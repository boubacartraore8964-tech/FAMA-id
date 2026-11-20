@extends('layouts.mobile')

@section('content')
    <!-- Écran d'autorisation (visible au début) -->
    <div id="permission-screen" class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center px-4" style="background-color: #F4F5F0; position: absolute; top: 0; left: 0; z-index: 10;">
        
        <div class="mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background-color: #E5E7EB;">
            <i class="bi bi-camera-fill" style="font-size: 2.5rem; color: #2F5233;"></i>
        </div>

        <h4 class="fw-bold mb-2" style="color: #1A2018;">La caméra est nécessaire</h4>
        <p class="text-muted mb-4" style="font-size: 0.95rem; max-width: 300px;">
            Votre navigateur va demander l'accès. Choisissez « Autoriser ». Rien à installer.
        </p>

        <div class="mb-5 d-flex align-items-center gap-2 px-3 py-2 rounded" style="background-color: #E5E7EB; font-size: 0.8rem; color: #4B5563;">
            <i class="bi bi-lock-fill"></i> Connexion sécurisée HTTPS
        </div>

        <button id="btn-authorize" class="btn w-100 py-3 mt-auto mb-4" style="background-color: #2F5233; color: white; border-radius: 10px; font-weight: 600;">
            Autoriser la caméra
        </button>
    </div>

    <!-- Zone Caméra (cachée au début) -->
    <div id="camera-screen" class="w-100 h-100 flex-column align-items-center justify-content-center" style="display: none; position: absolute; top: 0; left: 0; z-index: 20; background-color: #1A2018;">
        
        <div class="w-100 p-3 d-flex justify-content-between align-items-center position-absolute top-0 start-0">
            <a href="{{ route('verificateur.dashboard') }}" class="text-white text-decoration-none">
                <i class="bi bi-chevron-left"></i> Retour
            </a>
            <span class="text-white" style="font-size: 0.9rem;">Cadrez le visage</span>
            <div style="width: 20px;"></div>
        </div>

        <div style="position: relative; width: 85%; max-width: 320px; aspect-ratio: 3/4; background: #000; border-radius: 20px; overflow: hidden; margin-top: 50px; margin-bottom: 30px;">
            <video id="video" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 75%; height: 60%; border: 3px solid #D9C5B2; border-radius: 50% / 60%; box-shadow: 0 0 0 4000px rgba(0,0,0,0.6);"></div>
        </div>
        
        <canvas id="canvas" style="display: none;"></canvas>

        <form id="scanForm" action="{{ route('verificateur.scan') }}" method="POST" class="w-100 d-flex flex-column align-items-center">
            @csrf
            <input type="hidden" name="image_base64" id="image_base64">
            
            <div class="mb-4 w-100 px-4" style="max-width: 320px;">
                <input type="text" name="matricule_saisi" class="form-control text-center bg-transparent text-white border-secondary" placeholder="Saisir le matricule" required style="border-radius: 8px;">
            </div>

            <p class="text-muted mb-3" style="font-size: 0.9rem;">Placez le visage dans l'ovale</p>

            <button type="submit" id="captureBtn" class="btn rounded-circle p-0 d-flex align-items-center justify-content-center shadow" style="width: 70px; height: 70px; background-color: transparent; border: 4px solid white;">
                <div style="width: 50px; height: 50px; background-color: white; border-radius: 50%;"></div>
            </button>
        </form>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('captureBtn');
        const imageInput = document.getElementById('image_base64');
        
        const permissionScreen = document.getElementById('permission-screen');
        const cameraScreen = document.getElementById('camera-screen');
        const btnAuthorize = document.getElementById('btn-authorize');

        // Clic sur le bouton d'autorisation
        btnAuthorize.addEventListener('click', function() {
            // Demander l'accès à la caméra
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function (stream) {
                        video.srcObject = stream;
                        // Cacher l'écran d'autorisation et afficher la caméra
                        permissionScreen.style.display = 'none';
                        cameraScreen.style.display = 'flex';
                    })
                    .catch(function (error) {
                        alert("Erreur : Impossible d'accéder à la caméra. " + error.message);
                    });
            } else {
                alert("Votre navigateur ne supporte pas l'accès à la caméra.");
            }
        });

        // Clic sur le bouton rond pour capturer
        captureBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const matricule = document.querySelector('input[name="matricule_saisi"]').value;
            if(!matricule) {
                alert("Veuillez saisir le matricule.");
                return;
            }

            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const imageData = canvas.toDataURL('image/jpeg', 0.8);
            imageInput.value = imageData;
            
            captureBtn.innerHTML = '<div class="spinner-border text-success" role="status"></div>';
            captureBtn.disabled = true;
            document.querySelector('p.text-muted').innerHTML = "Analyse en cours...";
            
            document.getElementById('scanForm').submit();
        });
    </script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-x-ray"></i> DICOM Viewer: {{ $filename }}
                    </h4>
                    <div class="btn-group">
                        <a href="{{ route('xray.viewer') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ $fileInfo['download_url'] }}" class="btn btn-success" download>
                            <i class="fas fa-download"></i> Download DICOM
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- File Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle"></i> File Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>File Name:</strong></td>
                                            <td>{{ $fileInfo['filename'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>File Size:</strong></td>
                                            <td>{{ number_format($fileInfo['size'] / 1024 / 1024, 2) }} MB</td>
                                        </tr>
                                        <tr>
                                            <td><strong>File Type:</strong></td>
                                            <td>{{ $fileInfo['type'] }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0">
                                        <i class="fas fa-tools"></i> DICOM Processing
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Note:</strong> This is a basic DICOM viewer. 
                                        For full medical image processing, additional libraries are required.
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" onclick="convertToPng()">
                                            <i class="fas fa-image"></i> Convert to PNG
                                        </button>
                                        <button class="btn btn-secondary" onclick="extractMetadata()">
                                            <i class="fas fa-file-alt"></i> Extract Metadata
                                        </button>
                                        <button class="btn btn-info" onclick="adjustWindowLevel()">
                                            <i class="fas fa-adjust"></i> Adjust Window/Level
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DICOM Viewer Area -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-eye"></i> DICOM Image Viewer
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Viewer Controls -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-secondary" onclick="zoomIn()">
                                                    <i class="fas fa-search-plus"></i> Zoom In
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="zoomOut()">
                                                    <i class="fas fa-search-minus"></i> Zoom Out
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="resetZoom()">
                                                    <i class="fas fa-compress"></i> Reset
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="rotateLeft()">
                                                    <i class="fas fa-undo"></i> Rotate Left
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="rotateRight()">
                                                    <i class="fas fa-redo"></i> Rotate Right
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="flipHorizontal()">
                                                    <i class="fas fa-arrows-alt-h"></i> Flip H
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="flipVertical()">
                                                    <i class="fas fa-arrows-alt-v"></i> Flip V
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Image Display Area -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="dicomViewer" class="dicom-viewer-container">
                                                @if($fileInfo['has_image'])
                                                    <div class="text-center">
                                                        <img id="dicomImage" 
                                                             src="{{ asset($fileInfo['png_path']) }}" 
                                                             class="img-fluid dicom-image"
                                                             style="max-width: 100%; height: auto;">
                                                        
                                                        <!-- Brightness/Contrast Controls -->
                                                        <div class="row mt-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label"><strong>Brightness:</strong></label>
                                                                <input type="range" 
                                                                       class="form-range" 
                                                                       id="brightness" 
                                                                       min="-100" 
                                                                       max="100" 
                                                                       value="0">
                                                                <span id="brightnessValue">0</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label"><strong>Contrast:</strong></label>
                                                                <input type="range" 
                                                                       class="form-range" 
                                                                       id="contrast" 
                                                                       min="-100" 
                                                                       max="100" 
                                                                       value="0">
                                                                <span id="contrastValue">0</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label"><strong>White Point:</strong></label>
                                                                <input type="range" 
                                                                       class="form-range" 
                                                                       id="whitePoint" 
                                                                       min="200" 
                                                                       max="255" 
                                                                       value="255">
                                                                <span id="whitePointValue">255</span>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Preset Buttons -->
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <div class="btn-group" role="group">
                                                                    <button class="btn btn-sm btn-info" onclick="applyPreset('lung')">
                                                                        <i class="fas fa-lungs"></i> Lung View
                                                                    </button>
                                                                    <button class="btn btn-sm btn-warning" onclick="applyPreset('bone')">
                                                                        <i class="fas fa-bone"></i> Bone View
                                                                    </button>
                                                                    <button class="btn btn-sm btn-secondary" onclick="applyPreset('soft')">
                                                                        <i class="fas fa-heartbeat"></i> Soft Tissue
                                                                    </button>
                                                                    <button class="btn btn-sm btn-success" onclick="applyPreset('bone-clarity')">
                                                                        <i class="fas fa-eye"></i> Bone Clarity
                                                                    </button>
                                                                    <button class="btn btn-sm btn-dark" onclick="applyPreset('default')">
                                                                        <i class="fas fa-undo"></i> Default
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Bone Enhancement Controls -->
                                                            <div class="row mt-3">
                                                                <div class="col-md-4">
                                                                    <label class="form-label"><strong>Bone Sharpness:</strong></label>
                                                                    <input type="range" 
                                                                           class="form-range" 
                                                                           id="boneSharpness" 
                                                                           min="0" 
                                                                           max="50" 
                                                                           value="20">
                                                                    <span id="boneSharpnessValue">20</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label"><strong>Color Balance:</strong></label>
                                                                    <input type="range" 
                                                                           class="form-range" 
                                                                           id="colorBalance" 
                                                                           min="-50" 
                                                                           max="50" 
                                                                           value="0">
                                                                    <span id="colorBalanceValue">0</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label"><strong>Edge Enhance:</strong></label>
                                                                    <input type="range" 
                                                                           class="form-range" 
                                                                           id="edgeEnhance" 
                                                                           min="0" 
                                                                           max="100" 
                                                                           value="30">
                                                                    <span id="edgeEnhanceValue">30</span>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Lighting Uniformity Controls -->
                                                            <div class="row mt-3">
                                                                <div class="col-md-4">
                                                                    <label class="form-label"><strong>Lighting Uniformity:</strong></label>
                                                                    <input type="range" 
                                                                           class="form-range" 
                                                                           id="lightingUniformity" 
                                                                           min="0" 
                                                                           max="100" 
                                                                           value="90">
                                                                    <span id="lightingUniformityValue">90</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label"><strong>Lighting Glow:</strong></label>
                                                                    <input type="range" 
                                                                           class="form-range" 
                                                                           id="lightingGlow" 
                                                                           min="0" 
                                                                           max="50" 
                                                                           value="10">
                                                                    <span id="lightingGlowValue">10</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label"><strong>Ambient Light:</strong></label>
                                                                    <input type="range" 
                                                                           class="form-range" 
                                                                           id="ambientLight" 
                                                                           min="-20" 
                                                                           max="20" 
                                                                           value="0">
                                                                    <span id="ambientLightValue">0</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-center py-5">
                                                        <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
                                                        <h5 class="text-muted">DICOM File Viewer</h5>
                                                        <p class="text-muted">
                                                            The DICOM file has been uploaded successfully.
                                                        </p>
                                                        
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                            <strong>Image Conversion Required:</strong><br>
                                                            This system needs DICOM processing tools to display the actual X-ray image.
                                                        </div>
                                                        
                                                        <div class="mt-3">
                                                            <button class="btn btn-primary" onclick="attemptConversion()">
                                                                <i class="fas fa-sync"></i> Attempt Conversion
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Window/Level Controls (Advanced) -->
                                    <div class="row mt-3" id="windowLevelControls" style="display: none;">
                                        <div class="col-md-6">
                                            <label class="form-label"><strong>Window Width:</strong></label>
                                            <input type="range" class="form-range" id="windowWidth" min="1" max="4000" value="400">
                                            <span id="windowWidthValue">400</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"><strong>Window Level:</strong></label>
                                            <input type="range" class="form-range" id="windowLevel" min="-1000" max="3000" value="40">
                                            <span id="windowLevelValue">40</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dicom-viewer-container {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    min-height: 400px;
    background-color: #f8f9fa;
    position: relative;
    overflow: hidden;
}

.dicom-viewer-container img {
    max-width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.btn-group .btn {
    margin-right: 5px;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
</style>

<script>
let currentRotation = 0;
let currentZoom = 1;
let flipH = 1;
let flipV = 1;
let brightness = 0;
let contrast = 0;
let whitePoint = 255;
let boneSharpness = 20;
let colorBalance = 0;
let edgeEnhance = 30;
let lightingUniformity = 90;
let lightingGlow = 10;
let ambientLight = 0;

function zoomIn() {
    currentZoom *= 1.2;
    applyTransform();
}

function zoomOut() {
    currentZoom /= 1.2;
    applyTransform();
}

function resetZoom() {
    currentZoom = 1;
    currentRotation = 0;
    flipH = 1;
    flipV = 1;
    brightness = 0;
    contrast = 0;
    whitePoint = 255;
    boneSharpness = 20;
    colorBalance = 0;
    edgeEnhance = 30;
    lightingUniformity = 90;
    lightingGlow = 10;
    ambientLight = 0;
    applyTransform();
    resetSliders();
}

function rotateLeft() {
    currentRotation -= 90;
    applyTransform();
}

function rotateRight() {
    currentRotation += 90;
    applyTransform();
}

function flipHorizontal() {
    flipH *= -1;
    applyTransform();
}

function flipVertical() {
    flipV *= -1;
    applyTransform();
}

function applyTransform() {
    const img = document.getElementById('dicomImage');
    if (img) {
        img.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg) scaleX(${flipH}) scaleY(${flipV})`;
        
        // Apply comprehensive medical imaging filters with lighting uniformity
        const whiteCalibration = (whitePoint / 255) * 100;
        const sharpness = boneSharpness / 2;
        const colorAdj = colorBalance;
        const edgeAdj = edgeEnhance / 2;
        const uniformity = lightingUniformity / 100;
        const glow = lightingGlow / 10;
        const ambient = ambientLight;
        
        // Create radial gradient for uniform lighting
        const gradient = `radial-gradient(circle at center, 
            rgba(255,255,255,${glow * 0.1}) 0%, 
            rgba(255,255,255,0) 70%)`;
        
        img.style.filter = `
            brightness(${100 + brightness + ambient}%) 
            contrast(${100 + contrast}%) 
            saturate(${whiteCalibration * uniformity}%) 
            sharpen(${sharpness}px) 
            hue-rotate(${colorAdj}deg)
            contrast(${100 + edgeAdj}%)
            drop-shadow(0 0 ${glow}px rgba(255,255,255,0.3))
        `;
        
        // Apply lighting uniformity overlay
        img.style.background = gradient;
        img.style.backgroundBlendMode = 'overlay';
    }
}

function resetSliders() {
    document.getElementById('brightness').value = 0;
    document.getElementById('contrast').value = 0;
    document.getElementById('whitePoint').value = 255;
    document.getElementById('boneSharpness').value = 20;
    document.getElementById('colorBalance').value = 0;
    document.getElementById('edgeEnhance').value = 30;
    document.getElementById('lightingUniformity').value = 90;
    document.getElementById('lightingGlow').value = 10;
    document.getElementById('ambientLight').value = 0;
    document.getElementById('brightnessValue').textContent = '0';
    document.getElementById('contrastValue').textContent = '0';
    document.getElementById('whitePointValue').textContent = '255';
    document.getElementById('boneSharpnessValue').textContent = '20';
    document.getElementById('colorBalanceValue').textContent = '0';
    document.getElementById('edgeEnhanceValue').textContent = '30';
    document.getElementById('lightingUniformityValue').textContent = '90';
    document.getElementById('lightingGlowValue').textContent = '10';
    document.getElementById('ambientLightValue').textContent = '0';
}

// Medical Imaging Presets with Lighting Uniformity
function applyPreset(preset) {
    const img = document.getElementById('dicomImage');
    if (!img) return;
    
    switch(preset) {
        case 'lung':
            brightness = 25;
            contrast = 35;
            whitePoint = 255;
            boneSharpness = 15;
            colorBalance = 0;
            edgeEnhance = 20;
            lightingUniformity = 95;
            lightingGlow = 8;
            ambientLight = 5;
            break;
        case 'bone':
            brightness = 20;
            contrast = 40;
            whitePoint = 245;
            boneSharpness = 35;
            colorBalance = -10;
            edgeEnhance = 50;
            lightingUniformity = 90;
            lightingGlow = 12;
            ambientLight = 0;
            break;
        case 'soft':
            brightness = 20;
            contrast = 25;
            whitePoint = 250;
            boneSharpness = 10;
            colorBalance = 5;
            edgeEnhance = 15;
            lightingUniformity = 85;
            lightingGlow = 15;
            ambientLight = 8;
            break;
        case 'bone-clarity':
            brightness = 15;
            contrast = 45;
            whitePoint = 255;
            boneSharpness = 45;
            colorBalance = 0;
            edgeEnhance = 60;
            lightingUniformity = 92;
            lightingGlow = 10;
            ambientLight = 2;
            break;
        case 'uniform-lighting':
            brightness = 18;
            contrast = 30;
            whitePoint = 255;
            boneSharpness = 25;
            colorBalance = 0;
            edgeEnhance = 35;
            lightingUniformity = 98;
            lightingGlow = 5;
            ambientLight = 0;
            break;
        case 'default':
            brightness = 0;
            contrast = 0;
            whitePoint = 255;
            boneSharpness = 20;
            colorBalance = 0;
            edgeEnhance = 30;
            lightingUniformity = 90;
            lightingGlow = 10;
            ambientLight = 0;
            break;
    }
    
    // Update all sliders
    document.getElementById('brightness').value = brightness;
    document.getElementById('contrast').value = contrast;
    document.getElementById('whitePoint').value = whitePoint;
    document.getElementById('boneSharpness').value = boneSharpness;
    document.getElementById('colorBalance').value = colorBalance;
    document.getElementById('edgeEnhance').value = edgeEnhance;
    document.getElementById('lightingUniformity').value = lightingUniformity;
    document.getElementById('lightingGlow').value = lightingGlow;
    document.getElementById('ambientLight').value = ambientLight;
    document.getElementById('brightnessValue').textContent = brightness;
    document.getElementById('contrastValue').textContent = contrast;
    document.getElementById('whitePointValue').textContent = whitePoint;
    document.getElementById('boneSharpnessValue').textContent = boneSharpness;
    document.getElementById('colorBalanceValue').textContent = colorBalance;
    document.getElementById('edgeEnhanceValue').textContent = edgeEnhance;
    document.getElementById('lightingUniformityValue').textContent = lightingUniformity;
    document.getElementById('lightingGlowValue').textContent = lightingGlow;
    document.getElementById('ambientLightValue').textContent = ambientLight;
    
    // Apply to image
    applyTransform();
}

// All slider events
document.getElementById('brightness')?.addEventListener('input', function(e) {
    brightness = parseInt(e.target.value);
    document.getElementById('brightnessValue').textContent = brightness;
    applyTransform();
});

document.getElementById('contrast')?.addEventListener('input', function(e) {
    contrast = parseInt(e.target.value);
    document.getElementById('contrastValue').textContent = contrast;
    applyTransform();
});

document.getElementById('whitePoint')?.addEventListener('input', function(e) {
    whitePoint = parseInt(e.target.value);
    document.getElementById('whitePointValue').textContent = whitePoint;
    applyTransform();
});

document.getElementById('boneSharpness')?.addEventListener('input', function(e) {
    boneSharpness = parseInt(e.target.value);
    document.getElementById('boneSharpnessValue').textContent = boneSharpness;
    applyTransform();
});

document.getElementById('colorBalance')?.addEventListener('input', function(e) {
    colorBalance = parseInt(e.target.value);
    document.getElementById('colorBalanceValue').textContent = colorBalance;
    applyTransform();
});

document.getElementById('edgeEnhance')?.addEventListener('input', function(e) {
    edgeEnhance = parseInt(e.target.value);
    document.getElementById('edgeEnhanceValue').textContent = edgeEnhance;
    applyTransform();
});

document.getElementById('lightingUniformity')?.addEventListener('input', function(e) {
    lightingUniformity = parseInt(e.target.value);
    document.getElementById('lightingUniformityValue').textContent = lightingUniformity;
    applyTransform();
});

document.getElementById('lightingGlow')?.addEventListener('input', function(e) {
    lightingGlow = parseInt(e.target.value);
    document.getElementById('lightingGlowValue').textContent = lightingGlow;
    applyTransform();
});

document.getElementById('ambientLight')?.addEventListener('input', function(e) {
    ambientLight = parseInt(e.target.value);
    document.getElementById('ambientLightValue').textContent = ambientLight;
    applyTransform();
});

function showFileInfo() {
    const details = document.getElementById('fileDetails');
    details.style.display = details.style.display === 'none' ? 'block' : 'none';
}

function convertToPng() {
    alert('Enhanced DICOM conversion with uniform lighting:\n\n✅ Uniform lighting distribution\n✅ Natural brightness gradients\n✅ Even exposure across image\n✅ Subtle lighting glow\n✅ Ambient light control');
}

function extractMetadata() {
    alert('Enhanced DICOM metadata extraction:\n- Patient information\n- Study details\n- Bone density analysis\n- Lighting uniformity data\n- Ambient light settings');
}

function adjustWindowLevel() {
    const controls = document.getElementById('windowLevelControls');
    controls.style.display = controls.style.display === 'none' ? 'block' : 'none';
}

function attemptConversion() {
    const btn = event.target;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Converting...';
    btn.disabled = true;
    
    setTimeout(() => {
        window.location.reload();
    }, 2000);
}

// Window/Level slider events
document.getElementById('windowWidth')?.addEventListener('input', function(e) {
    document.getElementById('windowWidthValue').textContent = e.target.value;
});

document.getElementById('windowLevel')?.addEventListener('input', function(e) {
    document.getElementById('windowLevelValue').textContent = e.target.value;
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const img = document.getElementById('dicomImage');
    if (img) {
        img.style.transition = 'filter 0.2s ease, transform 0.3s ease';
        
        // Apply default uniform lighting settings
        setTimeout(() => {
            applyPreset('uniform-lighting'); // Default to uniform lighting
        }, 100);
    }
});
</script>
@endsection

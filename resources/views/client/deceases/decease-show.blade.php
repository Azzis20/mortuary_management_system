@extends('client.layouts.app')

@section('title', 'Deceased Details - ' . $deceased->name)

@section('content')
<div class="page-header">
    <div class="header-actions">
        <div>
            <h1 class="page-title">Deceased Details</h1>
            <p class="page-subtitle">Complete information for {{ $deceased->name }}</p>
        </div>
        <a href="{{ route('client.decease.index') }}" class="btn btn-primary">
            ← Back to List
        </a>
    </div>
</div>

<div class="details-grid">
    <!-- Left Column -->
    <div class="details-column">
        <!-- Deceased Information Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Deceased Information</h2>
            </div>
            <div class="case-info">
                <div class="info-item">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value">{{ $deceased->name }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Gender:</span>
                    <span class="info-value">{{ ucfirst($deceased->gender) }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Date of Birth:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($deceased->date_of_birth)->format('F d, Y') }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Date of Death:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($deceased->date_of_death)->format('F d, Y') }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Age at Death:</span>
                    <span class="info-value">
                      {{ $deceased->date_of_birth->diff($deceased->date_of_death)->y }} years old
                    </span>
                </div>

                @if($deceased->cause_of_death)
                <div class="info-item">
                    <span class="info-label">Cause of Death:</span>
                    <span class="info-value">{{ $deceased->cause_of_death }}</span>
                </div>
                @endif

                <div class="info-item info-meta">
                    <span class="info-label">Registered On:</span>
                    <span class="info-value">
                        {{ $deceased->created_at->format('F d, Y \a\t g:i A') }}
                    </span>
                </div>

                @if($deceased->updated_at != $deceased->created_at)
                <div class="info-item">
                    <span class="info-label">Last Updated:</span>
                    <span class="info-value">
                        {{ $deceased->updated_at->format('F d, Y \a\t g:i A') }}
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Next of Kin Information Card -->
        @if($deceased->nextOfKins)
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Next of Kin Information</h2>
            </div>
            <div class="case-info">
                <div class="info-item">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value">{{ $deceased->nextOfKins->name }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Relationship:</span>
                    <span class="info-value">{{ ucfirst($deceased->nextOfKins->relationship) }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Contact Number:</span>
                    <span class="info-value">{{ $deceased->nextOfKins->contact_number }}</span>
                </div>

                @if($deceased->nextOfKins->email)
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $deceased->nextOfKins->email }}</span>
                </div>
                @endif

                <div class="info-item">
                    <span class="info-label">Address:</span>
                    <span class="info-value">{{ $deceased->nextOfKins->address }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column - Document Viewer -->
    <div class="details-column">
        <div class="card document-card">
            <div class="card-header">
                <h2 class="card-title">Supporting Document</h2>
            </div>
            <div class="document-viewer">
                @if($deceased->document)
                    @php
                        $extension = pathinfo($deceased->document, PATHINFO_EXTENSION);
                        $isPdf = strtolower($extension) === 'pdf';
                    @endphp

                    @if($isPdf)
                        <!-- PDF Viewer -->
                        <div class="pdf-container">
                            <embed 
                                src="{{ asset($deceased->document) }}" 
                                type="application/pdf" 
                                width="100%" 
                                height="800px"
                            />
                        </div>
                        <div class="document-actions">
                            <!-- <a href="{{ asset($deceased->document) }}" 
                               target="_blank" 
                               class="btn btn-primary"
                               download>
                                📥 Download PDF
                            </a> -->
                            <a href="{{ asset($deceased->document) }}" 
                               target="_blank" 
                               class="btn btn-secondary">
                                🔍 Open in New Tab
                            </a>
                        </div>
                    @else
                        <!-- Image Viewer -->
                        <div class="image-container">
                            <img 
                                src="{{ asset($deceased->document) }}" 
                                alt="Document for {{ $deceased->name }}"
                                class="document-image"
                            />
                        </div>
                        <div class="document-actions">
                            <!-- <a href="{{ asset($deceased->document) }}" 
                               target="_blank" 
                               class="btn btn-primary"
                               download>
                                📥 Download Image
                            </a> -->
                            <a href="{{ asset($deceased->document) }}" 
                               target="_blank" 
                               class="btn btn-secondary">
                                🔍 View Full Size
                            </a>
                        </div>
                    @endif
                @else
                    <!-- No Document -->
                    <div class="empty-state">
                        <div class="empty-state-icon">📄</div>
                        <p class="empty-state-title">No document uploaded</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Header Actions */
.header-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

/* Details Grid */
.details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.details-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Document Viewer */
.document-viewer {
    padding: 1.5rem;
}

.pdf-container {
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    overflow: hidden;
}

.pdf-container embed {
    display: block;
}

.image-container {
    text-align: center;
}

.document-image {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.document-actions {
    margin-top: 1rem;
    text-align: center;
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Info Meta Styling */
.info-meta {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.info-meta .info-value {
    color: #718096;
}

/* ==================== RESPONSIVE DESIGN ==================== */

/* Tablet (768px and below) */
@media (max-width: 768px) {
    .header-actions {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-actions .btn {
        width: 100%;
    }

    .details-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .pdf-container embed {
        height: 500px;
    }

    .document-actions {
        flex-direction: column;
    }

    .document-actions .btn {
        width: 100%;
    }
}

/* Small Mobile (480px and below) */
@media (max-width: 480px) {
    .pdf-container embed {
        height: 400px;
    }

    .document-viewer {
        padding: 1rem;
    }

    .document-actions {
        gap: 0.75rem;
    }
}

/* Extra Small Mobile (360px and below) */
@media (max-width: 360px) {
    .pdf-container embed {
        height: 300px;
    }
}

/* Landscape Mobile */
@media (max-width: 768px) and (orientation: landscape) {
    .pdf-container embed {
        height: 350px;
    }
}
</style>
@endsection
@extends('layouts.app')

@section('title', 'Panel Supervisor')

@push('head')
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="color-scheme" content="light only">
@endpush

@section('content')
    {{-- Header Minimalista --}}
    <div class="minimal-header" style="margin-top: 85px;">
        <div class="container">
            <div class="header-content">
                <div class="user-section">
                    {{-- <div class="user-avatar-mini">
                        <i class="fas fa-user-shield"></i>
                    </div> --}}
                    <div class="user-details">
                        <h4 class="user-name-mini"><i class="fas fa-user-shield"></i> {{ Auth::user()->name }}</h4>
                        <div class="status-badge">
                            <i class="fas fa-circle"></i>
                            <span>En Servicio</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        
        @livewire('supervisores.inspecciones', ['designacion_id' => $designaciones->id])
    </div>

    {{-- Estilos Material Design --}}
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/styleHomeVS.css') }}">
    @endpush

    {{-- JavaScript Optimizado Material Design --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-refresh optimizado con visibilidad de página
                let refreshInterval;

                function startAutoRefresh() {
                    refreshInterval = setTimeout(() => {
                        // Solo refrescar si la página está visible
                        if (!document.hidden) {
                            window.location.reload();
                        } else {
                            // Si la página no está visible, reintentar en 10 segundos
                            startAutoRefresh();
                        }
                    }, 60000); // 60 segundos
                }

                // Manejar cambios de visibilidad de la página - passive
                document.addEventListener('visibilitychange', function() {
                    if (document.hidden) {
                        // Página oculta, pausar el refresh
                        clearTimeout(refreshInterval);
                    } else {
                        // Página visible, reanudar el refresh
                        startAutoRefresh();
                    }
                }, {
                    passive: true
                });

                // Efectos de interacción mejorados - optimizado para passive events
                const functionCards = document.querySelectorAll('.function-card');

                functionCards.forEach(card => {
                    // Efecto de tap en móvil - passive para mejor rendimiento
                    card.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.95)';
                    }, {
                        passive: true
                    });

                    // Touch end para efecto visual - passive
                    card.addEventListener('touchend', function() {
                        this.style.transform = '';
                    }, {
                        passive: true
                    });

                    // Separar la lógica de prevención de zoom doble tap
                    let touchTime = 0;
                    card.addEventListener('touchstart', function(event) {
                        // Solo prevenir zoom si hay múltiples toques rápidos
                        if (event.touches.length > 1) return;

                        const currentTime = new Date().getTime();
                        const tapLength = currentTime - touchTime;

                        if (tapLength < 300 && tapLength > 0) {
                            event.preventDefault();
                        }
                        touchTime = currentTime;
                    }, {
                        passive: false
                    }); // NO passive solo para prevenir zoom
                });

                // Feedback háptico en dispositivos compatibles
                function provideFeedback() {
                    if ('vibrate' in navigator) {
                        navigator.vibrate(50); // Vibración corta
                    }
                }

                // Agregar feedback a las tarjetas importantes - passive para mejor rendimiento
                const emergencyCard = document.querySelector('.emergency-card');
                const notificationCards = document.querySelectorAll('.has-notification');

                if (emergencyCard) {
                    emergencyCard.addEventListener('click', provideFeedback, {
                        passive: true
                    });
                }

                notificationCards.forEach(card => {
                    card.addEventListener('click', provideFeedback, {
                        passive: true
                    });
                });

                // Iniciar el auto-refresh
                startAutoRefresh();

                // Manejar errores de red para reintentar después - passive
                window.addEventListener('offline', function() {
                    clearTimeout(refreshInterval);
                    console.log('Aplicación sin conexión - pausando auto-refresh');
                }, {
                    passive: true
                });

                window.addEventListener('online', function() {
                    startAutoRefresh();
                    console.log('Conexión restaurada - reanudando auto-refresh');
                }, {
                    passive: true
                });

                // Mejora de accesibilidad - keydown requiere preventDefault así que NO passive
                const cards = document.querySelectorAll('.card-link');
                cards.forEach(card => {
                    card.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            this.click();
                        }
                    }); // Sin passive porque usamos preventDefault
                });

                // Animación de entrada progresiva
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }, index * 100);
                        }
                    });
                });

                // Aplicar animación de entrada a las tarjetas
                functionCards.forEach(card => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    observer.observe(card);
                });
            });
        </script>
    @endpush
@endsection

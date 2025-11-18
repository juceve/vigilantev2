// Nombre del caché (cámbialo cuando actualices assets)
const CACHE_NAME = 'vigilancia-static-v3';

// Solo cachea archivos estáticos
const ASSETS_TO_CACHE = [
    '/css/app.css',
    '/web/js/scripts.js',
    '/images/logo_shield.png'
];

// 🛠️ Instalación
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
    self.skipWaiting(); // activa el SW sin esperar
});

// ♻️ Activación - limpia versiones viejas
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys
                    .filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            );
        })
    );
    self.clients.claim();
});

// 🔍 Estrategia de fetch
self.addEventListener('fetch', event => {
    const request = event.request;

    // Solo cachea assets estáticos por extensión
    if (request.url.match(/\.(?:js|css|png|jpg|jpeg|svg|gif|woff2?)$/)) {
        event.respondWith(
            caches.open(CACHE_NAME).then(cache => {
                return cache.match(request).then(cachedResponse => {
                    if (cachedResponse) return cachedResponse;

                    return fetch(request).then(networkResponse => {
                        // ✅ Evitar error: solo cachear si es http/https
                        if (request.url.startsWith('http')) {
                            cache.put(request, networkResponse.clone());
                        }
                        return networkResponse;
                    });
                });
            })
        );
    } else {
        // 🧠 Para HTML y rutas dinámicas SIEMPRE trae desde el servidor
        event.respondWith(
            fetch(request).catch(() => {
                // Opcional: servir un fallback si no hay red
                return new Response(
                    '<h1>Sin conexión</h1><p>No se pudo cargar la página.</p>',
                    { headers: { 'Content-Type': 'text/html' } }
                );
            })
        );
    }
});

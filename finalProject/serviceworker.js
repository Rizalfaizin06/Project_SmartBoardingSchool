
// const CACHE_NAME = 'contoh-pwa-cache-v2';
// const urlsToCache = [
//   '/Project_SmartBoardingSchool/finalProject/assets/images/avatar/gb.jpg'
// ];

// self.addEventListener('install', event => {
//   event.waitUntil(
//     caches.open(CACHE_NAME)
//       .then(cache => {
//         console.log('Cache dibuat: ', cache);
//         return cache.addAll(urlsToCache);
//       })
//   );
// });

// self.addEventListener('fetch', event => {
//   event.respondWith(
//     caches.match(event.request)
//       .then(response => {
//         if (response) {
//           return response;
//         }

//         return fetch(event.request)
//           .then(response => {
//             if (!response || response.status !== 200 || response.type !== 'basic') {
//               return response;
//             }

//             const responseToCache = response.clone();
//             caches.open(CACHE_NAME)
//               .then(cache => {
//                 cache.put(event.request, responseToCache);
//               });

//             return response;
//           });
//       })
//   );
// });



const CACHE_NAME = 'no-cache';

// Menangani event install
self.addEventListener('install', event => {
  console.log('Service worker berhasil diinstal');

  // Memastikan service worker langsung aktif
  self.skipWaiting();
});

// Menangani event activate
self.addEventListener('activate', event => {
  console.log('Service worker berhasil diaktifkan');

  // Menghapus cache lama jika ada
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.filter(cacheName => {
          return cacheName !== CACHE_NAME;
        }).map(cacheName => {
          return caches.delete(cacheName);
        })
      );
    })
  );

  // Mengaktifkan service worker di semua client yang terhubung
  return self.clients.claim();
});

// Menangani event fetch
self.addEventListener('fetch', event => {
  console.log('Fetch dilakukan: ', event.request.url);

  // Melewatkan request ke server tanpa melakukan caching
  event.respondWith(fetch(event.request));
});
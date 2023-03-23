// (A) FILES TO CACHE
const cName = "phpcal",
cFiles = [
  "calendar.js",
  "css/calendar.css",
  "manifest.json",
  "img/favicon-32.png",
  "img/favicon-512.png"
];

// (B) CREATE/INSTALL CACHE
self.addEventListener("install", evt => evt.waitUntil(
  caches.open(cName)
  .then(cache => cache.addAll(cFiles))
  .catch(err => console.error(err))
));

// (C) LOAD FROM CACHE FIRST, FALLBACK TO NETWORK IF NOT FOUND
self.addEventListener("fetch", evt => evt.respondWith(
  caches.match(evt.request).then(res => res || fetch(evt.request))
));
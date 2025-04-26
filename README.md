# Laravel Emergency Response Coordination App

A Laravel + Vue-powered emergency response app to dispatch help quickly based on real-time location data.

## Features
- SOS Button with location
- Real-time request dashboard using Laravel WebSockets
- Map view of emergencies (Leaflet.js)

## About the Project

This app allows users to send emergency requests via a large SOS button, which captures their real-time location and dispatches it to a central dashboard. The Responder can then view incoming calls on a live map and coordinate help efficiently.

It’s ideal for use in urban safety systems, campuses, or community health response setups.

## How It Works

1. **User sends an SOS request**  
   The frontend captures geolocation and sends it to the Laravel backend.

2. **Real-time broadcasting**  
   Laravel Reverb broadcasts the request to listener.

3. **Dashboard response**  
   Emergency calls are plotted live on a Leaflet map, showing location, time, and status.


## Stack
- Laravel 12
- Vue 3, Leaflet.js
- SQLite/MySQL/PostgreSQL

## Setup
```bash
git clone https://github.com/aslammaududy/emergency-call.git
cd emergency-call
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
npm install (if using NPM)
composer run dev
php artisan reverb:start

## Future Improvements

- [ ] Authentication & role-based access (admin/responder/citizen)
- [ ] Notification system for responders
- [ ] Mobile-friendly UI for faster access
- [ ] Better error handling and validations
- [ ] Unit and feature tests

Contributions and suggestions are welcome!

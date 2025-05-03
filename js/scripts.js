document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS animations
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true
        });
    }
    
    // Initialize all carousels
    var carousels = document.querySelectorAll('.carousel');
    if (carousels.length > 0 && typeof bootstrap !== 'undefined') {
        carousels.forEach(function(carousel) {
            new bootstrap.Carousel(carousel);
        });
    }
    
    // Mobile offcanvas menu
    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function() {
            const targetId = this.getAttribute('data-bs-target');
            const offcanvasMenu = document.querySelector(targetId);
            
            if (offcanvasMenu && typeof bootstrap !== 'undefined') {
                const offcanvas = new bootstrap.Offcanvas(offcanvasMenu);
                offcanvas.show();
            }
        });
    }
    
    // Function to toggle visibility of event details
    function toggleEventDetails(eventId) {
        const eventDetails = document.querySelector(`.event-details[data-event-id="${eventId}"]`);
        if (eventDetails) {
            eventDetails.classList.toggle('active');
        }
    }
    
    // Event delegation for event detail toggles
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('event-toggle')) {
            const eventId = event.target.getAttribute('data-event-id');
            toggleEventDetails(eventId);
        }
    });
    
    // Attach event listeners to 'Add to Calendar' buttons
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('add-reminder') || 
            event.target.closest('.add-reminder')) {
            const button = event.target.classList.contains('add-reminder') ? 
                event.target : event.target.closest('.add-reminder');
            const eventName = button.getAttribute('data-event-name');
            const eventTime = button.getAttribute('data-event-time');
            addReminder(eventName, eventTime);
        }
    });
    
    function addReminder(eventName, eventTime) {
        if (confirm('Do you want to add "' + eventName + '" to your calendar at ' + eventTime + '?')) {
            window.open(createGoogleCalendarLink(eventName, eventTime));
        }
    }
    
    function createGoogleCalendarLink(eventName, eventTime) {
        const startTime = encodeURIComponent(new Date(eventTime).toISOString());
        const endTime = encodeURIComponent(new Date(new Date(eventTime).getTime() + 3600000).toISOString());
        return `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventName)}&dates=${startTime}/${endTime}&details=&location=`;
    }
    
    // Back to top button
    const backToTopButton = document.getElementById('back-to-top');
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Check if map element exists
    if (document.getElementById('map')) {
        // Check if Google Maps API is loaded
        if (typeof google !== 'undefined' && google.maps) {
            initMap();
        }
    }
    
    // Check if campus life map element exists
    if (document.getElementById('campus-life-map')) {
        // Check if Google Maps API is loaded
        if (typeof google !== 'undefined' && google.maps) {
            if (typeof initCampusLifeMap === 'function') {
                initCampusLifeMap();
            }
        }
    }
});

// Google Maps initialization function - make it global for async loading
window.initMap = function() {
    // Coordinates for University of Wolverhampton
    const universityLocation = { lat: 52.5874, lng: -2.1278 };
    
    // Check if google is defined
    if (typeof google === 'undefined') {
        console.error('Google Maps API not loaded');
        return;
    }
    
    // Check if map element exists
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        return;
    }
    
    const map = new google.maps.Map(mapElement, {
        zoom: 15,
        center: universityLocation,
        mapTypeControl: true,
        streetViewControl: true,
        fullscreenControl: true,
        styles: [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [{"color": "#6a1b9a"}]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [{"color": "#f5f5f5"}]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [{"visibility": "off"}]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [{"saturation": -100}, {"lightness": 45}]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [{"visibility": "simplified"}]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [{"visibility": "off"}]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [{"visibility": "off"}]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [{"color": "#9c27b0"}, {"visibility": "on"}]
            }
        ]
    });
    
    // Add marker for the university
    const marker = new google.maps.Marker({
        position: universityLocation,
        map: map,
        title: 'University of Wolverhampton',
        animation: google.maps.Animation.DROP
    });
    
    // Add info window for the marker
    const infoWindow = new google.maps.InfoWindow({
        content: '<div><h4>University of Wolverhampton</h4><p>Welcome to our campus!</p></div>'
    });
    
    marker.addListener('click', function() {
        infoWindow.open(map, marker);
    });
};
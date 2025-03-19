document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');
    
    // Mobile navigation toggle
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');
    
    if (burger && navLinks) {
        burger.addEventListener('click', function() {
            navLinks.classList.toggle('nav-active');
            burger.classList.toggle('toggle');
        });
    }
    
    // Countdown timer for Open Day
    const countdownDate = new Date('May 15, 2025 09:00:00').getTime();
    let countdownTimer; // Declare timer variable
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = countdownDate - now;
        
        // Calculate time units
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Update the DOM with fallbacks in case elements don't exist
        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');
        
        // If countdown is finished or passed
        if (distance < 0) {
            clearInterval(countdownTimer);
            
            // Set all values to 0
            if (daysEl) daysEl.textContent = '00';
            if (hoursEl) hoursEl.textContent = '00';
            if (minutesEl) minutesEl.textContent = '00';
            if (secondsEl) secondsEl.textContent = '00';
            
            // Optional: Update the countdown message
            const countdownContainer = document.querySelector('.countdown');
            if (countdownContainer) {
                const countdownMessage = document.createElement('div');
                countdownMessage.className = 'countdown-message';
                countdownMessage.textContent = 'Event has already occurred';
                
                // Check if message already exists before adding
                if (!document.querySelector('.countdown-message')) {
                    countdownContainer.appendChild(countdownMessage);
                }
            }
        } else {
            // Update with current values
            if (daysEl) daysEl.textContent = days.toString().padStart(2, '0');
            if (hoursEl) hoursEl.textContent = hours.toString().padStart(2, '0');
            if (minutesEl) minutesEl.textContent = minutes.toString().padStart(2, '0');
            if (secondsEl) secondsEl.textContent = seconds.toString().padStart(2, '0');
        }
    }
    
    // First update immediately
    updateCountdown();
    
    // Then start the interval
    countdownTimer = setInterval(updateCountdown, 1000);
    
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (document.querySelector(targetId)) {
                e.preventDefault();
                
                document.querySelector(targetId).scrollIntoView({
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                if (navLinks && navLinks.classList.contains('nav-active')) {
                    navLinks.classList.remove('nav-active');
                    if (burger) burger.classList.remove('toggle');
                }
            }
        });
    });
    
    // Testimonial slider functionality - FIXED
    function initTestimonialSlider() {
        const testimonials = document.querySelectorAll('.testimonial');
        const prevButton = document.getElementById('prev-testimonial');
        const nextButton = document.getElementById('next-testimonial');
        
        if (testimonials.length > 0 && prevButton && nextButton) {
            let currentTestimonial = 0;
            let testimonialInterval;
            
            // Make sure only one testimonial is active
            function showTestimonial(index) {
                testimonials.forEach((testimonial, i) => {
                    if (i === index) {
                        testimonial.classList.add('active');
                    } else {
                        testimonial.classList.remove('active');
                    }
                });
            }
            
            // Initial display - show first testimonial
            showTestimonial(0);
            
            prevButton.addEventListener('click', function() {
                clearInterval(testimonialInterval);
                currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
                showTestimonial(currentTestimonial);
                startAutoRotation();
            });
            
            nextButton.addEventListener('click', function() {
                clearInterval(testimonialInterval);
                currentTestimonial = (currentTestimonial + 1) % testimonials.length;
                showTestimonial(currentTestimonial);
                startAutoRotation();
            });
            
            function startAutoRotation() {
                clearInterval(testimonialInterval);
                testimonialInterval = setInterval(function() {
                    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
                    showTestimonial(currentTestimonial);
                }, 7000);
            }
            
            startAutoRotation();
        }
    }
    
    // Initialize testimonial slider
    initTestimonialSlider();
    
    // Special requirements toggle
    const specialRequirementsCheckbox = document.getElementById('specialRequirements');
    const specialRequirementsDetails = document.querySelector('.special-requirements-details');
    
    if (specialRequirementsCheckbox && specialRequirementsDetails) {
        specialRequirementsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                specialRequirementsDetails.classList.remove('hidden');
            } else {
                specialRequirementsDetails.classList.add('hidden');
            }
        });
    }
    
    // Form submission handling
    const openDayForm = document.getElementById('openDayForm');
    const successModal = document.getElementById('successModal');
    const closeModalBtn = document.querySelector('.close-modal');
    const closeModalButton = document.getElementById('closeModal');
    
    if (openDayForm) {
        // Update form action to the correct processing script
        openDayForm.setAttribute('action', 'register_process.php');
        openDayForm.setAttribute('method', 'post');
        
        // Check for query parameter to show success modal
        if (window.location.search.includes('registration=success')) {
            if (successModal) {
                successModal.style.display = 'flex';
            }
        }
        
        // Remove data-demo if this is a production environment
        if (openDayForm.getAttribute('data-demo') === 'true') {
            console.log('Form in demo mode - client-side validation only');
            
            openDayForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Basic form validation
                const fullName = document.getElementById('fullName').value.trim();
                const email = document.getElementById('email').value.trim();
                const studyLevel = document.getElementById('studyLevel').value;
                const subjectInterest = document.getElementById('subjectInterest').value;
                const termsAgree = document.getElementById('termsAgree').checked;
                
                if (!fullName || !email || !studyLevel || !subjectInterest || !termsAgree) {
                    alert('Please fill in all required fields marked with *');
                    return;
                }
                
                // Email validation
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    alert('Please enter a valid email address');
                    return;
                }
                
                // Show success modal
                if (successModal) {
                    successModal.style.display = 'flex';
                }
                
                // Reset form
                openDayForm.reset();
                if (specialRequirementsDetails) {
                    specialRequirementsDetails.classList.add('hidden');
                }
            });
        }
    }
    
    // Close modal when X is clicked
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            successModal.style.display = 'none';
        });
    }
    
    // Close modal when close button is clicked
    if (closeModalButton) {
        closeModalButton.addEventListener('click', function() {
            successModal.style.display = 'none';
        });
    }
    
    // Close modal when clicking outside of it
    if (successModal) {
        window.addEventListener('click', function(e) {
            if (e.target === successModal) {
                successModal.style.display = 'none';
            }
        });
    }
    
    // Fix for FAQ Accordion
    function initAccordions() {
        const accordionItems = document.querySelectorAll('.accordion-item');
        
        accordionItems.forEach((item) => {
            const header = item.querySelector('.accordion-header');
            const content = item.querySelector('.accordion-content');
            const icon = item.querySelector('.accordion-icon i');
            
            if (header && content) {
                // Make sure accordions start closed
                item.classList.remove('active');
                content.style.maxHeight = '0px';
                if (icon) icon.className = 'fas fa-plus';
                
                header.addEventListener('click', function() {
                    // Toggle active state
                    const isActive = item.classList.contains('active');
                    
                    // Close all accordions first (optional)
                    accordionItems.forEach((otherItem) => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                            const otherContent = otherItem.querySelector('.accordion-content');
                            const otherIcon = otherItem.querySelector('.accordion-icon i');
                            
                            if (otherContent) otherContent.style.maxHeight = '0px';
                            if (otherIcon) otherIcon.className = 'fas fa-plus';
                        }
                    });
                    
                    // Toggle the clicked accordion
                    if (isActive) {
                        item.classList.remove('active');
                        content.style.maxHeight = '0px';
                        if (icon) icon.className = 'fas fa-plus';
                    } else {
                        item.classList.add('active');
                        content.style.maxHeight = content.scrollHeight + 'px';
                        if (icon) icon.className = 'fas fa-minus';
                    }
                });
            }
        });
    }
    
    // Initialize accordions
    initAccordions();
    
    // Make sure mobile events button is visible on small screens
    function checkMobileEvents() {
        const desktopEvents = document.querySelector('.desktop-events');
        const mobileEventsButton = document.querySelector('.mobile-events-button');
        
        if (desktopEvents && mobileEventsButton) {
            if (window.innerWidth <= 768) {
                desktopEvents.style.display = 'none';
                mobileEventsButton.style.display = 'block';
            } else {
                desktopEvents.style.display = 'block';
                mobileEventsButton.style.display = 'none';
            }
        }
    }
    
    // Check on load and resize
    checkMobileEvents();
    window.addEventListener('resize', checkMobileEvents);
    
    // Check for and display session messages
    function checkSessionMessages() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error') || urlParams.has('success')) {
            const targetSection = document.getElementById('register');
            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    }
    
    // Run session message check
    checkSessionMessages();
});

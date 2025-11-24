// Live Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInputDesktop = document.getElementById('page-header-search-input2');
    const searchInputMobile = document.getElementById('page-header-search-input');
    
    // Create results dropdown
    function createResultsDropdown(inputElement) {
        const dropdown = document.createElement('div');
        dropdown.className = 'live-search-results';
        dropdown.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: none;
        `;
        
        // Insert dropdown after input's parent
        const parent = inputElement.closest('.input-group') || inputElement.closest('form');
        if (parent) {
            parent.style.position = 'relative';
            parent.appendChild(dropdown);
        }
        
        return dropdown;
    }
    
    // Debounce function to limit API calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Perform live search
    function performLiveSearch(query, dropdown) {
        if (query.length < 2) {
            dropdown.style.display = 'none';
            return;
        }
        
        // Show loading state
        dropdown.innerHTML = '<div class="p-3 text-center"><i class="fa fa-spinner fa-spin"></i> Searching...</div>';
        dropdown.style.display = 'block';
        
        // Fetch search results
        fetch(`/search?q=${encodeURIComponent(query)}&ajax=1`)
            .then(response => response.json())
            .then(data => {
                displayResults(data, dropdown, query);
            })
            .catch(error => {
                dropdown.innerHTML = '<div class="p-3 text-danger">Error loading results</div>';
            });
    }
    
    // Display search results in dropdown
    function displayResults(data, dropdown, query) {
        if (!data.patients.length && !data.doctors.length && !data.appointments.length) {
            dropdown.innerHTML = `
                <div class="p-3 text-center text-muted">
                    <i class="fa fa-search mb-2"></i>
                    <p class="mb-0">No results found for "${query}"</p>
                </div>
            `;
            return;
        }
        
        let html = '';
        
        // Patients section
        if (data.patients.length > 0) {
            html += '<div class="p-2 bg-light border-bottom"><strong><i class="fa fa-user-injured text-primary mr-1"></i> Patients</strong></div>';
            data.patients.forEach(patient => {
                html += `
                    <a href="/patients/${patient.id}" class="d-block p-2 text-dark hover-bg-light border-bottom" style="text-decoration: none;">
                        <div class="font-w600">${patient.name}</div>
                        <small class="text-muted">${patient.phone} • ${patient.gender}</small>
                    </a>
                `;
            });
        }
        
        // Doctors section
        if (data.doctors.length > 0) {
            html += '<div class="p-2 bg-light border-bottom"><strong><i class="fa fa-user-md text-success mr-1"></i> Doctors</strong></div>';
            data.doctors.forEach(doctor => {
                html += `
                    <a href="/doctors/${doctor.id}" class="d-block p-2 text-dark hover-bg-light border-bottom" style="text-decoration: none;">
                        <div class="font-w600">${doctor.name}</div>
                        <small class="text-muted">${doctor.specialization || 'N/A'}</small>
                    </a>
                `;
            });
        }
        
        // Appointments section
        if (data.appointments.length > 0) {
            html += '<div class="p-2 bg-light border-bottom"><strong><i class="fa fa-calendar text-info mr-1"></i> Appointments</strong></div>';
            data.appointments.forEach(appointment => {
                html += `
                    <a href="/appointments/${appointment.id}" class="d-block p-2 text-dark hover-bg-light border-bottom" style="text-decoration: none;">
                        <div class="font-w600">${appointment.patient_name} - ${appointment.doctor_name}</div>
                        <small class="text-muted">${appointment.date}</small>
                    </a>
                `;
            });
        }
        
        // View all results link
        html += `
            <a href="/search?q=${encodeURIComponent(query)}" class="d-block p-2 text-center bg-light text-primary font-w600" style="text-decoration: none;">
                View All Results <i class="fa fa-arrow-right ml-1"></i>
            </a>
        `;
        
        dropdown.innerHTML = html;
    }
    
    // Setup live search for an input
    function setupLiveSearch(inputElement) {
        if (!inputElement) return;
        
        const dropdown = createResultsDropdown(inputElement);
        
        const debouncedSearch = debounce((query) => {
            performLiveSearch(query, dropdown);
        }, 300);
        
        inputElement.addEventListener('input', function() {
            debouncedSearch(this.value);
        });
        
        inputElement.addEventListener('focus', function() {
            if (this.value.length >= 2) {
                dropdown.style.display = 'block';
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!inputElement.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    }
    
    // Initialize live search for both desktop and mobile
    setupLiveSearch(searchInputDesktop);
    setupLiveSearch(searchInputMobile);
});

// Add hover effect styles
const style = document.createElement('style');
style.textContent = `
    .hover-bg-light:hover {
        background-color: #f8f9fa !important;
    }
`;
document.head.appendChild(style);

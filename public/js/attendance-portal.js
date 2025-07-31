/**
 * Attendance Portal JavaScript
 * 
 * This file contains the JavaScript code for the employee attendance portal.
 * It handles the following functionality:
 * - Real-time clock and date display
 * - Attendance status checking
 * - Check-in and check-out operations
 * - Selfie capture for attendance verification
 * - Geolocation tracking
 * 
 * Updated for mobile app-like UI
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check if in admin view mode
    const isAdminView = document.querySelector('body').classList.contains('admin-view') || 
                        document.querySelector('.bg-yellow-50.border-l-4.border-yellow-400') !== null;
    // DOM Elements
    const currentDateEl = document.getElementById('current-date');
    const currentTimeEl = document.getElementById('current-time');
    
    // Attendance Status Elements
    const attendanceStatusBadge = document.getElementById('attendance-status-badge');
    const attendanceStatusText = document.getElementById('attendance-status-text');
    
    // Time Values
    const timeInValue = document.getElementById('time-in-value');
    const timeInComplete = document.getElementById('time-in-complete');
    const timeOutComplete = document.getElementById('time-out-complete');
    const workDuration = document.getElementById('work-duration');
    
    // Action Buttons
    const scanAttendanceBtn = document.getElementById('scan-attendance-btn');
    
    // Time In Modal Elements
    const timeInModal = document.getElementById('time-in-modal');
    const timeInForm = document.getElementById('time-in-form');
    const timeInMethod = document.getElementById('time-in-method');
    const timeInLocation = document.getElementById('time-in-location');
    const timeInNotes = document.getElementById('time-in-notes');
    const timeInCancel = document.getElementById('time-in-cancel');
    const timeInSubmit = document.getElementById('time-in-submit');
    
    // Camera Elements for Time In
    const startCameraBtn = document.getElementById('start-camera-btn');
    const takeSelfieBtn = document.getElementById('take-selfie-btn');
    const retakeSelfieBtn = document.getElementById('retake-selfie-btn');
    const cameraPreview = document.getElementById('camera-preview');
    const cameraPlaceholder = document.getElementById('camera-placeholder');
    const selfieCanvas = document.getElementById('selfie-canvas');
    const selfiePreview = document.getElementById('selfie-preview');
    
    // Time Out Modal Elements
    const timeOutModal = document.getElementById('time-out-modal');
    const timeOutForm = document.getElementById('time-out-form');
    const timeOutNotes = document.getElementById('time-out-notes');
    const timeOutCancel = document.getElementById('time-out-cancel');
    const timeOutSubmit = document.getElementById('time-out-submit');
    
    // Camera Elements for Time Out
    const startCameraOutBtn = document.getElementById('start-camera-out-btn');
    const takeSelfieOutBtn = document.getElementById('take-selfie-out-btn');
    const retakeSelfieOutBtn = document.getElementById('retake-selfie-out-btn');
    const cameraOutPreview = document.getElementById('camera-out-preview');
    const cameraOutPlaceholder = document.getElementById('camera-out-placeholder');
    const selfieOutCanvas = document.getElementById('selfie-out-canvas');
    const selfieOutPreview = document.getElementById('selfie-out-preview');
    
    // Global Variables
    let stream = null;
    let streamOut = null;
    let selfieBlob = null;
    let selfieOutBlob = null;
    let latitude = null;
    let longitude = null;
    let todayAttendance = null;
    let attendanceState = 'loading'; // 'loading', 'not_checked_in', 'checked_in', 'checked_out'
    
    // Initialize the page
    init();
    
    /**
     * Initialize the page
     */
    function init() {
        // Start the clock
        updateDateTime();
        setInterval(updateDateTime, 1000);
        
        // Check attendance status
        checkAttendanceStatus();
        
        // Get geolocation
        getGeolocation();
        
        // Add event listeners
        addEventListeners();
    }
    
    /**
     * Update the date and time display
     */
    function updateDateTime() {
        const now = new Date();
        
        if (currentDateEl) {
            // Format date: Monday, 31 July 2025
            const dateOptions = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            currentDateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
        }
        
        if (currentTimeEl) {
            // Format time: 09:19 (without seconds for mobile UI)
            const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: false };
            currentTimeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
        }
    }
    
    /**
     * Check the attendance status for today
     */
    function checkAttendanceStatus() {
        // If in admin view mode, show a demo status instead of making an API call
        if (isAdminView) {
            // Set demo status
            attendanceState = 'checked_in';
            updateStatusSummary();
            
            // Display demo time in
            const demoTimeIn = '08:30';
            if (timeInValue) timeInValue.textContent = demoTimeIn;
            
            return;
        }
        
        fetch('/api/attendance/today-status', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                todayAttendance = data.attendance;
                
                if (!data.has_checked_in) {
                    // Not checked in yet
                    attendanceState = 'not_checked_in';
                } else if (!data.has_checked_out) {
                    // Checked in but not out
                    attendanceState = 'checked_in';
                    
                    // Display time in
                    const timeIn = new Date(data.attendance.time_in);
                    if (timeInValue) timeInValue.textContent = timeIn.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                } else {
                    // Checked out
                    attendanceState = 'checked_out';
                    
                    // Display time in and out
                    const timeIn = new Date(data.attendance.time_in);
                    const timeOut = new Date(data.attendance.time_out);
                    
                    if (timeInComplete) timeInComplete.textContent = timeIn.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                    if (timeOutComplete) timeOutComplete.textContent = timeOut.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                    
                    // Calculate and display work duration
                    const durationMinutes = data.attendance.work_duration_minutes;
                    const hours = Math.floor(durationMinutes / 60);
                    const minutes = durationMinutes % 60;
                    
                    if (workDuration) workDuration.textContent = `${hours} jam ${minutes} menit`;
                }
                
                // Update status summary
                updateStatusSummary();
            } else {
                console.error('Failed to get attendance status:', data.message);
                
                // Set default status
                attendanceState = 'not_checked_in';
                updateStatusSummary();
            }
        })
        .catch(error => {
            console.error('Error checking attendance status:', error);
            
            // Set default status
            attendanceState = 'not_checked_in';
            updateStatusSummary();
        });
    }
    
    /**
     * Update the status summary card
     */
    function updateStatusSummary() {
        if (attendanceStatusBadge) {
            switch (attendanceState) {
                case 'loading':
                    attendanceStatusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800';
                    attendanceStatusBadge.textContent = 'Memuat...';
                    break;
                case 'not_checked_in':
                    attendanceStatusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800';
                    attendanceStatusBadge.textContent = 'Belum Absen';
                    break;
                case 'checked_in':
                    attendanceStatusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800';
                    attendanceStatusBadge.textContent = 'Sudah Check In';
                    break;
                case 'checked_out':
                    attendanceStatusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800';
                    attendanceStatusBadge.textContent = 'Absensi Selesai';
                    break;
            }
        }
    }
    
    /**
     * Get the user's geolocation
     */
    function getGeolocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                // Success callback
                function(position) {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;
                    console.log('Geolocation:', latitude, longitude);
                },
                // Error callback
                function(error) {
                    console.error('Geolocation error:', error);
                    
                    // Show error message
                    alert('Tidak dapat mengakses lokasi Anda. Pastikan Anda telah memberikan izin lokasi untuk website ini.');
                }
            );
        } else {
            console.error('Geolocation is not supported by this browser');
            
            // Show error message
            alert('Browser Anda tidak mendukung geolokasi. Silakan gunakan browser yang lebih baru.');
        }
    }
    
    /**
     * Add event listeners to elements
     */
    function addEventListeners() {
        // Scan Attendance Button
        if (scanAttendanceBtn) {
            scanAttendanceBtn.addEventListener('click', handleScanAttendance);
        }
        
        // Time In Modal
        if (timeInCancel) {
            timeInCancel.addEventListener('click', closeTimeInModal);
        }
        
        if (timeInForm) {
            timeInForm.addEventListener('submit', handleTimeIn);
        }
        
        // Camera Controls for Time In
        if (startCameraBtn) {
            startCameraBtn.addEventListener('click', startCamera);
        }
        
        if (takeSelfieBtn) {
            takeSelfieBtn.addEventListener('click', takeSelfie);
        }
        
        if (retakeSelfieBtn) {
            retakeSelfieBtn.addEventListener('click', retakeSelfie);
        }
        
        // Time Out Modal
        if (timeOutCancel) {
            timeOutCancel.addEventListener('click', closeTimeOutModal);
        }
        
        if (timeOutForm) {
            timeOutForm.addEventListener('submit', handleTimeOut);
        }
        
        // Camera Controls for Time Out
        if (startCameraOutBtn) {
            startCameraOutBtn.addEventListener('click', startCameraOut);
        }
        
        if (takeSelfieOutBtn) {
            takeSelfieOutBtn.addEventListener('click', takeSelfieOut);
        }
        
        if (retakeSelfieOutBtn) {
            retakeSelfieOutBtn.addEventListener('click', retakeSelfieOut);
        }
    }
    
    /**
     * Handle scan attendance button click
     */
    function handleScanAttendance() {
        // If in admin view mode, show an alert
        if (isAdminView) {
            alert('Fitur ini tidak tersedia dalam mode demo admin. Silakan login sebagai karyawan untuk menggunakan fitur absensi.');
            return;
        }
        
        // Open the appropriate modal based on attendance state
        if (attendanceState === 'not_checked_in') {
            openTimeInModal();
        } else if (attendanceState === 'checked_in') {
            openTimeOutModal();
        } else if (attendanceState === 'checked_out') {
            alert('Anda sudah melakukan absensi masuk dan pulang hari ini.');
        } else {
            alert('Sedang memuat status absensi. Silakan coba lagi dalam beberapa saat.');
        }
    }
    
    /**
     * Open the time in modal
     */
    function openTimeInModal() {
        // If in admin view mode, show an alert instead of opening the modal
        if (isAdminView) {
            alert('Fitur ini tidak tersedia dalam mode demo admin. Silakan login sebagai karyawan untuk menggunakan fitur check-in.');
            return;
        }
        
        timeInModal.classList.remove('hidden');
    }
    
    /**
     * Close the time in modal
     */
    function closeTimeInModal() {
        timeInModal.classList.add('hidden');
        stopCamera();
    }
    
    /**
     * Open the time out modal
     */
    function openTimeOutModal() {
        // If in admin view mode, show an alert instead of opening the modal
        if (isAdminView) {
            alert('Fitur ini tidak tersedia dalam mode demo admin. Silakan login sebagai karyawan untuk menggunakan fitur check-out.');
            return;
        }
        
        timeOutModal.classList.remove('hidden');
    }
    
    /**
     * Close the time out modal
     */
    function closeTimeOutModal() {
        timeOutModal.classList.add('hidden');
        stopCameraOut();
    }
    
    /**
     * Start the camera for time in
     */
    function startCamera() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(mediaStream) {
                    stream = mediaStream;
                    cameraPreview.srcObject = mediaStream;
                    cameraPreview.play();
                    
                    // Show camera preview and take selfie button
                    cameraPreview.classList.remove('hidden');
                    cameraPlaceholder.classList.add('hidden');
                    takeSelfieBtn.classList.remove('hidden');
                    startCameraBtn.classList.add('hidden');
                })
                .catch(function(error) {
                    console.error('Error accessing camera:', error);
                    alert('Tidak dapat mengakses kamera. Pastikan Anda telah memberikan izin kamera untuk website ini.');
                });
        } else {
            alert('Browser Anda tidak mendukung akses kamera. Silakan gunakan browser yang lebih baru.');
        }
    }
    
    /**
     * Stop the camera for time in
     */
    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
    }
    
    /**
     * Take a selfie for time in
     */
    function takeSelfie() {
        if (cameraPreview && selfieCanvas) {
            // Set canvas dimensions to match video
            selfieCanvas.width = cameraPreview.videoWidth;
            selfieCanvas.height = cameraPreview.videoHeight;
            
            // Draw video frame to canvas
            const context = selfieCanvas.getContext('2d');
            context.drawImage(cameraPreview, 0, 0, selfieCanvas.width, selfieCanvas.height);
            
            // Convert canvas to blob
            selfieCanvas.toBlob(function(blob) {
                selfieBlob = blob;
                
                // Display the captured image
                const imageUrl = URL.createObjectURL(blob);
                selfiePreview.src = imageUrl;
                selfiePreview.classList.remove('hidden');
                cameraPreview.classList.add('hidden');
                
                // Show retake button and hide take button
                retakeSelfieBtn.classList.remove('hidden');
                takeSelfieBtn.classList.add('hidden');
            }, 'image/jpeg', 0.8);
        }
    }
    
    /**
     * Retake a selfie for time in
     */
    function retakeSelfie() {
        // Hide preview and show camera
        selfiePreview.classList.add('hidden');
        cameraPreview.classList.remove('hidden');
        
        // Show take button and hide retake button
        takeSelfieBtn.classList.remove('hidden');
        retakeSelfieBtn.classList.add('hidden');
        
        // Clear the blob
        selfieBlob = null;
    }
    
    /**
     * Start the camera for time out
     */
    function startCameraOut() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(mediaStream) {
                    streamOut = mediaStream;
                    cameraOutPreview.srcObject = mediaStream;
                    cameraOutPreview.play();
                    
                    // Show camera preview and take selfie button
                    cameraOutPreview.classList.remove('hidden');
                    cameraOutPlaceholder.classList.add('hidden');
                    takeSelfieOutBtn.classList.remove('hidden');
                    startCameraOutBtn.classList.add('hidden');
                })
                .catch(function(error) {
                    console.error('Error accessing camera:', error);
                    alert('Tidak dapat mengakses kamera. Pastikan Anda telah memberikan izin kamera untuk website ini.');
                });
        } else {
            alert('Browser Anda tidak mendukung akses kamera. Silakan gunakan browser yang lebih baru.');
        }
    }
    
    /**
     * Stop the camera for time out
     */
    function stopCameraOut() {
        if (streamOut) {
            streamOut.getTracks().forEach(track => track.stop());
            streamOut = null;
        }
    }
    
    /**
     * Take a selfie for time out
     */
    function takeSelfieOut() {
        if (cameraOutPreview && selfieOutCanvas) {
            // Set canvas dimensions to match video
            selfieOutCanvas.width = cameraOutPreview.videoWidth;
            selfieOutCanvas.height = cameraOutPreview.videoHeight;
            
            // Draw video frame to canvas
            const context = selfieOutCanvas.getContext('2d');
            context.drawImage(cameraOutPreview, 0, 0, selfieOutCanvas.width, selfieOutCanvas.height);
            
            // Convert canvas to blob
            selfieOutCanvas.toBlob(function(blob) {
                selfieOutBlob = blob;
                
                // Display the captured image
                const imageUrl = URL.createObjectURL(blob);
                selfieOutPreview.src = imageUrl;
                selfieOutPreview.classList.remove('hidden');
                cameraOutPreview.classList.add('hidden');
                
                // Show retake button and hide take button
                retakeSelfieOutBtn.classList.remove('hidden');
                takeSelfieOutBtn.classList.add('hidden');
            }, 'image/jpeg', 0.8);
        }
    }
    
    /**
     * Retake a selfie for time out
     */
    function retakeSelfieOut() {
        // Hide preview and show camera
        selfieOutPreview.classList.add('hidden');
        cameraOutPreview.classList.remove('hidden');
        
        // Show take button and hide retake button
        takeSelfieOutBtn.classList.remove('hidden');
        retakeSelfieOutBtn.classList.add('hidden');
        
        // Clear the blob
        selfieOutBlob = null;
    }
    
    /**
     * Handle time in form submission
     */
    function handleTimeIn(event) {
        event.preventDefault();
        
        // Create form data
        const formData = new FormData();
        formData.append('attendance_method', timeInMethod.value);
        formData.append('work_location', timeInLocation.value);
        formData.append('notes', timeInNotes.value);
        
        // Add geolocation if available
        if (latitude !== null && longitude !== null) {
            formData.append('latitude', latitude);
            formData.append('longitude', longitude);
        }
        
        // Add selfie if available
        if (selfieBlob) {
            formData.append('selfie_image', selfieBlob, 'selfie.jpg');
        }
        
        // Disable submit button and show loading state
        timeInSubmit.disabled = true;
        timeInSubmit.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
        
        // Send request to server
        fetch('/api/attendance/time-in', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                closeTimeInModal();
                
                // Show success message
                alert(data.message);
                
                // Refresh attendance status
                checkAttendanceStatus();
            } else {
                // Show error message
                alert('Error: ' + data.message);
                
                // Re-enable submit button
                timeInSubmit.disabled = false;
                timeInSubmit.innerHTML = 'Check In';
            }
        })
        .catch(error => {
            console.error('Error submitting time in:', error);
            
            // Show error message
            alert('Terjadi kesalahan saat mengirim data absensi. Silakan coba lagi.');
            
            // Re-enable submit button
            timeInSubmit.disabled = false;
            timeInSubmit.innerHTML = 'Check In';
        });
    }
    
    /**
     * Handle time out form submission
     */
    function handleTimeOut(event) {
        event.preventDefault();
        
        // Create form data
        const formData = new FormData();
        formData.append('notes', timeOutNotes.value);
        
        // Add selfie if available
        if (selfieOutBlob) {
            formData.append('selfie_image', selfieOutBlob, 'selfie_out.jpg');
        }
        
        // Disable submit button and show loading state
        timeOutSubmit.disabled = true;
        timeOutSubmit.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
        
        // Send request to server
        fetch('/api/attendance/time-out', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                closeTimeOutModal();
                
                // Show success message
                alert(data.message);
                
                // Refresh attendance status
                checkAttendanceStatus();
            } else {
                // Show error message
                alert('Error: ' + data.message);
                
                // Re-enable submit button
                timeOutSubmit.disabled = false;
                timeOutSubmit.innerHTML = 'Check Out';
            }
        })
        .catch(error => {
            console.error('Error submitting time out:', error);
            
            // Show error message
            alert('Terjadi kesalahan saat mengirim data absensi. Silakan coba lagi.');
            
            // Re-enable submit button
            timeOutSubmit.disabled = false;
            timeOutSubmit.innerHTML = 'Check Out';
        });
    }
});

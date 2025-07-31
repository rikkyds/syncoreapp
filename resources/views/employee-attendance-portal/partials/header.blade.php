<!-- Properly Sized Header Design -->
<div class="w-full h-96 relative overflow-hidden" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #3730a3 100%);">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-6 right-6 w-48 h-48 rounded-full" style="background-color: rgba(255,255,255,0.1); filter: blur(50px);"></div>
        <div class="absolute bottom-6 left-6 w-56 h-56 rounded-full" style="background-color: rgba(168,85,247,0.2); filter: blur(60px);"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-52 h-52 rounded-full" style="background-color: rgba(34,211,238,0.15); filter: blur(55px);"></div>
    </div>
    
    <!-- Header Content -->
    <div class="relative z-10 flex items-center justify-center h-full">
        <div class="w-full max-w-md mx-auto px-8">
            <div class="flex items-center justify-between">
                <!-- Employee Info -->
                <div class="flex items-center">
                    <div class="mr-6">
                        @if($employee->profile_photo)
                            <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="{{ $employee->full_name }}" class="w-36 h-36 rounded-3xl object-cover border-4 border-white shadow-2xl">
                        @else
                            <div class="w-36 h-36 rounded-3xl bg-transparent flex items-center justify-center shadow-2xl border-4 border-white" style="background-color: rgba(255,255,255,0.1);">
                                <span class="text-6xl font-bold text-white">{{ substr($employee->full_name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="text-blue-200 text-sm font-medium">{{ $employee->position->name ?? 'Staff' }}</p>
                        <h1 class="text-white text-3xl font-bold">{{ $employee->full_name }}</h1>
                        <p class="text-blue-100 text-sm mt-2">Portal Absensi Karyawan</p>
                    </div>
                </div>
                
                <!-- Notification Icon -->
                <div class="relative">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background-color: rgba(255,255,255,0.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                        <span class="text-xs text-white font-bold">3</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

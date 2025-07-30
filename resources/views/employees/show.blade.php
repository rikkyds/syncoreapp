<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold">Employee Information</h3>
                            <div>
                                <a href="{{ route('employees.edit', $employee) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Edit
                                </a>
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Personal Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4">Personal Information</h4>
                            <dl>
                                <div class="mb-2">
                                    <dt class="font-medium">Full Name</dt>
                                    <dd>{{ $employee->full_name }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">NIK</dt>
                                    <dd>{{ $employee->nik }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">KTP Photo</dt>
                                    <dd>
                                        @if($employee->ktp_photo)
                                            <img src="{{ Storage::url($employee->ktp_photo) }}" alt="KTP Photo" class="w-32 mt-2">
                                        @else
                                            No photo uploaded
                                        @endif
                                    </dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Birth Place & Date</dt>
                                    <dd>{{ $employee->birth_place }}, {{ $employee->birth_date->format('d M Y') }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Gender</dt>
                                    <dd>{{ ucfirst($employee->gender) }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Marital Status</dt>
                                    <dd>{{ ucfirst($employee->marital_status) }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Address</dt>
                                    <dd>{{ $employee->address }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Phone Number</dt>
                                    <dd>{{ $employee->phone_number }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Personal Email</dt>
                                    <dd>{{ $employee->personal_email }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Insurance & Financial Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4">Insurance & Financial Information</h4>
                            <dl>
                                <div class="mb-2">
                                    <dt class="font-medium">BPJS Health</dt>
                                    <dd>{{ $employee->bpjs_health ?? 'Not provided' }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">BPJS Health Card</dt>
                                    <dd>
                                        @if($employee->bpjs_health_photo)
                                            <img src="{{ Storage::url($employee->bpjs_health_photo) }}" alt="BPJS Health Card" class="w-32 mt-2">
                                        @else
                                            No photo uploaded
                                        @endif
                                    </dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">BPJS Employment</dt>
                                    <dd>{{ $employee->bpjs_employment ?? 'Not provided' }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Bank Account</dt>
                                    <dd>{{ $employee->bank_name ? $employee->bank_name . ' - ' . $employee->bank_account : 'Not provided' }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">NPWP</dt>
                                    <dd>{{ $employee->npwp ?? 'Not provided' }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">NPWP Card</dt>
                                    <dd>
                                        @if($employee->npwp_photo)
                                            <img src="{{ Storage::url($employee->npwp_photo) }}" alt="NPWP Card" class="w-32 mt-2">
                                        @else
                                            No photo uploaded
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Company Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4">Company Information</h4>
                            <dl>
                                <div class="mb-2">
                                    <dt class="font-medium">Employee ID (NIP)</dt>
                                    <dd>{{ $employee->employee_id }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Work Unit</dt>
                                    <dd>{{ $employee->workUnit->name }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Position</dt>
                                    <dd>{{ $employee->position->name }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Employment Status</dt>
                                    <dd>{{ ucfirst($employee->employment_status) }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Join Date</dt>
                                    <dd>{{ $employee->join_date->format('d M Y') }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Company</dt>
                                    <dd>{{ $employee->company->name }}</dd>
                                </div>
                                <div class="mb-2">
                                    <dt class="font-medium">Branch Office</dt>
                                    <dd>{{ $employee->branchOffice->name }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Education Section -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Education History</h3>
                            <a href="{{ route('employees.education.create', $employee) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Education
                            </a>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            @forelse($employee->educations as $education)
                                <div class="mb-4 p-4 border rounded-lg bg-white">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold">{{ $education->educationLevel->name }} - {{ $education->institution_name }}</h4>
                                            @if($education->major)
                                                <p class="text-gray-600">{{ $education->major }}</p>
                                            @endif
                                            <p class="text-gray-600">{{ $education->city }}, {{ $education->country }}</p>
                                            <p class="text-gray-600">
                                                {{ $education->start_year }} - {{ $education->end_year ?? 'Present' }}
                                                ({{ ucfirst($education->status) }})
                                            </p>
                                            @if($education->gpa)
                                                <p class="text-gray-600">GPA: {{ $education->gpa }}</p>
                                            @endif
                                            @if($education->certificate)
                                                <a href="{{ Storage::url($education->certificate) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                    View Certificate
                                                </a>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('employees.education.edit', [$employee, $education]) }}" class="text-yellow-600 hover:text-yellow-900">
                                                Edit
                                            </a>
                                            <form action="{{ route('employees.education.destroy', [$employee, $education]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600">No education records found.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Skills Section -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Skills & Competencies</h3>
                            <a href="{{ route('employees.skills.create', $employee) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Skill
                            </a>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            @forelse($employee->skills->groupBy('skillCategory.name') as $category => $skills)
                                <div class="mb-6">
                                    <h4 class="font-semibold mb-3">{{ $category }}</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($skills as $skill)
                                            <div class="bg-white p-4 rounded-lg border">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h5 class="font-semibold">{{ $skill->name }}</h5>
                                                        <p class="text-sm text-gray-600">
                                                            Level: {{ ucfirst($skill->proficiency_level) }}
                                                        </p>
                                                        <p class="text-sm text-gray-600">
                                                            Experience: {{ $skill->years_of_experience }} years
                                                        </p>
                                                        @if($skill->description)
                                                            <p class="text-sm text-gray-600 mt-2">{{ $skill->description }}</p>
                                                        @endif
                                                        @if($skill->certification)
                                                            <div class="mt-2">
                                                                <a href="{{ Storage::url($skill->certification) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm">
                                                                    View Certification
                                                                </a>
                                                            </div>
                                                            @if($skill->certification_date)
                                                                <p class="text-xs text-gray-500 mt-1">
                                                                    Certified: {{ $skill->certification_date->format('M Y') }}
                                                                    @if($skill->certification_expiry)
                                                                        - Expires: {{ $skill->certification_expiry->format('M Y') }}
                                                                    @endif
                                                                </p>
                                                            @endif
                                                            @if($skill->issuing_organization)
                                                                <p class="text-xs text-gray-500">
                                                                    By: {{ $skill->issuing_organization }}
                                                                </p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('employees.skills.edit', [$employee, $skill]) }}" class="text-yellow-600 hover:text-yellow-900">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('employees.skills.destroy', [$employee, $skill]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600">No skills recorded.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Work Experience Section -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Work Experience</h3>
                            <a href="{{ route('employees.work-experiences.create', $employee) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Work Experience
                            </a>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            @forelse($employee->workExperiences as $experience)
                                <div class="mb-4 p-4 border rounded-lg bg-white">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex justify-between">
                                                <div>
                                                    <h4 class="font-semibold">{{ $experience->company_name }}</h4>
                                                    <p class="text-gray-600">{{ $experience->position }}</p>
                                                </div>
                                                <div class="text-sm text-gray-500 text-right">
                                                    {{ $experience->start_date->format('M Y') }} - 
                                                    {{ $experience->is_current ? 'Present' : ($experience->end_date ? $experience->end_date->format('M Y') : '') }}
                                                    @if($experience->is_current)
                                                        <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Current</span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ ucwords(str_replace('_', ' ', $experience->employment_status)) }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $experience->industry }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $experience->location }}
                                                    @if($experience->is_remote)
                                                        (Remote)
                                                    @endif
                                                </span>
                                            </div>

                                            @if($experience->main_responsibilities)
                                                <div class="mt-3">
                                                    <h5 class="text-sm font-medium text-gray-700">Main Responsibilities:</h5>
                                                    <p class="mt-1 text-sm text-gray-600 whitespace-pre-line">{{ $experience->main_responsibilities }}</p>
                                                </div>
                                            @endif

                                            @if($experience->leaving_reason)
                                                <div class="mt-2">
                                                    <h5 class="text-sm font-medium text-gray-700">Reason for Leaving:</h5>
                                                    <p class="text-sm text-gray-600">{{ $experience->leaving_reason }}</p>
                                                </div>
                                            @endif

                                            @if($experience->reference_name)
                                                <div class="mt-3 text-sm">
                                                    <h5 class="font-medium text-gray-700">Reference:</h5>
                                                    <p class="text-gray-600">
                                                        {{ $experience->reference_name }}
                                                        @if($experience->reference_position)
                                                            ({{ $experience->reference_position }})
                                                        @endif
                                                    </p>
                                                    @if($experience->reference_contact || $experience->reference_email)
                                                        <p class="text-gray-600">
                                                            @if($experience->reference_contact)
                                                                {{ $experience->reference_contact }}
                                                            @endif
                                                            @if($experience->reference_email)
                                                                {{ $experience->reference_contact ? ' | ' : '' }}
                                                                {{ $experience->reference_email }}
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex space-x-2">
                                            <a href="{{ route('employees.work-experiences.edit', [$employee, $experience]) }}" class="text-yellow-600 hover:text-yellow-900">
                                                Edit
                                            </a>
                                            <form action="{{ route('employees.work-experiences.destroy', [$employee, $experience]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600">No work experience records found.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('employees.index') }}" class="text-blue-600 hover:text-blue-900">
                            Back to Employee List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

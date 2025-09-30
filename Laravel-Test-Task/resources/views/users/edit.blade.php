@extends('layouts.app')

@section('title', 'Edit User - ' . $user->full_name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit User: {{ $user->full_name }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Current Profile Picture -->
                    @if($user->profile_picture)
                        <div class="text-center mb-4">
                            <p class="mb-2"><strong>Current Profile Picture:</strong></p>
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                 alt="Current Profile" 
                                 class="profile-img-large">
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" 
                                       name="full_name" 
                                       value="{{ old('full_name', $user->full_name) }}" 
                                       required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave blank to keep current password. Minimum 8 characters if changing.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation">
                                <div class="form-text">Required only if changing password</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select country-code-select @error('phone') is-invalid @enderror" 
                                            id="country_code" 
                                            name="country_code" 
                                            style="max-width: 120px;"
                                            required>
                                        <option value="">Select Country</option>
                                    </select>
                                    <input type="text" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone_number" 
                                           name="phone_number" 
                                           value="{{ old('phone_number') }}" 
                                           placeholder="Phone number"
                                           required>
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Country code + phone number (Required)</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" 
                                       class="form-control @error('profile_picture') is-invalid @enderror" 
                                       id="profile_picture" 
                                       name="profile_picture" 
                                       accept=".jpg,.jpeg,.png">
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">JPG, JPEG, PNG only. Max size: 2MB. Leave blank to keep current picture.</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Back to Details
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-lg me-1"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let countries = [];
    let currentPhone = '{{ $user->phone }}';

    // Fetch countries from REST Countries API
    async function loadCountries() {
        try {
            const response = await fetch('https://restcountries.com/v3.1/all?fields=name,cca2,flags,idd');
            countries = await response.json();
            
            // Sort countries by name
            countries.sort((a, b) => a.name.common.localeCompare(b.name.common));
            
            // Populate the select dropdown
            const select = $('#country_code');
            select.empty().append('<option value="">Select Country</option>');
            
            let selectedCountryCode = '';
            let phoneNumber = '';
            
            countries.forEach(country => {
                if (country.idd && country.idd.root) {
                    const countryCode = country.idd.root + (country.idd.suffixes ? country.idd.suffixes[0] || '' : '');
                    const option = new Option(
                        `${country.name.common} (${countryCode})`,
                        countryCode,
                        false,
                        false
                    );
                    select.append(option);
                    
                    // Check if current phone starts with this country code
                    if (currentPhone && currentPhone.startsWith(countryCode)) {
                        selectedCountryCode = countryCode;
                        phoneNumber = currentPhone.substring(countryCode.length);
                    }
                }
            });
            
            // Set the selected values
            if (selectedCountryCode) {
                select.val(selectedCountryCode);
                $('#phone_number').val(phoneNumber);
            }
            
            // Initialize Select2
            select.select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Country',
                allowClear: true,
                width: '100%'
            });
            
        } catch (error) {
            console.error('Error loading countries:', error);
        }
    }

    // Load countries when page loads
    $(document).ready(function() {
        loadCountries();
    });

    // Preview new profile picture
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // You can add image preview functionality here if needed
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
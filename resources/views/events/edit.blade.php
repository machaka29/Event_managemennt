@extends('layouts.organizer')

@section('title', 'Edit Event - EmCa Techonologies')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem;">
        <h1 style="margin-top: 1rem;">Edit Event: {{ $event->title }}</h1>
    </div>

    <div class="card" style="max-width: 850px; margin: 0 auto; border-top: 5px solid var(--corporate-red); padding: 40px;">
        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 30px;">
                <label for="title" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Event Title</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $event->title) }}" placeholder="e.g. Annual Tech Summit"
                    style="width: 100%; padding: 16px 20px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'">
                @error('title') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>


            <div style="margin-bottom: 35px;">
                <label for="description" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Detailed Description</label>
                <textarea name="description" id="description" rows="6" required placeholder="What is this event about?"
                    style="width: 100%; padding: 16px 20px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b; resize: vertical; line-height: 1.6;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'">{{ old('description', $event->description) }}</textarea>
                @error('description') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div class="responsive-grid" style="margin-bottom: 35px; gap: 20px;">
                <div>
                    <label for="date" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Event Date</label>
                    <input type="date" name="date" id="date" required value="{{ old('date', $event->date) }}"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('date') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="time" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Start Time</label>
                    <input type="time" name="time" id="time" required value="{{ old('time', \Carbon\Carbon::parse($event->time)->format('H:i')) }}"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('time') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="responsive-grid" style="margin-bottom: 35px; gap: 20px;">
                <div>
                    <label for="location" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">City / Region</label>
                    <input type="text" name="location" id="location" required value="{{ old('location', $event->location) }}" placeholder="Search Venue..." list="tanzania-locations"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    <datalist id="tanzania-locations">
                        <option value="Arusha"><option value="Dar es Salaam"><option value="Dodoma"><option value="Geita"><option value="Iringa"><option value="Kagera"><option value="Katavi"><option value="Kigoma"><option value="Kilimanjaro"><option value="Lindi"><option value="Manyara"><option value="Mara"><option value="Mbeya"><option value="Morogoro"><option value="Mtwara"><option value="Mwanza"><option value="Njombe"><option value="Pemba North"><option value="Pemba South"><option value="Pwani"><option value="Rukwa"><option value="Ruvuma"><option value="Shinyanga"><option value="Simiyu"><option value="Singida"><option value="Songwe"><option value="Tabora"><option value="Tanga"><option value="Zanzibar North"><option value="Zanzibar South and Central"><option value="Zanzibar West"><option value="Moshi"><option value="Kahama"><option value="Songea"><option value="Musoma"><option value="Korogwe"><option value="Kibaha"><option value="Bariadi"><option value="Mpanda">
                    </datalist>
                    @error('location') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="venue" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Venue Name</label>
                    <input type="text" name="venue" id="venue" value="{{ old('venue', $event->venue) }}" placeholder="e.g. Diamond Jubilee Hall"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('venue') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="responsive-grid" style="margin-bottom: 35px; gap: 20px;">
                <div>
                    <label for="capacity" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Attendee Capacity</label>
                    <input type="number" name="capacity" id="capacity" required value="{{ old('capacity', $event->capacity) }}" min="1" placeholder="e.g. 500"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('capacity') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="target_audience" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Target Audience</label>
                    <input type="text" name="target_audience" id="target_audience" value="{{ old('target_audience', $event->target_audience) }}" placeholder="e.g. Professionals, Students"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('target_audience') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="responsive-grid" style="margin-bottom: 40px; gap: 20px;">
                <div>
                    <label for="reg_start_date" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Registrations Open</label>
                    <input type="date" name="reg_start_date" id="reg_start_date" required value="{{ old('reg_start_date', $event->reg_start_date) }}"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('reg_start_date') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="reg_end_date" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Registrations Close</label>
                    <input type="date" name="reg_end_date" id="reg_end_date" required value="{{ old('reg_end_date', $event->reg_end_date) }}"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('reg_end_date') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div style="margin-bottom: 35px;">
                <label style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Event Banner / Image (Optional)</label>
                
                @if($event->image_path)
                    <div style="margin-bottom: 15px; border-radius: 12px; overflow: hidden; width: fit-content; border: 1px solid #e2e8f0;">
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="Event Image" style="max-height: 150px; display: block;">
                        <div style="padding: 8px 15px; background: #f8fafc; font-size: 0.75rem; color: #64748b; font-weight: 600; text-align: center;">Current Image</div>
                    </div>
                @endif
                
                <div style="position: relative; width: 100%; padding: 25px 20px; border: 2px dashed #cbd5e1; border-radius: 12px; background: #f8fafc; text-align: center; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.backgroundColor='#FFF5F5';" onmouseout="this.style.borderColor='#cbd5e1'; this.style.backgroundColor='#f8fafc';">
                    <input type="file" name="image" id="image" accept="image/*" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;" onchange="document.getElementById('file-name-edit').textContent = this.files[0] ? this.files[0].name : 'Browse new image or drag and drop';">
                    <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2.5rem; color: var(--corporate-red); margin-bottom: 15px; opacity: 0.7;"></i>
                    <p style="margin: 0; color: #1e293b; font-weight: 800; font-size: 1rem;">{{ $event->image_path ? 'Change Event Image' : 'Upload Event Image' }}</p>
                    <p id="file-name-edit" style="margin: 5px 0 0; color: #64748b; font-size: 0.85rem; font-weight: 500;">Browse new files (JPG, PNG) or drag and drop</p>
                </div>
                @error('image') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 45px; background: #fff5f5; padding: 25px; border-radius: 12px; border: 1px solid #f9dcdc;">
                <label for="gate_password" style="display: block; font-weight: 800; margin-bottom: 10px; color: var(--corporate-red); text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Gate Security Password</label>
                <div class="password-container" style="position: relative;">
                    <input type="password" name="gate_password" id="gate_password" required value="{{ old('gate_password', $event->gate_password) }}" placeholder="Assign a password for gate security"
                        style="width: 100%; padding: 16px 20px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: white; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 4px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    <button type="button" class="togglePassword" onclick="toggleGatePassword()" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748b;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <p style="margin-top: 10px; font-size: 0.8rem; color: #64748b; font-weight: 600;">
                    <i class="fa-solid fa-shield-halved" style="color: var(--corporate-red); margin-right: 5px;"></i> 
                    Walinzi mlangoni watatumia nenosiri hili (PIN) ili kuruhusu Check-In/Out.
                </p>
                @error('gate_password') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <script>
                function toggleGatePassword() {
                    const passInput = document.getElementById('gate_password');
                    const toggleBtn = document.querySelector('.togglePassword i');
                    if (passInput.type === 'password') {
                        passInput.type = 'text';
                        toggleBtn.classList.replace('fa-eye', 'fa-eye-slash');
                    } else {
                        passInput.type = 'password';
                        toggleBtn.classList.replace('fa-eye-slash', 'fa-eye');
                    }
                }
            </script>

            <div style="border-top: 1px solid #f1f5f9; padding-top: 35px; display: flex; justify-content: flex-end; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('dashboard') }}" class="btn btn-outline" style="min-width: 160px; text-align: center;">CANCEL</a>
                <button type="submit" class="btn btn-primary" style="min-width: 220px; gap: 12px; font-size: 1rem; box-shadow: 0 10px 15px -3px rgba(148,0,0,0.3);">
                    <i class="fa-solid fa-save"></i> UPDATE EVENT
                </button>
            </div>
        </form>
    </div>

    <div style="margin-top: 3rem;">
        <a href="javascript:history.back()" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back
        </a>
    </div>
</div>
@endsection

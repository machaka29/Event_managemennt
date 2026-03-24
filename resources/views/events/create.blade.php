@extends('layouts.organizer')

@section('title', 'Create Event - EventPro')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem;">
        <h1 style="margin-top: 1rem;">Create New Event</h1>
    </div>

    <div class="card" style="max-width: 850px; margin: 0 auto; border-top: 5px solid var(--corporate-red); padding: 40px;">
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 30px;">
                <label for="title" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Event Title</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="e.g. Annual Tech Summit"
                    style="width: 100%; padding: 16px 20px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'">
                @error('title') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 35px;">
                <label for="description" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Detailed Description</label>
                <textarea name="description" id="description" rows="6" required placeholder="What is this event about? Include schedule, speakers, etc."
                    style="width: 100%; padding: 16px 20px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b; resize: vertical; line-height: 1.6;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'">{{ old('description') }}</textarea>
                @error('description') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div class="responsive-grid" style="margin-bottom: 35px; gap: 20px;">
                <div>
                    <label for="date" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Event Date</label>
                    <input type="date" name="date" id="date" required value="{{ old('date') }}"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('date') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="time" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Start Time</label>
                    <input type="time" name="time" id="time" required value="{{ old('time') }}"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('time') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="responsive-grid" style="margin-bottom: 35px; gap: 20px;">
                <div>
                    <label for="location" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Venue Location</label>
                    <input type="text" name="location" id="location" required value="{{ old('location') }}" placeholder="Search or Type Venue..." list="tanzania-locations"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    <datalist id="tanzania-locations">
                        <option value="Arusha"><option value="Dar es Salaam"><option value="Dodoma"><option value="Geita"><option value="Iringa"><option value="Kagera"><option value="Katavi"><option value="Kigoma"><option value="Kilimanjaro"><option value="Lindi"><option value="Manyara"><option value="Mara"><option value="Mbeya"><option value="Morogoro"><option value="Mtwara"><option value="Mwanza"><option value="Njombe"><option value="Pemba North"><option value="Pemba South"><option value="Pwani"><option value="Rukwa"><option value="Ruvuma"><option value="Shinyanga"><option value="Simiyu"><option value="Singida"><option value="Songwe"><option value="Tabora"><option value="Tanga"><option value="Zanzibar North"><option value="Zanzibar South and Central"><option value="Zanzibar West"><option value="Moshi"><option value="Kahama"><option value="Songea"><option value="Musoma"><option value="Korogwe"><option value="Kibaha"><option value="Bariadi"><option value="Mpanda">
                    </datalist>
                    @error('location') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="capacity" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Attendee Capacity</label>
                    <input type="number" name="capacity" id="capacity" required value="{{ old('capacity') }}" min="1" placeholder="e.g. 500"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('capacity') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="responsive-grid" style="margin-bottom: 40px; gap: 20px;">
                <div>
                    <label for="reg_start_date" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Registrations Open</label>
                    <input type="date" name="reg_start_date" id="reg_start_date" required value="{{ old('reg_start_date') }}"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('reg_start_date') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="reg_end_date" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Registrations Close</label>
                    <input type="date" name="reg_end_date" id="reg_end_date" required value="{{ old('reg_end_date') }}"
                        style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    @error('reg_end_date') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div style="margin-bottom: 45px;">
                <label for="image" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">Event Cover Photo</label>
                <div style="border: 2px dashed #cbd5e1; border-radius: 15px; padding: 40px 20px; text-align: center; transition: all 0.2s; background: #f8fafc; cursor: pointer;" 
                     onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.background='white'" 
                     onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc'">
                    <i class="fa-solid fa-image" style="font-size: 3rem; color: #94a3b8; margin-bottom: 20px; display: block;"></i>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 15px; font-weight: 600;">Drop your event banner here or click to browse</p>
                    <input type="file" name="image" id="image" style="max-width: 100%; font-size: 0.85rem; color: #64748b;">
                </div>
                @error('image') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 8px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div style="border-top: 1px solid #f1f5f9; padding-top: 35px; display: flex; justify-content: flex-end; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('dashboard') }}" class="btn btn-outline" style="min-width: 160px; text-align: center;">DISCARD CHANGES</a>
                <button type="submit" class="btn btn-primary" style="min-width: 220px; gap: 12px; font-size: 1rem; box-shadow: 0 10px 15px -3px rgba(148,0,0,0.3);">
                    <i class="fa-solid fa-rocket"></i> PUBLISH EVENT
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

@extends('layouts.app')

@section('content')
<!-- Page Content -->
<div class="content">

 <!-- Media -->

                    <!-- END Media -->

                    <!-- Info -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Patient Details</h3>
                        </div>
                        <div class="block-content">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-8">
                                    <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control form-control-alt" name="name" id="name" placeholder="Patient name" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Contact Number</label>
                                            <input type="text" class="form-control form-control-alt" name="phone" id="phone" placeholder="Patient phone number" value="{{ old('phone') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Contact Address</label>
                                            <textarea class="form-control form-control-alt" id="address" name="address" rows="4" placeholder="Full address" required>{{ old('address') }}</textarea>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="gender">Gender</label>
                                                <select class="form-control form-control-alt" id="gender" name="gender" style="width: 100%;" required>
                                                    <option value="" selected disabled>Select...</option>
                                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="date-of-birth">Date of Birth</label>
                                                <input type="date" class="form-control form-control-alt" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="blood-group">Blood group</label>
                                                <select class="form-control form-control-alt" id="blood-group" name="blood_group" style="width: 100%;">
                                                    <option value="" selected disabled>Select...</option>
                                                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="genotype">Genotype</label>
                                                <select class="form-control form-control-alt" id="genotype" name="genotype" style="width: 100%;">
                                                    <option value="" selected disabled>Select...</option>
                                                    <option value="AA" {{ old('genotype') == 'AA' ? 'selected' : '' }}>AA</option>
                                                    <option value="AS" {{ old('genotype') == 'AS' ? 'selected' : '' }}>AS</option>
                                                    <option value="SS" {{ old('genotype') == 'SS' ? 'selected' : '' }}>SS</option>
                                                    <option value="AC" {{ old('genotype') == 'AC' ? 'selected' : '' }}>AC</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="marital-status">Marital Status</label>
                                                <select class="form-control form-control-alt" id="marital-status" name="marital_status" style="width: 100%;">
                                                    <option value="" selected disabled>Select...</option>
                                                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                                                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                                                    <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                                    <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="emergency-contact">Emergency Contact</label>
                                                <input type="text" class="form-control form-control-alt" name="emergency_contact" id="emergency-contact" placeholder="Emergency phone number" value="{{ old('emergency_contact') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="allergies">Allergies</label>
                                                <input type="text" class="form-control form-control-alt" name="allergies" id="allergies" placeholder="Any known allergies" value="{{ old('allergies') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="conditions">Existing Conditions</label>
                                                <input type="text" class="form-control form-control-alt" name="conditions" id="conditions" placeholder="Diabetes, Hypertension, etc." value="{{ old('conditions') }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="ward">Ward</label>
                                                <select class="form-control form-control-alt" id="ward" name="ward_id" style="width: 100%;">
                                                    <option value="" selected disabled>Select...</option>
                                                    <option value="1" {{ old('ward_id') == '1' ? 'selected' : '' }}>General Ward</option>
                                                    <option value="2" {{ old('ward_id') == '2' ? 'selected' : '' }}>ICU</option>
                                                    <option value="3" {{ old('ward_id') == '3' ? 'selected' : '' }}>Emergency</option>
                                                    <option value="4" {{ old('ward_id') == '4' ? 'selected' : '' }}>Pediatric</option>
                                                    <option value="5" {{ old('ward_id') == '5' ? 'selected' : '' }}>Maternity</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Admitted?</label>
                                            <div class="custom-control custom-switch mb-1">
                                                <input type="checkbox" class="custom-control-input" id="admitted" name="admitted" {{ old('admitted') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="admitted"></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Upload Image</label>
                                                <input type="file" class="form-control  form-control-alt" id="photo" name="photo" accept="image/*">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Save</button>
                                            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Info -->

                   
                </div>
                <!-- END Page Content -->
@endsection
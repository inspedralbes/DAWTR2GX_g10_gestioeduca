
@extends('layouts.app')


@section('content')
<div class="container">
    <h1>Create New User</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
        </div>


        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>


        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>


        <div class="form-group">
            <label for="image">Image URL:</label>
            <input type="url" class="form-control" id="image" name="image" value="{{ old('image') }}">
        </div>


        <div class="form-group">
            <label for="role">Role:</label>
            <select name="role_id" id="role" class="form-control" required>
                <option value="">Select a role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>


        <!-- Subject Assignment (Only for Teachers) -->
        <div class="form-group" id="subject-group" style="display: none;">
            <label for="subject">Subject:</label>
            <select name="subject_id" id="subject" class="form-control">
                <option value="">Select a subject</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>


        <!-- Course and Division Assignment (Only for Students) -->
        <div id="student-fields" style="display: none;">
            <div class="form-group">
                <label for="course">Course:</label>
                <select name="courses[]" id="course" class="form-control" multiple>
                <option value="">Select a course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>


            <!-- Division Selection for Students -->
            <div class="form-group" id="division-group">
            <label for="divisions">Divisiones</label>
            <select name="divisions[]" id="divisions" class="form-control" multiple>
                @foreach($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->division }}</option>
                @endforeach
            </select>
        </div>
        </div>

        

        <button type="submit" class="btn btn-primary mt-3">Create User</button>
    </form>
    <a href="{{ route('users.index') }}" class="btn btn-primary mt-3">Back to Users List</a>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const subjectGroup = document.getElementById('subject-group');
    const studentFields = document.getElementById('student-fields');
    const divisionGroup = document.getElementById('division-group'); // Asegúrate de que este ID exista en el HTML


    roleSelect.addEventListener('change', function () {
        const selectedRole = parseInt(this.value);


        // Mostrar/ocultar campos en función del rol
        subjectGroup.style.display = 'none';
        studentFields.style.display = 'none';
        divisionGroup.style.display = 'none';  // Añadir esto para ocultar divisiones por defecto


        if (selectedRole === 1) { // Rol de "Profesor"
            subjectGroup.style.display = 'block';
        } else if (selectedRole === 2) { // Rol de "Alumno"
            studentFields.style.display = 'block';
            divisionGroup.style.display = 'block'; // Mostrar divisiones cuando el rol es "Alumno"
        }
        console.log("Rol seleccionado:", selectedRole);
    });
});


</script>
@endsection





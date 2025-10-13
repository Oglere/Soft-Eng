
@extends('layouts.admin')

@section('title', 'EditAccount')

@section('content')


    <div class="dash">
        <form class="Edit-form" name="RegForm" onsubmit="return validateForm()" onreset="resetErrors()">
            <h1>Edit Your Account</h1>
            <p>
                <label for="Username">Username</label>
                <input type="text" id="Uname" name="UsenName" placeholder="Enter your Username" />
                <span id="uname-error" class="error-message"></span>
            </p>
            <p>
                <label for="Fname">Edit First Name</label>
                <input type="text" id="EFname" name="Fname" placeholder="Enter your First Name" />
                <span id="EFname-error" class="error-message"></span>
            </p>
            <p>
                <label for="Lname">Edit Last Name</label>
                <input type="text" id="ELname" name="Lname" placeholder="Enter your Last Name" />
                <span id="ELname-error" class="error-message"></span>
            </p>
            <p>
                <label for="email">E-mail Address</label>
                <input type="text" id="email" name="EMail" placeholder="Enter your email" />
                <span id="email-error" class="error-message"></span>
            </p>
            <p>
                <label for="password">Password</label>
                <input type="password" id="password" name="Password" />
                <span id="password-error" class="error-message"></span>
            </p>
            <p>
                <input type="submit" value="Send" name="Submit" />
            </p>
        </form>
    </div>

@endsection


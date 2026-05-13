<div style="background-color: #f4f4f4; padding: 20px; font-family: sans-serif;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; border-top: 5px solid #4f46e5;">
        <h1 style="color: #4f46e5;">Welcome to Maye Store!</h1>
        
        <p>Hi <strong>{{ $user->name }}</strong>,</p>
        
        <p>Your account has been successfully created with the following details:</p>
        
        <ul style="list-style: none; padding: 0;">
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Role:</strong> {{ $user->role ?? 'Staff' }}</li>
        </ul>

        <p>You can now log in to your dashboard.</p>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="http://127.0.0.1:8000/login" style="display: inline-block; padding: 12px 25px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">Login to your Dashboard</a>
        </div>
    </div>
</div>
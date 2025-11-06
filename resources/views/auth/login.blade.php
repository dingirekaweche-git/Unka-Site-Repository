<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Unka Go Driver Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
            background-color: rgba(0, 0, 0, 0.4);
        }
        
        .login-container {
            display: flex;
            width: 900px;
            height: 550px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .login-left {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-right {
            flex: 1;
            background: linear-gradient(135deg, #1a3c6e, #ff6600);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-right::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1558618666-fcd25856cd63?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
        }
        
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: #ff6600;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }
        
        h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #1a3c6e;
            box-shadow: 0 0 0 2px rgba(26, 60, 110, 0.2);
            outline: none;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .remember {
            display: flex;
            align-items: center;
        }
        
        .remember input {
            margin-right: 8px;
        }
        
        .forgot-password {
            color: #1a3c6e;
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .login-button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #1a3c6e, #ff6600);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 102, 0, 0.4);
        }
        
        .signup-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }
        
        .signup-link a {
            color: #1a3c6e;
            text-decoration: none;
            font-weight: 500;
        }
        
        .signup-link a:hover {
            text-decoration: underline;
        }
        
        .login-right h2 {
            font-size: 32px;
            margin-bottom: 20px;
            position: relative;
        }
        
        .login-right p {
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
            position: relative;
        }
        
        .features {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
            position: relative;
        }
        
        .feature {
            display: flex;
            align-items: center;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.15);
            padding: 12px 15px;
            border-radius: 8px;
            backdrop-filter: blur(5px);
        }
        
        .feature-icon {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .dashboard-preview {
            width: 100%;
            height: 180px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dashboard-preview::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 50%, rgba(255,255,255,0.1) 50%);
            background-size: 10px 10px;
        }
        
        .metric {
            position: absolute;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 12px;
            backdrop-filter: blur(5px);
        }
        
        .metric-1 {
            top: 20px;
            left: 20px;
        }
        
        .metric-2 {
            top: 20px;
            right: 20px;
        }
        
        .metric-3 {
            bottom: 20px;
            left: 20px;
        }
        
        .metric-4 {
            bottom: 20px;
            right: 20px;
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 90%;
                height: auto;
            }
            
            .login-right {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo">
                <div class="logo-icon">U</div>
                <div class="logo-text">Unka Go</div>
            </div>
            
            <h1>Driver Performance Portal</h1>
            <p class="subtitle">Sign in to monitor driver performance metrics</p>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email">
                    <div class="error-message">{{ $errors->first('email') }}</div>
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                    <div class="error-message">{{ $errors->first('password') }}</div>
                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="remember-forgot">
                    <div class="remember">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">Remember me</label>
                    </div>
                    
                    <a class="forgot-password" href="#">
                        Forgot your password?
                    </a>
                </div>
                
                <button type="submit" class="login-button">
                    Log In to Dashboard
                </button>
                
                <div class="signup-link">
                    Need access? <a href="#">Request an account</a>
                </div>
            </form>
        </div>
        
        <div class="login-right">
            <h2>Driver Performance Analytics</h2>
            <p>Monitor, analyze and improve driver performance with real-time metrics</p>
            
            <div class="features">
                <div class="feature">
                    <span class="feature-icon">📊</span>
                    <span>Performance Metrics & KPIs</span>
                </div>
                <div class="feature">
                    <span class="feature-icon">🚦</span>
                    <span>Safety & Compliance Scores</span>
                </div>
                <div class="feature">
                    <span class="feature-icon">⏱️</span>
                    <span>Efficiency & Response Times</span>
                </div>
                <div class="feature">
                    <span class="feature-icon">⭐</span>
                    <span>Customer Satisfaction Ratings</span>
                </div>
            </div>
            
            <div class="dashboard-preview">
                <div class="metric metric-1">Safety Score: 94%</div>
                <div class="metric metric-2">On-time: 96%</div>
                <div class="metric metric-3">Rating: 4.8/5</div>
                <div class="metric metric-4">Trips: 1,247</div>
            </div>
        </div>
    </div>
</body>
</html>
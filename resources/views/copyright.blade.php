<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copyright Notice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #111827;
        }
        h2 {
            font-size: 20px;
            font-weight: 600;
            margin-top: 30px;
            margin-bottom: 10px;
            color: #1f2937;
        }
        p {
            margin-bottom: 15px;
            line-height: 1.6;
            color: #374151;
        }
        a {
            color: #2563eb;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 18px;
            background: #2563eb;
            color: white;
            font-weight: 500;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background: #1e40af;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Copyright Notice</h1>

        <p>© {{ date('Y') }} <strong>Unka Go</strong>. All rights reserved.</p>

        <p>
            All content, designs, text, graphics, logos, and other materials on this website 
            are the intellectual property of <strong>Unka Go</strong> unless otherwise stated.
        </p>

        <h2>Usage</h2>
        <p>
            You may not copy, reproduce, distribute, or create derivative works from any part 
            of this site without prior written consent from us.
        </p>

        <h2>Permissions</h2>
        <p>
            For permission to use any of our content, please contact us at 
            <a href="mailto:info@unka.co.zm">info@unka.co.zm</a>.
        </p>

        <a href="{{ url('/') }}" class="btn-back">← Back to Home</a>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>{{ $siteName }} - Booking Enquiry</title>
</head>
<body>
    <h1>Booking Enquiry Received</h1>
    <p>Dear {{ $post['author_name'] }},</p>

    <p>Thank you for your enquiry regarding {{ ucfirst($postType) }}. We have received the following details:</p>
    
    <h3>Enquiry Details:</h3>
    <ul>
        <li><strong>Enquiry ID:</strong> {{ $post_data['id'] }}</li>
        <li><strong>Name:</strong> {{ $post_data['name'] }}</li>
        <li><strong>Email:</strong> {{ $post_data['email'] }}</li>
        <li><strong>Message:</strong> {{ $post_data['message'] }}</li>
        <!-- Add more fields as necessary -->
    </ul>

    <p>We are currently reviewing your enquiry and will get back to you as soon as possible.</p>

    <p>Thank you for using our application!</p>

    <p>Best regards,</p>
    <p>{{ $siteName }} Team</p>
</body>
</html>
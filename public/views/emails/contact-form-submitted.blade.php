<!DOCTYPE html>
<html>
<head>
    <title>Nouveau message de contact</title>
</head>
<body>
    <h1>Nouveau message de contact</h1>

    <p><strong>De :</strong> {{ $submission->name }}</p>
    <p><strong>Email :</strong> {{ $submission->email }}</p>
    @if($submission->phone)
    <p><strong>Téléphone :</strong> {{ $submission->phone }}</p>
    @endif

    <p><strong>Message :</strong><br>
    {{ $submission->message }}</p>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<img style="width: 300px;" src="{{ asset('../images/logo.png')}}" alt="">
<br>
<br>
<br>
<h2>Bonjour {{ $user->aff_lname }} {{ $user->aff_fname }},</h2>
Votre compte a été activé.
<br>
Vous pouvez dès à présent vous connecter sur l'espace professionnel du site en vous rendant à l'adresse suivante : http://app.residassur.fr
<br>
<br>
<br>
L'équipe CORIM ASSURANCE
</body>
</html>
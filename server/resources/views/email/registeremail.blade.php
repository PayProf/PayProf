<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coordonnées d'authentification</title>
    <style>
        /* Styles pour le corps de l'email */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        
        /* Styles pour l'en-tête */
        .header {
            background-color: #292929;
            padding: 20px;
            color: #fff;
            text-align: center;
        }
        
        /* Styles pour le contenu principal */
        .content {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
        }
        
        /* Styles pour les informations d'authentification */
        .auth-info {
            margin-bottom: 20px;
        }
        
        /* Styles pour les boutons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Coordonnées d'authentification</h1>
        <img src="/logo.jpeg" alt="Logo de l'entreprise" style="width: 150px; margin-top: 10px;">
    </div>
    <div class="content">
        <h2>Bienvenue dans notre système</h2>
        <p>Cher utilisateur,</p>
        <p>Voici vos coordonnées d'authentification pour accéder à notre plateforme :</p>
        <div class="auth-info">
            <p><strong>Nom d'utilisateur :</strong> {{ $email }}</p>
            <p><strong>Mot de passe :</strong> {{ $password }}</p>
        </div>
        <p>Veuillez le conserver en toute sécurité.</p>
        <p>Merci de votre inscription !</p>
        <p>Cordialement,</p>
        <p>Votre site PAYPROF</p>
        
    </div>
</body>
</html>






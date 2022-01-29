
<html>
    <head>
        <title>Employee CRUD Application</title>
        <style>
            #main{
                font-family: "Arial,sans-serif";
                font-size:'8.5pt';
                color: '#222222';
            }
        </style>
    </head>
    <body>
        <div id='main'>
            <p> Dear {{$details['name']}} </p>
            <p>Your account has been successfully created. The login credentials are:</p>
            <p>Email: {{$details['email']}}</p>
            <p>Password: {{$details['password']}}</p>
            <p>Kind Regards,<br>Employee CRUD Application</p>
        </div>
    </body>
</html>


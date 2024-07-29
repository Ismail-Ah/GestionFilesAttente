<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="globals.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
        .frame {
            background-color: #ffffff;
            display: flex;
            flex-direction: row;
            justify-content: center;
            width: 100%;
            height: 100vh; /* Full height of the viewport */
        }

        .frame .div {
            background-color: #ffffff;
            width: 1366px;
            height: 100vh; /* Full height of the viewport */
            position: relative;
        }

        .frame .image {
            position: absolute;
            width: 691px;
            height: 437px;
            top: 112px;
            left: 564px;
            object-fit: cover;
        }

        .frame .overlap {
            position: absolute;
            width: 171px;
            height: 51px;
            top: 467px;
            left: 130px;
            background-color: #ff3b30;
            border-radius: 34.1px;
        }

        .frame .text-wrapper {
            position: absolute;
            height: 32px;
            top: 8px;
            left: 43px;
            font-family: "Poppins-Bold", Helvetica;
            font-weight: 700;
            color: #ffffff;
            font-size: 21.3px;
            text-align: center;
            letter-spacing: 0;
            line-height: normal;
        }

        .frame .group {
            position: absolute;
            width: 842px;
            height: 51px;
            top: 22px;
            left: 444px;
        }

        .frame .overlap-group-wrapper {
            position: absolute;
            width: 435px;
            height: 43px;
            top: 7px;
            left: 0;
        }

        .frame .overlap-group {
            position: relative;
            height: 43px;
        }

        .frame .head {
            display: flex;
            width: 435px;
            align-items: center;
            justify-content: center;
            gap: 17.05px;
            position: absolute;
            top: 0;
            left: 0;
        }

        .frame .div-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8.53px;
            padding: 8.53px;
            position: relative;
            flex: 1;
            align-self: stretch;
            flex-grow: 1;
        }

        .frame .text-wrapper-2 {
            position: relative;
            width: fit-content;
            margin-top: -0.85px;
            font-family: "Poppins-Regular", Helvetica;
            font-weight: 400;
            color: #000000;
            font-size: 17.1px;
            text-align: center;
            letter-spacing: 0;
            line-height: normal;
        }

        .frame .contact {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            gap: 8.53px;
            padding: 8.53px;
            position: relative;
            flex: 1;
            align-self: stretch;
            flex-grow: 1;
        }

        .frame .text-wrapper-3 {
            position: relative;
            width: fit-content;
            margin-top: -0.85px;
            margin-right: -16.14px;
            font-family: "Poppins-Medium", Helvetica;
            font-weight: 500;
            color: #000000;
            font-size: 17.1px;
            letter-spacing: 0;
            line-height: normal;
        }

        .frame .line {
            position: absolute;
            width: 56px;
            height: 8px;
            top: 35px;
            left: 23px;
        }

        .frame .overlap-2 {
            position: absolute;
            width: 171px;
            height: 51px;
            top: 0;
            left: 480px;
            background-color: #ff3b30;
            border-radius: 34.1px;
        }

        .frame .text-wrapper-4 {
            position: absolute;
            height: 32px;
            top: 9px;
            left: 43px;
            font-family: "Poppins-Bold", Helvetica;
            font-weight: 700;
            color: #ffffff;
            font-size: 21.3px;
            text-align: center;
            letter-spacing: 0;
            line-height: normal;
        }

        .frame .overlap-3 {
            position: absolute;
            width: 171px;
            height: 51px;
            top: 0;
            left: 668px;
            background-color: #ffffff;
            border-radius: 34.1px;
            border: 0.85px solid;
            border-color: #000000;
        }

        .frame .text-wrapper-5 {
            position: absolute;
            height: 32px;
            top: 8px;
            left: 49px;
            font-family: "Poppins-Bold", Helvetica;
            font-weight: 700;
            color: #000000;
            font-size: 21.3px;
            text-align: center;
            letter-spacing: 0;
            line-height: normal;
        }

        .frame .notre-plateforme {
            position: absolute;
            width: 426px;
            height: 208px;
            top: 241px;
            left: 120px;
            font-family: "Poppins-Italic", Helvetica;
            font-weight: 400;
            font-style: italic;
            color: #000000;
            font-size: 17.1px;
            letter-spacing: 0;
            line-height: normal;
        }

        .frame .text-wrapper-6 {
            position: absolute;
            width: 362px;
            height: 59px;
            top: 182px;
            left: 105px;
            font-family: "Poppins-Bold", Helvetica;
            font-weight: 700;
            color: #000000;
            font-size: 30.7px;
            text-align: center;
            letter-spacing: 0;
            line-height: normal;
        }

        .frame .group-2 {
            position: absolute;
            width: 1230px;
            height: 43px;
            top: 590px;
            left: 69px;
        }

        .frame .img {
            position: absolute;
            width: 1228px;
            height: 1px;
            top: -1px;
            left: 0;
        }

        .frame .p {
            position: absolute;
            height: 26px;
            top: 17px;
            left: 422px;
            font-family: "Poppins-Italic", Helvetica;
            font-weight: 400;
            font-style: italic;
            color: #000000;
            font-size: 17.1px;
            letter-spacing: 0;
            line-height: normal;
        }
    </style>
</head>
<body>
    <div class="frame">
        <div class="div">
            <img class="image" src="/img/homepage.png" />
            <div class="overlap"><div class="text-wrapper">Sign Up</div></div>
            <div class="group">
                <div class="overlap-group-wrapper">
                    <div class="overlap-group">
                        <div class="head">
                            <div class="div-wrapper"><div class="text-wrapper-2">Home</div></div>
                            <div class="div-wrapper"><div class="text-wrapper-2">Services</div></div>
                            <div class="div-wrapper"><div class="text-wrapper-2">About</div></div>
                            <div class="contact"><div class="text-wrapper-3">Contact Us</div></div>
                        </div>
                        <img class="line" src="img/line-1.svg" />
                    </div>
                </div>
                <div class="overlap-2"><a class="text-wrapper-4" href="{{ route('register') }}">Sign Up</a></div>
                <div class="overlap-3"><a class="text-wrapper-5" href="{{ route('login') }}">Log In</a></div>
            </div>
            <p class="notre-plateforme">
                Notre plateforme vous permet de gérer efficacement les files d&#39;attente dans divers services. Simplifiez
                votre expérience en planifiant vos visites et en suivant en temps réel l&#39;état de vos demandes. Découvrez
                comment nous pouvons rendre votre journée plus fluide et agréable.
            </p>
            <div class="text-wrapper-6">Bienvenue sur ***** !</div>
        </div>
    </div>
</body>
</html>

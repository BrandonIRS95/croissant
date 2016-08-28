<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, userName, pin');
$headers = getallheaders();

		
		echo '


            {

            "news": [{
                    "id": 1,
                    "content": "Esperamos que este sea un día genial para nuestras queridas compañeras que tienen la dicha y la oportunidad de ser Mamás.",
                    "title": "Feliz día Mamás",
                    "imageUrl": "/001.png",
                    "noticeType": "S"
                }, {
                    "id": 2,
                    "content": "Los esperamos en NOVOFUT.Habrá comida,bebida y premios a la mejor porra.",
                    "title": "Rol de juegos torneo MIND",
                    "imageUrl": "/002.png",
                    "noticeType": "B"
                }, {
                    "id": 3,
                    "content": "Los esperamos este Jueves 31 de Marzo 2016 a las 2:45 p.m. en Mind University!",
                    "title": "¡Pasteles!",
                    "imageUrl": "/003.png",
                    "noticeType": "S"
                }



            ]
        }' ;

?>
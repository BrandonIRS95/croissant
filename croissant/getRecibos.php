<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, userName, pin');
$headers = getallheaders();

		
		echo '{ 
        "NombreColaborador": "ACOSTA\tBELTRAN OMAR EDUARDO",
        "PuestoColaborador": "Leader Mid",
        "EquipoColaborador": "",
        "Recibos": [{
            "FechaInicio": "\/Date(1452902400000)\/",
            "FechaFin": "\/Date(1455494400000)\/",
            "FechaDeposito": "\/Date(1455494400000)\/",
            "Percepcciones": [{
                "Concepto": "Ingreso base",
                "Importe": 1000.0000,
                "TipoPercepcionDeduccion": "P"
            }],
            "Deducciones": [{
                "Concepto": "Retención por ahorro",
                "Importe": 500.0000,
                "TipoPercepcionDeduccion": "D"
            }, {
                "Concepto": "Desayunos",
                "Importe": 160.0000,
                "TipoPercepcionDeduccion": "D"
            }, {
                "Concepto": "Ajustes en contra",
                "Importe": 300.0000,
                "TipoPercepcionDeduccion": "D"
            }],
            "TotalPercepciones": 1000.0000,
            "TotalDeducciones": 960.0000,
            "TotalDepositado": 40.0000
        }, {
            "FechaInicio": "\/Date(1455523200000)\/",
            "FechaFin": "\/Date(1456732800000)\/",
            "FechaDeposito": "\/Date(1456732800000)\/",
            "Percepcciones": [{
                "Concepto": "Ingreso base",
                "Importe": 1000.0000,
                "TipoPercepcionDeduccion": "P"
            }],
            "Deducciones": [{
                "Concepto": "Retención por ahorro",
                "Importe": 500.0000,
                "TipoPercepcionDeduccion": "D"
            }, {
                "Concepto": "Desayunos",
                "Importe": 160.0000,
                "TipoPercepcionDeduccion": "D"
            }, {
                "Concepto": "Ajustes en contra",
                "Importe": 300.0000,
                "TipoPercepcionDeduccion": "D"
            }],
            "TotalPercepciones": 1000.0000,
            "TotalDeducciones": 960.0000,
            "TotalDepositado": 40.0000
        }, {
            "FechaInicio": "\/Date(1456790400000)\/",
            "FechaFin": "\/Date(1459382400000)\/",
            "FechaDeposito": "\/Date(1455494400000)\/",
            "Percepcciones": [{
                "Concepto": "Ingreso base",
                "Importe": 1000.0000,
                "TipoPercepcionDeduccion": "P"
            }, {
                "Concepto": "Apoyo por gimnasio",
                "Importe": 100.0000,
                "TipoPercepcionDeduccion": "P"
            }, {
                "Concepto": "Depositado en tarjeta Gasmart",
                "Importe": 1400.0000,
                "TipoPercepcionDeduccion": "P"
            }],
            "Deducciones": [{
                "Concepto": "Retención por ahorro",
                "Importe": 500.0000,
                "TipoPercepcionDeduccion": "D"
            }, {
                "Concepto": "Utilizado en tarjeta Gasmart",
                "Importe": 1400.0000,
                "TipoPercepcionDeduccion": "D"
            }],
            "TotalPercepciones": 2500.0000,
            "TotalDeducciones": 1900.0000,
            "TotalDepositado": 600.0000
            }, {
            "FechaInicio": "\/Date(1459324800000)\/",
            "FechaFin": "\/Date(1461999600000)\/",
            "FechaDeposito": "\/Date(1461999600000)\/",
            "Percepcciones": [{
                "Concepto": "Ingreso base",
                "Importe": 1000.0000,
                "TipoPercepcionDeduccion": "P"
            }, {
                "Concepto": "Apoyo por gimnasio",
                "Importe": 100.0000,
                "TipoPercepcionDeduccion": "P"
            }, {
                "Concepto": "Depositado en tarjeta Gasmart",
                "Importe": 1400.0000,
                "TipoPercepcionDeduccion": "P"
            }],
            "Deducciones": [{
                "Concepto": "Retención por ahorro",
                "Importe": 500.0000,
                "TipoPercepcionDeduccion": "D"
            }, {
                "Concepto": "Utilizado en tarjeta Gasmart",
                "Importe": 1400.0000,
                "TipoPercepcionDeduccion": "D"
            }],
            "TotalPercepciones": 2500.0000,
            "TotalDeducciones": 1900.0000,
            "TotalDepositado": 600.0000
            }, {
            "FechaInicio": "\/Date(1461999600000)\/",
            "FechaFin": "\/Date(1464591600000)\/",
            "FechaDeposito": "\/Date(1464591600000)\/",
            "Percepcciones": [{
                "Concepto": "Ingreso base",
                "Importe": 1000.0000,
                "TipoPercepcionDeduccion": "P"
            }, {
                "Concepto": "Apoyo por gimnasio",
                "Importe": 100.0000,
                "TipoPercepcionDeduccion": "P"
            }, {
                "Concepto": "Depositado en tarjeta Gasmart",
                "Importe": 1400.0000,
                "TipoPercepcionDeduccion": "P"
            }],
            "Deducciones": [{
                "Concepto": "Retención por ahorro",
                "Importe": 500.0000,
                "TipoPercepcionDeduccion": "D"
            }, {
                "Concepto": "Utilizado en tarjeta Gasmart",
                "Importe": 1400.0000,
                "TipoPercepcionDeduccion": "D"
            }],
            "TotalPercepciones": 2500.0000,
            "TotalDeducciones": 1900.0000,
            "TotalDepositado": 600.0000
            }, {
            "FechaInicio": "\/Date(1464591600000)\/",
            "FechaFin": "\/Date(1467270000000)\/",
            "FechaDeposito": "\/Date(1467270000000)\/",
            "Percepcciones": [{
                "Concepto": "Ingreso base",
                "Importe": 1000.0000,
                "TipoPercepcionDeduccion": "P"
            }, {
                "Concepto": "Apoyo por gimnasio",
                "Importe": 100.0000,
                "TipoPercepcionDeduccion": "P"
            }, {
                "Concepto": "Depositado en tarjeta Gasmart",
                "Importe": 1400.0000,
                "TipoPercepcionDeduccion": "P"
            }],
            "Deducciones": [{
                "Concepto": "Retención por ahorro",
                "Importe": 500.0000,
                "TipoPercepcionDeduccion": "D"
            }, {
                "Concepto": "Utilizado en tarjeta Gasmart",
                "Importe": 1400.0000,
                "TipoPercepcionDeduccion": "D"
            }],
            "TotalPercepciones": 2500.0000,
            "TotalDeducciones": 1900.0000,
            "TotalDepositado": 600.0000
            }]
        }';
				



?>

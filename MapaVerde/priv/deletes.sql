/*Eliminar los datos de los actos*/
DELETE * FROM actos;
/*Eliminar los antecedentes*/
DELETE * FROM antecedentes;
/*Eliminar los departamentos*/
DELETE * FROM departamentos;
/*Eliminar los empleados*/
DELETE * FROM empleados;
/*No eliminar estados por que tienen los mismos estados que son en espera y consulta*/
/*Eliminar los eventos*/
DELETE * FROM eventos;
/*Eliminar la evolucion*/
DELETE * FROM evolucion;
/*Eliminacion de historico*/
DELETE * FROM historico;
/*No eliminaria las mutuas por que son las mismas y no hay una menera facil de insertarlas*/
/*Eliminar los pancientes*/
DELETE * FROM pancientesv2;
/*Eliminar el seguimiento*/
DELETE * FROM seguimiento;
/*Eliminar usuarios excepto admin*/
DELETE * FROM usuarios WHERE usuario =! 'admin';

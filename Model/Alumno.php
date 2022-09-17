<?php 
/**
* 
*/
class Alumno
{
	private $id;
	private $nombres;
	private $apellidos;
	private $estado;

	//CONSTRUCTOR DE LA CLASE ALUMNO
	function __construct($id, $nombres,$apellidos, $estado)
	{
		$this->setId($id);
		$this->setNombres($nombres);
		$this->setApellidos($apellidos);
		$this->setEstado($estado);		
	}
	//METODO PARA OBTENER EL ID
	public function getId(){
		return $this->id;
	}
	//METODO PUBLICO DE PROGRAMACION ORIENTADA A OBJETOS PARA OBTENER EL ID
	public function setId($id){
		$this->id = $id;
	}
	//METODO PARA OBTENER EL NOMBRE

	public function getNombres(){
		return $this->nombres;
	}

	public function setNombres($nombres){
		$this->nombres = $nombres;
	}

	public function getApellidos(){
		return $this->apellidos;
	}

	public function setApellidos($apellidos){
		$this->apellidos = $apellidos;
	}

	public function getEstado(){

		return $this->estado;
	}

	public function setEstado($estado){
		
		if (strcmp($estado, 'on')==0) {
			$this->estado=1;
		} elseif(strcmp($estado, '1')==0) {
			$this->estado='checked';
		}elseif (strcmp($estado, '0')==0) {
			$this->estado='of';
		}else {
			$this->estado=0;
		}

	}

	public static function save($alumno){
		$db=Db::getConnect();
		//var_dump($alumno);   // ESTO SIRVE PARA VER LAS VARIABLES EN EL NAVEGADOR
		//die();  // PARA TERMINAR CON  LA CONEXION
		
		//ESTE ES UN METODO PARA INGRESAR LOS DATOS DEL ALUMNOS
		
		$insert=$db->prepare('INSERT INTO alumno VALUES (NULL, :nombres,:apellidos,:estado)');
		//utilizamos binvalue para evitar  ingreso anomalo de datos como xss o sql injection
	
		$insert->bindValue('nombres',$alumno->getNombres());	
		$insert->bindValue('apellidos',$alumno->getApellidos());
		$insert->bindValue('estado',$alumno->getEstado());
		$insert->execute();  //mketodo encargado de realizar la operacion 
	}

	//funcion encargada de retornar todos los datos de los alumnos
	public static function all(){
		$db=Db::getConnect();
		
		//arreglo en php 
		$listaAlumnos=[];
		//hacemos una consulta sql a la base de datos
		$consulta=$db->query('SELECT * FROM alumno order by id');

		foreach($consulta->fetchAll() as $alumno){
			$listaAlumnos[]=new Alumno($alumno['id'],$alumno['nombres'],$alumno['apellidos'],$alumno['estado']);
		}
		return $listaAlumnos;
	}

	//funcion encargadda de buscar por id

	public static function searchById($id){
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM alumno WHERE id=:id');
		$select->bindValue('id',$id);
		$select->execute();

		$alumnoDb=$select->fetch();  //devuelve el registro de la busqueda

		//lo pasamos a la clase alumno para manejarlo mas facil
		$alumno = new Alumno ($alumnoDb['id'],$alumnoDb['nombres'], $alumnoDb['apellidos'], $alumnoDb['estado']);
		//var_dump($alumno);
		//die();
		//retornamos el alumno
		return $alumno;

	}

	public static function update($alumno){
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE alumno SET nombres=:nombres, apellidos=:apellidos, estado=:estado WHERE id=:id');
		$update->bindValue('nombres', $alumno->getNombres());
		$update->bindValue('apellidos',$alumno->getApellidos());
		$update->bindValue('estado',$alumno->getEstado());
		$update->bindValue('id',$alumno->getId());
		$update->execute();
	}

	//esta funcion es necesario validarla de forma correcta debido a que eliminar un objeto puede causar problemas con el sistema

	public static function delete($id){
		$db=Db::getConnect();
		$delete=$db->prepare('DELETE  FROM alumno WHERE id=:id');
		$delete->bindValue('id',$id);
		$delete->execute();		
	}
}

?>
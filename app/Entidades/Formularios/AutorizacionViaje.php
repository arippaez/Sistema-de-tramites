<?php 

namespace App\Entidades\Formularios;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;


class AutorizacionViaje extends Model{
	protected $table = 'valores';
	public $timestamps = false;

    private $aIdCampos = array(
        "nombremadre" => 18,
        "nombrepadre" => 19,
        "nombremenor" => 20,
        "pais" => 21,
        "tiempo" => 22,
        "viajaacompañado" => 32,

    );

	protected $fillable = [
		'nombremadre','nombrepadre','nombremenor','pais','tiempo','viajaacompañado'
	];

    protected $hidden = ['idtramite'];
	
	public function cargarDesdeRequest($request) {
        $this->idtramite = $request->input('id')!= "0" ? $request->input('id') : $this->idtramite;
        $this->nombremadre = $request->input('txtNombreMadre');
        $this->nombrepadre = $request->input('txtNombrePadre');
        $this->nombremenor = $request->input('txtNombreMenor');
        $this->pais = $request->input('lstPais');
        $this->tiempo = $request->input('txtTiempo');
        $this->viajaacompañado = $request->input('txtViajaAcompañado');
    }

    public function obtenerPorId($id){
          $sql = "SELECT
                idvalor,
                fk_idtramite,
                fk_idcampo,
                valor
                FROM valores WHERE fk_idtramite = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idtramite = $id;
            foreach($lstRetorno as $fila){
                foreach($this->aIdCampos as $campo => $fk_idcampo){
                    if($fila->fk_idcampo == $fk_idcampo){
                        $this->$campo = $fila->valor; 
                    }
                }
            }
            return $this;
        }
        return null;
    }

   public function insertar() {
        foreach($this->fillable as $campo){
            $sql = "INSERT INTO valores (
                fk_idtramite,
                fk_idcampo,
                valor
            ) VALUES (?, ?, ?);";
            $result = DB::insert($sql, [
                $this->idtramite,
                $this->aIdCampos[$campo],
                $this->$campo
            ]);
            $idvalor = DB::getPdo()->lastInsertId();
        }
    }
    public function guardar($idTramite) {
         foreach ($this as $campo => $valor) {
            $sql = "UPDATE valores SET
                valor='$valor'
            WHERE idvalores= ? AND campo = ?"; 
            $affected = DB::update($sql, [$idTramite, $campo]);
        }
    }
    public  function eliminar() {
        $sql = "DELETE FROM valores WHERE 
            fk_idtramite = ?";
        $affected = DB::delete($sql, [$this->fk_idtramite]);
    }

}

?>
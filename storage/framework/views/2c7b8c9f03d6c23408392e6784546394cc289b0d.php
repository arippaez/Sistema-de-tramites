<?php $__env->startSection('titulo', "Datos del área"); ?>
<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('css/datatables.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/datatables.min.js')); ?>"></script>
<script>
    globalId = '<?php echo isset($grupo->idarea) && $grupo->idarea > 0 ? $grupo->idarea : 0; ?>';
    <?php $globalId = isset($grupo->idarea) ? $grupo->idarea : "0"; ?>

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/grupos">Áreas</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/grupo/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/grupos";
}
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="row">
    <div id = "msg"></div>
    <?php
    if (isset($msg)) {
        echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
    }
    ?>
</div>
<form id="form1" method="POST">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
    <input type="hidden" id="id" name="id" class="form-control" value="<?php echo e($globalId); ?>" required>
    <div class="row">
        <div class="form-group col-lg-6">
            <label>Nombre: *</label>
            <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="<?php echo e(isset($grupo->descarea) ? $grupo->descarea : ''); ?>" required>
        </div>
        <div class="form-group col-lg-6">
            <label>Nombre corto: *</label>
            <input type="text" id="txtNombreCorto" name="txtNombreCorto" class="form-control" value="<?php echo e(isset($grupo->ncarea) ? $grupo->ncarea : ''); ?>" required>
        </div>
        <div class="form-group col-lg-6">
            <label>Activo: *</label>
            <select id="lstEstado" name="lstEstado" class="form-control" required>
                <option value="" disabled selected>Seleccionar</option>
                <option value="1" <?php echo e(isset($grupo) && $grupo->activo == 1? 'selected' : ''); ?>>Si</option>
                <option value="0" <?php echo e(isset($grupo) &&$grupo->activo == 0? 'selected' : ''); ?>>No</option>
            </select>
        </div>
    </div> 
</form>
<script>

    //Define constantes
    globalId = '<?php echo (isset($_REQUEST["id"]) ? $_REQUEST["id"] : "0"); ?>';

    $("#form1").validate();
   

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit(); 
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
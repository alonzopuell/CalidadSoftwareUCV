<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h2>Agregar Nuevo Proveedor</h2>
    
    <form action="index.php?controller=ProveedorController&action=agregar" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="contacto">Contacto:</label>
            <input type="text" class="form-control" id="contacto" name="contacto">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <textarea class="form-control" id="direccion" name="direccion" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php?controller=ProveedorController&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
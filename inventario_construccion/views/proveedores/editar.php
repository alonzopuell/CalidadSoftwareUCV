<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h2>Editar Proveedor</h2>
    
    <form action="index.php?controller=ProveedorController&action=editar&id=<?php echo $this->proveedor->id; ?>" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $this->proveedor->nombre; ?>" required>
        </div>
        <div class="form-group">
            <label for="contacto">Contacto:</label>
            <input type="text" class="form-control" id="contacto" name="contacto" value="<?php echo $this->proveedor->contacto; ?>">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $this->proveedor->telefono; ?>">
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <textarea class="form-control" id="direccion" name="direccion" rows="3"><?php echo $this->proveedor->direccion; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php?controller=ProveedorController&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
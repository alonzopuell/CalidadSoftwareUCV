<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h2>Editar Producto</h2>
    
    <form action="index.php?controller=ProductoController&action=editar&id=<?= $this->producto->id ?>" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" 
                   value="<?= htmlspecialchars($this->producto->nombre) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= 
                   htmlspecialchars($this->producto->descripcion) ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="categoria_id">Categoría:</label>
            <select class="form-control" id="categoria_id" name="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                <?php while ($categoria = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= $categoria['id'] ?>" 
                    <?= ($categoria['id'] == $this->producto->categoria_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="proveedor_id">Proveedor:</label>
            <select class="form-control" id="proveedor_id" name="proveedor_id" required>
                <option value="">Seleccione un proveedor</option>
                <?php while ($proveedor = $proveedores->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= $proveedor['id'] ?>" 
                    <?= ($proveedor['id'] == $this->producto->proveedor_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($proveedor['nombre']) ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock" 
                   value="<?= htmlspecialchars($this->producto->stock) ?>" min="0" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php?controller=ProductoController&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>